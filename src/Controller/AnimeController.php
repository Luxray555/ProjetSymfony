<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Commentaire;
use App\Entity\Note;
use App\Form\CommentaireType;
use App\Form\NoteType;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anime')]
class AnimeController extends AbstractController
{
    #[Route('/{id}', name: 'app_anime_show', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('app_anime_show', ['id'=>$anime->getId()], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('app_anime_show', ['id'=>$anime->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('anime/show.html.twig', [
            'anime' => $anime,
            'form1' => $form1,
            'form2' => $form2,
        ]);
    }
}
