<?php

namespace App\Controller;

use App\Repository\AnimeRepository;
use App\Repository\CommentaireRepository;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(AnimeRepository $animeRepository, NoteRepository $noteRepository, CommentaireRepository $commentaireRepository, UserRepository $userRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'newAnime' => $animeRepository->findNewlyAdded(),
            'trendingAnime' => $animeRepository->findTrendingAnime(),
            'lastActions' => $userRepository->findLastActionsForUser($this->getUser()),
        ]);
    }
}
