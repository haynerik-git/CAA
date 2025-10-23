<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Repository\WordRepository;
use App\Repository\WordTranslationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Word;
use Symfony\Component\Filesystem\Filesystem;
use App\Repository\CategoriesRepository;
use App\Repository\UserRepository;
use App\Repository\UserCategoriesRepository;
use App\Repository\UserCategorieWordsRepository;
use App\Repository\UserCategoriesOrderRepository;
use App\Repository\PageOrderRepository;
use App\Repository\PageRepository;
use App\Repository\SentencesRepository;
use App\Repository\ActionRepository;
use App\Repository\LangRepository;
use App\Entity\UserCategorieWords;
use App\Entity\UserCategoriesOrder;
use App\Entity\WordTranslation;
use App\Entity\Sentences;
use App\Entity\UserCategories;
class ImportController extends AbstractController
{
    private HttpClientInterface $client;
    private  $words =  [];
    public function __construct(
         HttpClientInterface $client
    ) {
        $this->client = $client;
    }

    #[Route('/import', name: 'app_import')]
    public function index(EntityManagerInterface $entityManager,WordTranslationRepository $wordTranslationRepository,LangRepository $langRepository,WordRepository $wordRepository, Filesystem $filesystem): Response
    {
        return $this->render('import/index.html.twig', []);
    }

        #[Route('/import/importRes', name: 'app_importRes')]
    public function importRes(EntityManagerInterface $entityManager, WordTranslationRepository $wordTranslationRepository, LangRepository $langRepository, WordRepository $wordRepository, Filesystem $filesystem, \Symfony\Component\HttpFoundation\Request $request): Response
    {

//        $post_data = json_decode(, true);
//        dd();
        set_time_limit(0);
        $content = $this->CurlResult('https://api.arasaac.org/v1/pictograms/fr/search/'.str_replace(' ', '%20', $request->get('search')));
        $this->words = $wordRepository->findAll();
        $langs = $langRepository->findAll();
        $updateTad = true;

        $content = array_slice($content, 450);
        $i = 0 ;
        foreach ($content as $item) {
            $wordsFind = [];
//            echo 'https://api.arasaac.org/v1/pictograms/'.$item['_id'].'?download=false <br>';
//            echo $item['_id'];
//            dd($item);

            /////// ???????????????????????
            if( array_key_exists(0, $item['keywords'])) {
                $i++;
                echo '<hr>';
                echo $i . ' ' . $item['keywords'][0]['keyword'].'<br>';

                $wordsFind = $this->findExistingWord($item);
                if (count($wordsFind) > 0) {
                    $first_key = array_key_first($wordsFind);
                    $firstWord = $wordsFind[$first_key];
                    echo $firstWord->getArasaac().'<br>';
//                    dump($firstWord);

                    if (empty($firstWord->getArasaac()))
                        $firstWord->setArasaac($item['_id']);

                    if (empty($firstWord->getFileName())
//                      or $firstWord->getArasaac() == 33070
                    ) {
                        echo "<h1>change image ".$firstWord->getArasaac().'</h1>';

                        $img = file_get_contents('https://api.arasaac.org/v1/pictograms/' . $item['_id'] . '?download=false');
                        $nameFile = str_replace([' ','/'], '_', $firstWord->getName());
                        $fileName = '../assets/images/' . $firstWord->getId() . '-' . $nameFile . '.png';
                        $filesystem->touch($fileName);
                        $filesystem->dumpFile($fileName, ($img));
                        $firstWord->setFileName($firstWord->getId() . '-' . $nameFile . '.png');
                    }

                    if($updateTad) {
                        foreach ($langs as $lang) {

                            $trad = $this->CurlResult('https://api.arasaac.org/v1/pictograms/' . $lang->getName() . '/' . $firstWord->getArasaac());
                    //                        dd($trad);
                            if (array_key_exists(0, $trad['keywords'])) {


                                $wordTrad = $wordTranslationRepository->findOneBy(
                                    [
                                        'lang' => $lang,
                                        'wordTranslation' => $firstWord
                                    ]
                                );
                                if (empty($wordTrad)) {
                                    $wordTrad = new WordTranslation();
                                    $wordTrad->setLang($lang);
                                    $wordTrad->setWordTranslation($firstWord);
                                }

                                $wordTrad->setName($trad['keywords'][0]['keyword']);
                                $entityManager->persist($wordTrad);
                            }
                        }
                    }
                    $entityManager->persist($firstWord);
                    $entityManager->flush();
                    //die();
                } else {

                    echo "created";
                    $word = new Word();
                    $word->setArasaac($item['_id']);
                    $word->setName($item['keywords'][0]['keyword']);
                    $word->setDisplayOrder(0);
                    $entityManager->persist($word);
                    $entityManager->flush();
                    $this->words[] = $word;
                }

            }
        }
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
//        dd($content);
        die();
        return $content;

        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }

    public function findExistingWord($item)
    {
        $arr = null;
        $arr = array_filter($this->words, fn($n) => strtolower($n->getName())  == strtolower($item['keywords'][0]['keyword']) && strtolower($n->getArasaac())  == strtolower($item['_id']));
        if( $arr == null ){
            $arr = array_filter($this->words, fn($n) => strtolower($n->getArasaac())  == strtolower($item['_id']));
        }
        if( $arr == null ){
            $arr = array_filter($this->words, fn($n) =>  strtolower($n->getName())  == strtolower($item['keywords'][0]['keyword']) );
        }

        return $arr;
    }

    public function CurlResult($url) {
        $response = $this->client->request(
            'GET',
            $url
        );

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $content = $response->toArray();
//        dd($content);
        return $content;
    }

    public function DLImage() {

    }
}
