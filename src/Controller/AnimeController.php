<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Commentaire;
use App\Entity\Note;
use App\Form\AnimeType;
use App\Form\CommentaireType;
use App\Form\NoteType;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anime')]
class AnimeController extends AbstractController
{
    #[Route('/{id}', name: 'app_anime_index', methods: ['GET'])]
    public function index(Request $request, Anime $anime, AnimeRepository $animeRepository, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_anime_index', [], Response::HTTP_SEE_OTHER);
        }

        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('app_anime_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('anime/show.html.twig', [
            'anime' => $anime,
            'form' => $form,
        ]);
    }
}
