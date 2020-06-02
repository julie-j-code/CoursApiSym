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
        $posts = $postRepository->findAll();        
        dd($posts);

        // json_encode permet de transformer un tableau associatif en du JSON. 
        // Elle est cependant limitée au cas d'objets simples (comme le tableau associatif ci-dessous)
        /* $json = json_encode([
            'prénom' => 'Julie',
            'nom' => 'Jeannet']); */

        
        // Dans le cas d'objets complexes contenant des méthodes ou données privées
        // json_encode() ne pourra pas y accéder...
        $json = json_encode($posts);
        dd($json); // va retourner un tableau JSON vide !

        // il faut donc avant d'utiliser json_encode() normaliser les données
        // normalisation = transformation de données complexes (objets) en un tableau associatif simple
        // on appellera pour cette étape le NormalizerInterface

        return $this->render('api_post/index.html.twig', [
            'controller_name' => 'ApiPostController',
        ]);
    }
}
