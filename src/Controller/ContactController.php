<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);

            $admins = $userRepository->findAdmins();

            foreach ($admins as $admin) {
                $email = (new Email())
                    ->from('contact@animeworld.world')
                    ->to($admin->getEmail())
                    ->subject('Une nouvelle demande de contact a été laissé.')
                    ->text('Afin de voir la demande et d\'y répondre merci de vous rendre sur le panel admin.');

                $mailer->send($email);
            }

            return $this->render('contact/new.html.twig', [
                'form' => $form,
                'toast' => true,
            ]);
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form,
            'toast' => false,
        ]);
    }

}