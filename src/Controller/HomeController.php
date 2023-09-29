<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FilmRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FilmRepository $filmRepository): Response
    {
        $films = $filmRepository->findall();
        
        return $this->render('home/index.html.twig', [
            'titre'=>'Bienvenu sur mon cinéclub',
            'film' => $films,
        ]);
    }
}
