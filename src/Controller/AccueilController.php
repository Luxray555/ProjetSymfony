<?php

namespace App\Controller;

use App\Repository\AnimeRepository;
use App\Repository\CommentaireRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(AnimeRepository $animeRepository, NoteRepository $noteRepository, CommentaireRepository $commentaireRepository): Response
    {
        $lastNotes = $noteRepository->findLastNotesForUser($this->getUser());
        $lastComments = $commentaireRepository->findLastCommentsForUser($this->getUser());

        $lastActions = array_merge($lastNotes, $lastComments);
        usort($lastActions, function($a, $b) {
            return $a->getDateCreation() < $b->getDateCreation();
        });

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'newAnime' => $animeRepository->findNewlyAdded(),
            'trendingAnime' => $animeRepository->findTrendingAnime(),
            'lastActions' => $lastActions,
        ]);
    }
}
