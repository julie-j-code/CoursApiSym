<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository)
    {
        /*         
        Au lieu d'utiliser le SerializerInterface (qui venait se substituer au NormalizerInterface) 
        et JsonResponse (qui venait se substituer à Response )
        $response = new JsonResponse($json, 200, [], true);
        j'utilise LA fonction json héritée d'AbstractController
         */

        return $this->json($postRepository->findAll(), 200, [], ['groups' => 'posts:read'] );    

    }
}
