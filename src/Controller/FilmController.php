<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FilmRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Film;
use App\Entity\Projection;
use App\Form\ProjectionType;

class FilmController extends AbstractController
{
    #[Route('/film/{id}', name: 'app_film_detail')]
    public function show($id, FilmRepository $filmRepository): Response
    {
        $film = $filmRepository->find($id);

        if (!$film) {
            throw $this->createNotFoundException('Film non trouvé');
        }

        return $this->render('film/detail.html.twig', [
            'film' => $film,
        ]);
    }
    #[Route('/film/{id}/add-projection', name: 'app_film_add_projection')]
    public function addProjection(Request $request, Film $film): Response
    {
        $projection = new Projection();
        $form = $this->createForm(ProjectionType::class, $projection);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projection->setFilm($film);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projection);
            $entityManager->flush();

            return $this->redirectToRoute('app_film_detail', ['id' => $film->getId()]);
        }

        return $this->render('film/add_projection.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }
    
    
}
