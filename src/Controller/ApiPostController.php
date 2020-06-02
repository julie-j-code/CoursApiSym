<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll(); 

        /*         
        Au lieu d'utiliser le SerializerInterface (qui venait se substituer au NormalizerInterface) 
        $json = $serializer->serialize($posts, 'json', ['groups' => 'posts:read']);
        et JsonResponse (qui venait se substituer à Response )
        $response = new JsonResponse($json, 200, [], true);
        je vais utiliser une fonction héritée d'AbstractController
         */

        $response = $this->json($posts, 200, [], ['groups' => 'posts:read'] );    

        return $response;
    }
}
