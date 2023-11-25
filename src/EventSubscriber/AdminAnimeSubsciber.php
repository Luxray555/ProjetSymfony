<?php

namespace App\EventSubscriber;

use App\Entity\Anime;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class AdminAnimeSubsciber implements EventSubscriberInterface
{
    private $entityManager;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
          AfterEntityPersistedEvent::class => ['notifyAllUsers'],
        ];
    }

    public function notifyAllUsers(AfterEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Anime)) {
            return;
        }

        $this->sendEmails($entity);
    }

    public function sendEmails(Anime $anime) {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $email = (new TemplatedEmail())
                ->from('no-reply@animeworld.com')
                ->to($user->getEmail())
                ->subject('Un nouvel anime est disponible sur AnimeWorld!')
                ->htmlTemplate('anime/email.html.twig')
                ->context([
                    'nom' => $user->getUsername(),
                    'anime_nom' => $anime->getNom()
                ]);

            $this->mailer->send($email);
        }
    }
}