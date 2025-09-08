<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArbreCategorieController extends AbstractController
{
    #[Route('/arbre/categorie', name: 'app_arbre_categorie')]
    public function index(CategoriesRepository $cat): Response
    {
        $res = $cat->findAll();
        dd($res);
        return $this->render('arbre_categorie/index.html.twig', [
            'controller_name' => 'ArbreCategorieController',
            'cats' => $res,
        ]);
    }
}
