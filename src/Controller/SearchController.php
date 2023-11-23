<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchAnimeType;
use App\Form\SearchUserType;
use App\Repository\AnimeRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search/user', name: 'app_search_user',methods: ['GET'])]
    public function user(Request $request, UserRepository $userRepository,PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search');
        $page = $request->query->get('page', 1);
        $users = $userRepository->search($search);

        $pagination = $paginator->paginate(
            $users,
            $page,
            8
        );

        $form1 = $this->createForm(SearchUserType::class, null, [
            'method' => 'GET',
        ]);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            return $this->redirectToRoute('app_search_user', [
                'search'=>$form1->get('search')->getData(),
                'page' => $page,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('search/user.html.twig', [
            'controller_name' => 'SearchController',
            'form1' => $form1->createView(),
            'users' => $pagination,
        ]);
    }

    #[Route('/search/anime', name: 'app_search_anime',methods: ['GET'])]
    public function anime(Request $request, AnimeRepository $animeRepository,PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search');
        $page = $request->query->get('page', 1);
        $animes = $animeRepository->search($search);

        $pagination = $paginator->paginate(
            $animes,
            $page,
            8
        );

        $form1 = $this->createForm(SearchAnimeType::class, null, [
            'method' => 'GET',
        ]);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            return $this->redirectToRoute('app_search_anime', [
                'search'=>$form1->get('search')->getData(),
                'page' => $page,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('search/anime.html.twig', [
            'controller_name' => 'SearchController',
            'form1' => $form1->createView(),
            'animes' => $pagination,
        ]);
    }
}
