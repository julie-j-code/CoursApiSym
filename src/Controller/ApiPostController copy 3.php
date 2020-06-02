<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository, SerializerInterface $serializer)
    {
        $posts = $postRepository->findAll(); 

        /*         
        Au lieu d'avoir à utiliser le NormalizerInterface qui va transformer un objet en tableau associatif simple
        Puis json_encode() pour transformer en JSON le tableau associatif
        On fait appel au SerializerInterface 

        $postsNormalized = $normalizer->normalize($posts, null, ['groups' => 'posts:read']);
        $json = json_encode($postsNormalized); 
        */

        $json = $serializer->serialize($posts, 'json', ['groups' => 'posts:read']);

        /* 
        Au lieu d'une réponse classique avec une entête particulière pour préciser le type de données
        $response = new Response($json, 200, [
            'Content-Type' => "application/json"
        ]);

        Je vais utiliser une réponse particulière */

        $response = new JsonResponse($json, 200, [], true);

        return $response;
    }
}
