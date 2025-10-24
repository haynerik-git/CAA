<?php

namespace App\Controller;

use App\Entity\PageTranslation;
use App\Repository\CategoriesRepository;
use App\Repository\PageTranslationRepository;
use App\Repository\UserRepository;
use App\Repository\UserCategoriesRepository;
use App\Repository\UserCategorieWordsRepository;
use App\Repository\UserCategoriesOrderRepository;
use App\Repository\PageOrderRepository;
use App\Repository\PageRepository;
use App\Repository\WordRepository;
use App\Repository\WordConfigurationRepository;
use App\Repository\WordTranslationRepository;
use App\Repository\SentencesRepository;
use App\Repository\ActionRepository;
use App\Repository\LangRepository;
use App\Entity\UserCategorieWords;
use App\Entity\UserCategoriesOrder;
use App\Entity\PageOrder;
use App\Entity\Page;
use App\Entity\Word;
use App\Entity\WordTranslation;
use App\Entity\Sentences;
use App\Entity\UserCategories;
//use Doctrine\Inflector\Rules\Word;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Filesystem;
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(WordRepository $word,PageRepository $page, SessionInterface $session, Request $request): Response
    {
        if(!$session->has('lang'))
            $session->set('lang', 1);
        $post_data = json_decode($request->getContent(), true);
        $ajax = false;
        if(!empty($post_data) && array_key_exists('ajax', $post_data))
            $ajax = $post_data['ajax'];


//        dd($post_data);
        $res = $page->findPageByOrder();
        $wordsSession = $session->get('words');
//        dd($wordsSession);

        if(empty($wordsSession)) {
            $wordsSession = $words = [];
            $session->set('words',[]);
        }
        $cat = ["id"=>0];
        foreach ($wordsSession as $wordObj) {
            $words[] =  $word->find($wordObj['id']);
        }

        return $this->render('index/index.html.twig', [
            'words' => $words,
            'cat' => $cat,
            'pages' => $res,
            'ajax' => $ajax,
        ]);
    }

    #[Route('/grids', name: 'app_grids')]
    public function grids(CategoriesRepository $cat, SessionInterface $session): Response
    {
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $cat->find(1);
//        dd($res);
        return $this->render('index/gridsMasonry.html.twig', [
            'cats' => $res,
        ]);
    }

    #[Route('/centro', name: 'app_centre')]
    public function centro(CategoriesRepository $cat, SessionInterface $session): Response
    {
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $cat->find(1);
//        dd($res);
//        return $this->render('index/grids.html.twig', [
        return $this->render('index/rowCell.html.twig', [
            'cats' => $res,
        ]);
    }

    #[Route('/page/{id}', name: 'app_page')]
    public function page(int $id ,WordRepository $word, PageRepository $page, UserCategoriesRepository $userCategoriesRepository, SessionInterface $session): Response
    {
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $page->find($id);
        $pages = $page->findAll();
        $cats = $userCategoriesRepository->findAll();
        $res2 = $res->getPageOrders();

        $wordsSession = $session->get('words');
//        $wordsSession = $session->set('words', []);
        if(empty($wordsSession))
            $wordsSession = $words = [];

//        dd($wordsSession);
        $cat = ["id"=>0];
        foreach ($wordsSession as $wordObj) {
            $words[] =  $word->find($wordObj['id']);
        }

        return $this->render('index/rowCellByPage.html.twig', [
            'words' => $words,
            'cat' => $cat,
            'pageOrders' => $res2,
            'pages' => $pages,
            'cats' => $cats,
            'col' => $res->getNbCol(),
            'row' => $res->getNbRow(),
            'page' => $res,
        ]);
    }

    #[Route('/pageAjax/{id}', name: 'app_pageAjax')]
    public function pageAjax(int $id ,WordRepository $word, PageRepository $page, UserCategoriesRepository $userCategoriesRepository, SessionInterface $session, Request $request): Response
    {
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $post_data = json_decode($request->getContent(), true);

        $res = $page->find($id);
        $prev = $res->getDisplayOrder();
        $next = $res->getDisplayOrder();
        if(array_key_exists('prevPage', $post_data)) {
            $prev = $post_data['prevPage'];
            $nextPage = null;
            $prevPage = $page->find($prev);
//            dd($post_data);
        }
        else {
            $nextPage = $page->findNextByOrder($next);
            $prevPage = $page->findPrevByOrder($prev);
        }


//dd($res->getDisplayOrder());
//        $pages = $page->findAll();

//        dd($prevPage);
        $cats = []; //$userCategoriesRepository->findAll();
        $res2 = $res->getPageOrders();

        $wordsSession = $session->get('words');
//        $wordsSession = $session->set('words', []);
        if(empty($wordsSession))
            $wordsSession = $words = [];

        $lastIndex = array_key_last($post_data['lastWord']);
        $wordsSession = array_merge($session->get('words'), array($post_data['lastWord'][$lastIndex]));

//        dd($wordsSession);
        $cat = ["id"=>0];
        foreach ($wordsSession as $wordObj) {
            if($wordObj['type'] == 'word' )
                $words[] =  $word->find($wordObj['id']);
            elseif ($wordObj['type'] == 'categorie' )
                $words[] =  $page->find($wordObj['id']);

        }
//dd($words);
        return $this->render('index/pageAjax.html.twig', [
            'words' => $words,
            'cat' => $cat,
            'pageOrders' => $res2,
//            'pages' => $pages,
            'cats' => $cats,
            'col' => $res->getNbCol(),
            'row' => $res->getNbRow(),
            'page' => $res,
            'nextPage' => $nextPage,
            'prevPage' => $prevPage,
        ]);
    }

    #[Route('/pagePrinter/{id}', name: 'app_pagePrinter')]
    public function pagePrinter(int $id ,PageRepository $page, UserCategoriesRepository $userCategoriesRepository, SessionInterface $session): Response
    {
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $page->find($id);
        $pages = $page->findAll();
        $cats = $userCategoriesRepository->findAll();
        $res2 = $res->getPageOrders();


        return $this->render('index/pagePrinter.html.twig', [
            'pageOrders' => $res2,
            'pages' => $pages,
            'cats' => $cats,
            'col' => $res->getNbCol(),
            'row' => $res->getNbRow(),
            'page' => $res,
        ]);
    }


    #[Route('/categorieEditor', name: 'categorieEditor')]
    public function categorieEditor(WordConfigurationRepository $configurationRepository, PageRepository $pageRepository,WordRepository $word,UserCategoriesOrderRepository $userCategoriesOrderRepository, UserCategoriesRepository $userCategoriesRepository,SentencesRepository $sentencesRepository,LangRepository $langRepository,ActionRepository $actionRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
//        dd($cat);
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $cat = $userCategoriesRepository->find($id);
        $res2 = $cat->getUserCategoriesOrders();
        $res = $pageRepository->find(2);
//        $res2 = $res->getPageOrders();
        $wordsList =  []; //$word->findAll();
        $catsList = $userCategoriesRepository->findAll();
        $config = $configurationRepository->findAll();
        $sentencesList = []; //$sentencesRepository->findAll();
        $langs = $langRepository->findAll();
        $actions = $actionRepository->findAll();

//dd($res->getPageOrders());
        return $this->render('index/categorieEditor.html.twig', [
            'page' => $res,
            'pageOrders' => $res2,
            'cat' => $cat,
            'words' => $wordsList,
            'cats' => $catsList,
            'sentences' => $sentencesList,
            'col' => 5,
            'row' => 5,
            'langs' => $langs,
            'actions' => $actions,
            'config' => $config,
        ]);
    }

    #[Route('/categorieOldEditor', name: 'categorieOldEditor')]
    public function categorieOldEditor(UserCategoriesRepository $cat,WordRepository $word, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $cat->find($id);
        $wordsList = $word->findAll();

        return $this->render('index/categorieEditor.html.twig', [
            'idCat' => $id,
            'cat' => $res,
            'words' => $wordsList,
        ]);
    }

    #[Route('/categorieEditor/editTitleCat', name: 'categorieEditorEditTitleCat')]
    public function categorieEditorEditTitleCat(EntityManagerInterface $entityManager, UserCategoriesRepository $categoriesRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
        $title = $request->get('title');
        $idCat = $request->get('idCat');

        $catUser = $categoriesRepository->find($idCat);
        $catUser->setLabel($title);
        $entityManager->persist($catUser);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
//        dd($idWord);
        if(!$session->has('lang'))
            $session->set('lang', 1);
        exit();
        return $this->render('index/part/wordEdit.html.twig', [
            'word' => [],
            'deleteId' => $catUser->getId()
        ]);
    }

    #[Route('/categorieEditor/addWord', name: 'categorieEditorAddWord')]
    public function categorieEditorAddWord(EntityManagerInterface $entityManager,LangRepository $langRepository,SentencesRepository $sentencesRepository, UserCategoriesRepository $userCategoriesRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
        $idCat = $request->get('idCat');
        $order = $request->get('order');
        $type = $request->get('type');
        $word = '';
        $sentence = '';
        $catRes = '';
        $editId = 0;
        $langs = $langRepository->findAll();


        $cat = $userCategoriesRepository->find($idCat);
        $catUser = new UserCategoriesOrder();
        $catUser->setCategorie($cat);
        $catUser->setType($type);

        if($type == 'word') {
            $word = $wordRepository->find($id);
            $catUser->setWord($word);
            $template = 'index/part/wordEdit.html.twig';
        }
        elseif ($type == 'sentence') {
            $sentence = $sentencesRepository->find($id);
            $catUser->setSentence($sentence);
            $template = 'index/part/sentenceEdit.html.twig';
        }
        elseif ($type == 'categorie') {
            $catRes = $userCategoriesRepository->find($id);
            $catUser->setNextCategorie($catRes);
            $template = 'index/part/categorieEdit.html.twig';
        }
        elseif ($type == 'empty') {
//            $cat = $userCategoriesRepository->find($id);
//            $pageOrder->setUserCategories($cat);
            $template = 'index/part/emptyEdit.html.twig';
        }

        $catUser->setOrderDisplay($order);
        $entityManager->persist($catUser);
        $entityManager->flush();

        if(!$session->has('lang'))
            $session->set('lang', 1);

        return $this->render($template, [
            'idCat' => $idCat,
            'word' => $word,
            'cat' => $catRes,
            'sentence' => $sentence,
            'deleteId' => $catUser->getId(),
            'editId' => $id,
            'langs' => $langs,
        ]);
    }

    #[Route('/categorieEditor/delete', name: 'categorieEditorDeleteWord')]
    public function categorieEditorDeleteWord(EntityManagerInterface $entityManager,UserCategoriesOrderRepository $userCategoriesOrderRepository, UserCategorieWordsRepository $categoriesWordRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
        $idCat = $request->get('idCat');
        $order = $request->get('order');

        $catWord = $userCategoriesOrderRepository->find($id);


        $entityManager->remove($catWord);
        $entityManager->flush();
//        dd($idWord);
        if(!$session->has('lang'))
            $session->set('lang', 1);

        exit();
    }
    #[Route('/categorieEditor/updateWordOrder', name: 'categorieEditorUpdateWordOrder')]
    public function categorieEditorUpdateWordOrder(EntityManagerInterface $entityManager,UserCategoriesOrderRepository $userCategoriesOrderRepository, UserCategorieWordsRepository $UserCategorieWordsRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
//        $order = json_decode($request->get('order'));
        foreach ($request->get('order') as $key => $order) {

            $pageOrder = $userCategoriesOrderRepository->find($order['pageOrderId']);
            $pageOrder->setOrderDisplay($key);
            $entityManager->persist($pageOrder);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }


   exit();
    }


    #[Route('/pageEditor', name: 'pageEditor')]
    public function pageOrderEditor(WordConfigurationRepository $configurationRepository, PageRepository $pageRepository,WordRepository $word, UserCategoriesRepository $userCategoriesRepository,SentencesRepository $sentencesRepository,LangRepository $langRepository,ActionRepository $actionRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
//        dd($cat);
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $pageRepository->find($id);
        $pages = $pageRepository->findAll();
        $res2 = $res->getPageOrders();
        $wordsList = [];//$word->findBy([],['name' => 'ASC']);
        $catsList = $userCategoriesRepository->findBy([],['label' => 'ASC']);
//        $catsList =  $userCategoriesRepository->findBy([],['label' => 'ASC']);
        $sentencesList = [];//$sentencesRepository->findAll();
        $config = $configurationRepository->findAll();
        $langs = $langRepository->findAll();
        $actions = $actionRepository->findAll();

//dd($res->getPageOrders());
        return $this->render('index/pageEditor.html.twig', [
            'page' => $res,
            'pageOrders' => $res2,
            'words' => $wordsList,
            'cats' => $catsList,
            'sentences' => $sentencesList,
            'col' => $res->getNbCol(),
            'row' => $res->getNbRow(),
            'langs' => $langs,
            'actions' => $actions,
            'config' => $config,
            'pages' => $pages
        ]);
    }


    #[Route('/pageOrderAjaxEditor', name: 'pageOrderAjaxEditor')]
    public function pageOrderAjaxEditor(WordConfigurationRepository $configurationRepository, PageRepository $pageRepository,WordRepository $word, UserCategoriesRepository $userCategoriesRepository,SentencesRepository $sentencesRepository,LangRepository $langRepository,ActionRepository $actionRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
//        dd($cat);
        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $pageRepository->find($id);
        $res2 = $res->getPageOrders();
        $wordsList = [];//$word->findBy([],['name' => 'ASC']);
        $catsList = $userCategoriesRepository->findBy([],['label' => 'ASC']);
//        $catsList =  $userCategoriesRepository->findBy([],['label' => 'ASC']);
        $sentencesList = [];//$sentencesRepository->findAll();
        $config = $configurationRepository->findAll();
        $langs = $langRepository->findAll();
        $actions = $actionRepository->findAll();

//dd($res->getPageOrders());
        return $this->render('index/pageOrderEditor.html.twig', [
            'page' => $res,
            'pageOrders' => $res2,
            'words' => $wordsList,
            'cats' => $catsList,
            'sentences' => $sentencesList,
            'col' => $res->getNbCol(),
            'row' => $res->getNbRow(),
            'langs' => $langs,
            'actions' => $actions,
            'config' => $config
        ]);
    }

    #[Route('/searchResult', name: 'searchResult')]
    public function searchResult(PageRepository $pageRepository,WordRepository $word, UserCategoriesRepository $userCategoriesRepository,SentencesRepository $sentencesRepository,LangRepository $langRepository,ActionRepository $actionRepository, SessionInterface $session,Request $request): Response
    {
        $search = $request->get('search');
//        dd($search);
        if(!$session->has('lang'))
            $session->set('lang', 1);
        $pages = $pageRepository->search($search, $session->get('lang'));
//        $res = $pageRepository->find($id);
//        $res2 = $res->getPageOrders();
        $wordsList = $word->search($search, $session->get('lang'));
        $catsList = $userCategoriesRepository->search($search);
//        $catsList =  $userCategoriesRepository->findBy([],['label' => 'ASC']);
        $sentencesList = [];//$sentencesRepository->findAll();
        $langs = $langRepository->findAll();
        $actions = $actionRepository->findAll();


        return $this->render('index/part/searchResult.html.twig', [
            'words' => $wordsList,
            'cats' => $catsList,
            'sentences' => $sentencesList,
            'langs' => $langs,
            'actions' => $actions,
            'pages' => $pages
        ]);
    }


    #[Route('/pageEditor/updateImage', name: 'pageEditorUpdateImage')]
    public function pageEditorUpdateImage(WordConfigurationRepository $configurationRepository, EntityManagerInterface $entityManager,WordTranslationRepository $wordTranslationRepository,LangRepository $langRepository, PageRepository $pageRepository,WordRepository $wordRepository, UserCategoriesRepository $categoriesRepository, SentencesRepository $sentencesRepository, UserRepository $userRepository, SessionInterface $session,Request $request, Filesystem $filesystem, PageTranslationRepository $pageTranslationRepository): Response
    {
            $id = $request->get('id');
            $content = $request->get('img');
            $action = $request->get('action');
            $name = $request->get('name');
            $type = $request->get('type');
            $typeConfig = $request->get('typeConfig');
            $user = $userRepository->find(1);
            $langs = $langRepository->findAll();


            if ( !empty($content) ) {
                $nameFile = str_replace(' ', '_', $request->get('name'));
                $fileName = '../assets/images/' . $id . '-' . $nameFile . '.png';
                $content = str_replace('data:image/png;base64,', '', $content);
                $content = str_replace(' ', '+', $content);
                $filesystem->touch($fileName);
                $filesystem->dumpFile($fileName, base64_decode($content));
            }


            if( $type == 'page') {
                $repo = $pageRepository;
                $obj = new Page();
                if ($action == 'edit' ) {
                    $obj = $repo->find($id);
                } else {
                    $obj->setAutoSpeak(0);
                    $obj->setNbRow(2);
                    $obj->setNbCol(2);
                }
                $obj->setTitle($name);
                $obj->setUser($user);

                if ( !empty($content) ) {
                    $obj->setFileName($id . '-' . $nameFile . '.png');
                }

//                $typeConfigObj = $configurationRepository->find($typeConfig);
//                $obj->setType($typeConfigObj);
                foreach ($langs as $lang) {
                    $wordTrad = $pageTranslationRepository->findOneBy(
                        [
                            'lang' => $lang,
                            'page' => $obj
                        ]
                    );
                    if ( empty($wordTrad) ) {
                        $wordTrad = new PageTranslation();
                        $wordTrad->setLang($lang);
                        $wordTrad->setPage($obj);
                    }
                    if ( !empty($request->get($lang->getName())) ) {
                        $wordTrad->setName($request->get($lang->getName()));
                        $entityManager->persist($wordTrad);
                    }
                }

            } elseif ( $type == 'word') {
                $repo = $wordRepository;
                $obj = new Word();
                if ($action == 'edit' ) {
                    $obj = $repo->find($id);
                }
                $obj->setName($name);
                if ( !empty($content) ) {
                    $obj->setFileName($id . '-' . $nameFile . '.png');
                }
                $obj->setDisplayOrder(0);

                $typeConfigObj = $configurationRepository->find($typeConfig);
                $obj->setType($typeConfigObj);
                foreach ($langs as $lang) {
                    $wordTrad = $wordTranslationRepository->findOneBy(
                        [
                            'lang' => $lang,
                            'wordTranslation' => $obj
                        ]
                    );
                    if ( empty($wordTrad) ) {
                        $wordTrad = new WordTranslation();
                        $wordTrad->setLang($lang);
                        $wordTrad->setWordTranslation($obj);
                    }
                    if ( !empty($request->get($lang->getName())) ) {
                        $wordTrad->setName($request->get($lang->getName()));
                        $entityManager->persist($wordTrad);
                    }
                }

            } elseif ( $type == 'categorie') {
                $repo = $categoriesRepository;
                $obj = new UserCategories();
                if ($action == 'edit' ) {
                    $obj = $repo->find($id);
                }
                $obj->setLabel($name);
                if ( !empty($content) ) {
                    $obj->setImg($id . '-' . $nameFile . '.png');
                }
                $typeConfigObj = $configurationRepository->find($typeConfig);
                $obj->setType($typeConfigObj);
                $obj->setUserId($user);
            } elseif ( $type == 'sentence') {
                $repo = $sentencesRepository;
                $obj = new Sentences();
                if ($action == 'edit' ) {
                    $obj = $repo->find($id);
                }
                $obj->setLabel($name);
                if ( !empty($content) ) {
                    $obj->setImg($id . '-' . $nameFile . '.png');
                }
                $obj->setUserId($user);
            }

            $entityManager->persist($obj);
            $entityManager->flush();


        exit('finis');
    }

    #[Route('/pageEditor/updateValue', name: 'pageEditorUpdateValue')]
    public function pageEditorUpdateValue(EntityManagerInterface $entityManager, PageRepository $pageRepository,WordRepository $wordRepository, SessionInterface $session,Request $request, Filesystem $filesystem): Response
    {
        $id = $request->get('id');
        $key = $request->get('key');
        $value = $request->get('value');


        $page = $pageRepository->find($id);
        if( $key == '--row') {
            $page->setNbRow($value);
        }
        elseif ( $key == '--column') {
            $page->setNbCol($value);
        }
        elseif ( $key == '--background') {
            $page->setBackground($value);
        }
        elseif ( $key == '--fontFamily') {
            $page->setFont($value);
        }
        elseif ( $key == '--backgroundCell') {
            $page->setBackgroundCell($value);
        }
        elseif ( $key == '--border') {
            $page->setBorder($value);
        }
        elseif ( $key == '--colorDescription') {
            $page->setCOlorDescription($value);
        }

//        $page->setFileName($id.'-'.$name . '.png');

        $entityManager->persist($page);
        $entityManager->flush();


        exit();
    }

    #[Route('/pageEditor/addWord', name: 'pageEditorAddWord')]
    public function pageEditorAddWord(EntityManagerInterface $entityManager,LangRepository $langRepository,SentencesRepository $sentencesRepository, PageRepository $pageRepository, PageOrderRepository $pageOrderRepository,WordRepository $wordRepository, UserCategoriesRepository $userCategoriesRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
        $idPage = $request->get('idPage');
        $order = $request->get('order');
        $type = $request->get('type');
        $word = '';
        $sentence = '';
        $cat = '';

        $page = $pageRepository->find($idPage);
        $pageOrder = new PageOrder();
        $pageOrder->setPage($page);
        $pageOrder->setType($type);
        $pageOrder->setTargetId(0);
        $langs = $langRepository->findAll();
        if($type == 'word') {
            $word = $wordRepository->find($id);
            $pageOrder->setWord($word);
            $template = 'index/part/wordEdit.html.twig';
        }
        elseif ($type == 'sentence') {
           $sentence = $sentencesRepository->find($id);
            $pageOrder->setSentence($sentence);
            $template = 'index/part/sentenceEdit.html.twig';
        }
        elseif ($type == 'categorie') {
            $cat = $userCategoriesRepository->find($id);
            $pageOrder->setUserCategories($cat);
            $template = 'index/part/categorieEdit.html.twig';
        }
        elseif ($type == 'page') {
            $page = $pageRepository->find($id);
            $pageOrder->setPagePicto($page);
            $template = 'index/part/pageEdit.html.twig';
//            dd($template);
        }
        elseif ($type == 'empty') {
//            $cat = $userCategoriesRepository->find($id);
//            $pageOrder->setUserCategories($cat);
            $template = 'index/part/emptyEdit.html.twig';
        }

        $pageOrder->setOrderDisplay($order);
        $entityManager->persist($pageOrder);
        $entityManager->flush();

        if(!$session->has('lang'))
            $session->set('lang', 1);

        return $this->render($template, [
            'idCat' => $idPage,
            'word' => $word,
            'cat' => $cat,
            'page' => $page,
            'sentence' => $sentence,
            'editId' => $pageOrder->getId(),
            'deleteId' => $pageOrder->getId(),
            'langs' => $langs
        ]);
    }

    #[Route('/pageEditor/update', name: 'pageEditorUpdate')]
    public function pageEditorUpdate(EntityManagerInterface $entityManager,PageRepository $pageRepository, UserCategorieWordsRepository $categoriesWordRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
        $title = $request->get('title');

        $page = $pageRepository->find($id);
        $page->setTitle($title);
        $entityManager->persist($page);
        $entityManager->flush();

        exit();
    }
    #[Route('/pageEditor/delete', name: 'pageEditorDelete')]
    public function pageEditorDelete(EntityManagerInterface $entityManager,PageOrderRepository $pageOrderRepository, UserCategorieWordsRepository $categoriesWordRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
        $catWord = $pageOrderRepository->find($id);

        $entityManager->remove($catWord);
        $entityManager->flush();

        exit();
    }

    #[Route('/pageEditor/hide', name: 'pageEditorHide')]
    public function pageEditorHide(EntityManagerInterface $entityManager,PageOrderRepository $pageOrderRepository, UserCategorieWordsRepository $categoriesWordRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
        $page = $pageOrderRepository->find($id);
        if($page->isHidden())
            $page->setHidden(false);
        else
            $page->setHidden(true);
//        $entityManager->remove($catWord);
        $entityManager->persist($page);
        $entityManager->flush();

        exit();
    }

    #[Route('/pageEditor/updatePageOrder', name: 'pageEditorUpdatePageOrder')]
    public function pageEditorUpdatePageOrder(EntityManagerInterface $entityManager, PageOrderRepository $pageOrderRepository,WordRepository $wordRepository, SessionInterface $session,Request $request): Response
    {
//        $order = json_decode($request->get('order'));
        foreach ($request->get('order') as $key => $order) {

            $pageOrder = $pageOrderRepository->find($order['pageOrderId']);
            $pageOrder->setOrderDisplay($key);
            $entityManager->persist($pageOrder);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        exit();
    }



    #[Route('/pictoPrinter', name: 'pictoPrinter')]
    public function pictoPrinter(CategoriesRepository $cat,  SessionInterface $session,Request $request): Response
    {
        $id = $request->get('id');
//        dd($cat);

        if(!$session->has('lang'))
            $session->set('lang', 1);

        $res = $cat->find($id);
//        dd($res);
        return $this->render('index/pictoPrinter.html.twig', [
            'cat' => $res,
        ]);
    }

    #[Route('/nextCategorie', name: 'app_index_nextCaterie')]
    public function nextCategorie(Request $request,CategoriesRepository $cat, SessionInterface $session): Response
    {

        $post_data = json_decode($request->getContent(), true);
//        $session->set('words', $post_data);
        $res1 = $cat->findByWord($post_data);
        $res2 = $cat->findByCategories($post_data["lastCategorie"]);
        $res = array_merge($res1,$res2);
        $categorieRework = [];
        $actionGroup = false;
//        echo count($res1).'---';
//        echo count($res2);
//        var_dump($post_data);
//        die($post_data["lastCategorie"]);
        foreach ($res as $re) {
            if (str_contains($re->getName(), 'action')) {
                if ( $actionGroup ) {
                    foreach ( $re->getWordCategories() as $word ) {
//                        echo $word->getName();
                        $categorieRework['action']->addWordCategory($word);
                    }
                }else {
                    $categorieRework['action'] = $re;
                    $actionGroup = true;
                }

            } else {
                $categorieRework[] = $re;
            }
        }
        usort($categorieRework,function($first,$second){
            return $first->getDisplayOrder() > $second->getDisplayOrder();
        });
      //  usort($categorieRework, fn($a, $b) => return $a->display_order < $b->display_order);
        return $this->render('index/nextCategorie.html.twig', [
            'cats' => $categorieRework,
            'level' => $post_data['level']
        ]);
    }

    #[Route('/saveWords', name: 'app_index_saveWords')]
    public function saveWords(Request $request,WordRepository $word, SessionInterface $session)
    {
        $wordsNeeded = $session->get('words');

        if(empty($session->get('saveWords')))
            $wordsSession = $words = [];
        else
            $wordsSession = $session->get('saveWords');

        $saveWords = array_merge($wordsSession, array($wordsNeeded));

        $session->set('saveWords', $saveWords );
//        dd();
        return [];
    }


    #[Route('/RenderSaveWords', name: 'app_index_renderSaveWords')]
    public function renderSaveWords(Request $request,WordRepository $word, SessionInterface $session): Response
    {
        $saveWords = $session->get('saveWords');

        if(empty($session->get(  'saveWords')))
            $saveWords = $wordsResult = [];

        foreach ($saveWords as $key => $wordListObj) {
            foreach ($wordListObj as $key2 => $wordObj) {
                $wordsResult[$key][$key2] =  $word->find($wordObj['id']);
            }
        }

        $cat = ["id"=>0];
        return $this->render('index/renderSaveWords.html.twig', [
            'saveWords' => $saveWords,
            'wordsResult' => $wordsResult,
            'cat' => $cat,
        ]);
    }

    #[Route('/listWord', name: 'app_index_listWord')]
    public function listWord(Request $request,WordRepository $word, SessionInterface $session): Response
    {

        $post_data = json_decode($request->getContent(), true);

        $wordsNeeded = $session->get('words');
        if(array_key_exists('removeWord', $post_data)) {
            array_splice($wordsNeeded, $post_data['removeWord'] - 1, 1);
        }
        elseif(array_key_exists('clean', $post_data)) {
            $wordsNeeded = [];
        }
         else {
                $lastIndex = array_key_last($post_data['lastWord']);
                $lastIndexSession = array_key_last($session->get('words'));

                if($lastIndexSession === null) {
                    $wordsNeeded = array_merge($session->get('words'), array($post_data['lastWord'][$lastIndex]));
                }
                elseif ( $session->get('words')[$lastIndexSession]['id'] != $post_data['lastWord'][$lastIndex]['id'] ) {
                    $wordsNeeded = array_merge($session->get('words'), array($post_data['lastWord'][$lastIndex]));
                }
                else
                    array_splice($wordsNeeded, -1, 1,);
        }

//        dd($wordsNeeded);
        $session->set('words',$wordsNeeded);
        if(empty($wordsNeeded))
            $wordsResult = [];

        $cat = ["id"=>0];
//dd($wordsNeeded);
        foreach ($wordsNeeded as $wordObj) {
            $wordsResult[] =  $word->find($wordObj['id']);
        }

        return $this->render('index/listWord.html.twig', [
            'words' => $wordsResult,
            'cat' => $cat
        ]);
    }
    #[Route('/setLang', name: 'app_index_setLang')]
    public function setLang(Request $request, SessionInterface $session): JsonResponse
    {

        $post_data = json_decode($request->getContent(), true);
        $session->set('lang', $post_data["lang"]);
//        $res1 = $cat->findByWord($post_data["lang"]);
        return new JsonResponse("ok", Response::HTTP_OK, [], true);
    }

    #[Route('/wordsCatId/{id}', name: 'app_wordsCatId')]
    public function wordsCatId(Request $request,CategoriesRepository $cat): Response
    {
        $post_data = explode('-',$request->get('id'));
//        die($request->get('id'));
        $res = $cat->findOneBySomeField($post_data[0]);
        return $this->render('index/catDisplayWords.html.twig', [
            'cats' => $res,
            'level' => $post_data[1]
        ]);
    }

    #[Route('/listWordsCat/{id}', name: 'app_listwordsCatId')]
    public function listwordsCatId(Request $request,CategoriesRepository $cat): Response
    {
        $post_data = explode('-',$request->get('id'));
        $res = $cat->findOneBySomeField($post_data[0]);
        return $this->render('index/listWords.html.twig', [
            'categories' => $res,
            'id' => $post_data[1],
        ]);
    }
}
