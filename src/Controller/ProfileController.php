<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/user/{id}', name: 'app_profile')]
    public function index(User $user): Response
    {

        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/settings', name: 'app_profile_settings', methods: ['GET', 'POST'])]
    public function userSettings(Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(UserSettingsType::class, $this->getUser());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Settings updated!');

            return $this->redirectToRoute('app_profile', ['id' => $this->getUser()]);
        }

        return $this->render('profile/settings.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
