<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
class SentencesController extends AbstractController
{
    #[Route('/sentences', name: 'app_sentences')]
    public function index(CategoriesRepository $cat): Response
    {
        $res = $cat->findAll();
        return $this->render('sentences/index.html.twig', [
            'cats' => $res,
        ]);
    }

    #[Route('/sentencesCatId/{id}', name: 'app_sentencesCatId')]
    public function sentencesCatId(Request $request,CategoriesRepository $cat): Response
    {
        $post_data = $request->get('id');
//        die($request->get('id'));
        $res = $cat->findOneBySomeField($post_data);
        return $this->render('sentences/catDisplaySentences.html.twig', [
            'cats' => $res,
        ]);
    }
}
