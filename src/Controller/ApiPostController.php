<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
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

    /**
     * @Route("/api/post", name="api_post_store", methods={"POST"})
     */

    // Ici, on fait l'inverse. On désérialise :
    // On va extraire les données JSON transmises en POST
    // pour les convertir dans un format utile à l'application

    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em){
        $jsonRecu = $request->getContent();
        $post = $serializer->deserialize($jsonRecu, Post::class, 'json');
        $post->setCreatedAt(new \DateTime());
        $em->persist($post);
        $em->flush();

        return $this->json($post, 201, [], ['groups' => 'posts:read'] );

    }
}
