<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository, NormalizerInterface $normalizer)
    {
        $posts = $postRepository->findAll();        
        dd($posts);

        // json_encode permet de transformer un tableau associatif en du JSON. 
        // Elle est cependant limitée au cas d'objets simples (comme le tableau associatif ci-dessous)
        /* $json = json_encode([
            'prénom' => 'Julie',
            'nom' => 'Jeannet']); */

        
        // Dans le cas d'objets complexes contenant des méthodes ou données privées
        // json_encode() ne pourra pas y accéder...
        // sauf à faire appel au préalable au $normalizer
        // normalisation = transformation de données complexes (objets) en un tableau associatif simple
        // reste le problème des références circulaires auquel on peut remédier grâce aux annotations 'groups'
        $postsNormalized = $normalizer->normalize($posts, null, ['groups' => 'posts:read']);
        $json = json_encode($postsNormalized);
        dd($json); // reste le problème des références circulaires !

        return $this->render('api_post/index.html.twig', [
            'controller_name' => 'ApiPostController',
        ]);
    }
}
