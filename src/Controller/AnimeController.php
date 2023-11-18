<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeController extends AbstractController
{
<<<<<<< HEAD
    #[Route('/anime', name: 'app_anime')]
    public function index(): Response
    {
        return $this->render('anime/index.html.twig', [
            'controller_name' => 'AnimeController',
=======
    #[Route('/{id}', name: 'app_anime_index', methods: ['GET', 'POST'])]
    public function index(Request $request, Anime $anime, AnimeRepository $animeRepository, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setAnime($anime);
        $commentaire->setUser($this->getUser());
        $form1 = $this->createForm(CommentaireType::class, $commentaire);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $commentaire->setDateCreation(new \DateTime());
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_anime_index', ['id'=>$anime->getId()], Response::HTTP_SEE_OTHER);
        }

        $note = new Note();
        $note->setAnime($anime);
        $note->setUser($this->getUser());
        $form2 = $this->createForm(NoteType::class, $note);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $note->setDateCreation(new \DateTime());
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('app_anime_index', ['id'=>$anime->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('anime/show.html.twig', [
            'anime' => $anime,
            'form1' => $form1,
            'form2' => $form2,
>>>>>>> 5d7212e (Ajout option d'ajout de commentaire et de note)
        ]);
    }
}
