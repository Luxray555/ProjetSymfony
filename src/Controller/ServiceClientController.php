<?php

namespace App\Controller;

use App\Entity\ReponseTicket;
use App\Entity\Ticket;
use App\Form\ReponseType;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ServiceClientController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/service-client/', name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('service_client/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
        ]);
    }

    #[Route('/tickets/', name: 'app_tickets_user', methods: ['GET'])]
    public function indexUser(TicketRepository $ticketRepository): Response
    {
        $user = $this->security->getUser();

        return $this->render('service_client/user.html.twig', [
            'tickets' => $ticketRepository->findBy([
                'auteur' => $user
            ])
        ]);
    }

    #[Route('/tickets/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();

        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setAuteur($user);
            $ticket->setOuvert(true);
            $ticket->setDate(new \DateTime());

            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_client/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/tickets/{id}', name: 'app_ticket_show', methods: ['GET', 'POST'])]
    public function show(Ticket $ticket, Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = $this->security->getUser();

        $reponse = new ReponseTicket();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setAuteur($user);
            $reponse->setTicket($ticket);
            $reponse->setDate(new \DateTime());

            $entityManager->persist($reponse);
            $entityManager->flush();

            $email = (new Email())
                ->from('no-reply@oxyjen.io')
                ->to($ticket->getAuteur()->getEmail())
                ->subject('Nouvelle réponse sur votre ticket.')
                ->text($user->getUsername() . ' a répondu à votre ticket.');

            $mailer->send($email);

            $reponse = new ReponseTicket();
            $form = $this->createForm(ReponseType::class, $reponse);

            return $this->render('service_client/show.html.twig', [
                'ticket' => $ticket,
                'form' => $form,
            ]);
        }

        return $this->render('service_client/show.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/service-client/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/service-client/{id}/modify-status', name: 'app_ticket_status', methods: ['GET'])]
    public function close(Ticket $ticket, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $newStatus = !$ticket->isOuvert();

        $ticket->setOuvert($newStatus);
        $entityManager->persist($ticket);
        $entityManager->flush();

        $email = (new Email())
            ->from('no-reply@oxyjen.io')
            ->to($ticket->getAuteur()->getEmail())
            ->subject('Votre ticket a été ' . ($newStatus ? 'ouvert' : 'fermé') .'.')
            ->text('Votre ticket ' . $ticket->getTitre() . ' a été ' . ($newStatus ? 'ouvert' : 'fermé'));

        $mailer->send($email);

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
