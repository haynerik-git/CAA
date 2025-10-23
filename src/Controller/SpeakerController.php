<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class SpeakerController extends AbstractController
{
    #[Route('/speaker', name: 'app_speaker')]
    public function index(): Response
    {
        return $this->render('speaker/index.html.twig', [
            'controller_name' => 'SpeakerController',
        ]);
    }
//speaker/contactIa
    #[Route('/speaker/contactIa', name: 'app_speaker_contact_ia')]
    public function contactIa(Request $request) : JsonResponse
    {
        $text = $request->get('text');

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=AIzaSyCNAdh2cVyJAzUcaYzMFe9P2B6iZoTVirA';
        $data = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array(
                            'text' =>  $text
                        )
                    )
                )
            )
        );

        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );


        $result = curl_exec($ch);
        curl_close($ch);

        dd($result);
        $data = json_decode($result, true);
        $txt = $data["candidates"][0]["content"] ["parts"][0] ["text"];
        $txt = str_replace(["Louis", "Luis"], "Loui", $txt);
        return new JsonResponse($txt, Response::HTTP_OK, [], true);

        return $txt;
    }

    #[Route('/speaker/contactIaRework', name: 'app_speaker_contact_ia_rework')]
    public function contactIaRework(Request $request, SessionInterface $session) : JsonResponse
    {
        $t = $request->get('text');

        if($session->has('lang')) {
            $lang = $session->get('lang');
            if($lang == "1") {
                $langRequest = 'francais';
            }
            elseif ($lang == "2") {
                $langRequest = 'espagnol';
            }
            elseif ($lang == "3") {
                $langRequest = 'anglais';
            }
            elseif ($lang == "4") {
                $langRequest = 'catalan';
            }
            elseif ($lang == "5") {
                $langRequest = 'allemand';
            }
        }

       // return new JsonResponse($t. ' ' . $lang, Response::HTTP_OK, [], true);

        $text = 'Reformule cette phrase au present sans me proposer differente solution ( juste la phrase reformule ) en ' . $langRequest . ' : '.$t;

        $text = 'Reformule cette phrase au present sans me proposer differente solution ( juste la phrase reformule ) en ' . $langRequest . ' : '.$t;

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
// new key AIzaSyAjT2OnigsgwN96YFEECb-1EY5gVtA518Q


//        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=AIzaSyCNAdh2cVyJAzUcaYzMFe9P2B6iZoTVirA';
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyAjT2OnigsgwN96YFEECb-1EY5gVtA518Q';

        $data = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array(
                            'text' =>  $text
                        )
                    )
                )
            )
        );

        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );


        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);
        if(!array_key_exists('candidates', $data) ) {
            return new JsonResponse($text, Response::HTTP_OK, [], true);
            return $text;
        }

        $txt = $data["candidates"][0]["content"] ["parts"][0] ["text"];
        $txt = str_replace(["Louis", "Luis"], "Loui", $txt);
        return new JsonResponse($txt, Response::HTTP_OK, [], true);

        return $txt;
    }
}
