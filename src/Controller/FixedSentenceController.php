<?php

namespace App\Controller;

use App\Entity\SentencesTranslation;
use App\Repository\SentencesRepository;
use App\Repository\SentencesTranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
class FixedSentenceController extends AbstractController
{
    #[Route('/fixed/sentence', name: 'app_fixed_sentence')]
    public function index(Request $request, SentencesRepository $sentencesTranslation, SerializerInterface $serializer) : JsonResponse
    {
        $t ="";
        $post_data = json_decode($request->getContent(), true);
        $res = $sentencesTranslation->findBySentenceId($post_data);
        foreach ($res as $r) {
            $t=$r["res"];
        }
        return new JsonResponse($t, Response::HTTP_OK, [], true);
    }
}
