<?php

namespace App\Controller\Admin;

use App\Entity\Anime;
use App\Entity\Avatar;
use App\Entity\AnimeStatus;
use App\Entity\Commentaire;
use App\Entity\Genre;
use App\Entity\Note;
use App\Entity\ReponseTicket;
use App\Entity\Ticket;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AnimeWorld');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Retour au site', 'fa-solid fa-home', '/');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Animes', 'fas fa-film', Anime::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Commentaire::class);
        yield MenuItem::linkToCrud('Notes', 'fas fa-star', Note::class);
        yield MenuItem::linkToCrud('Avatars', 'fas fa-user-circle', Avatar::class);
        yield MenuItem::linkToCrud('Genres', 'fas fa-tv', Genre::class);
        yield MenuItem::linkToCrud('Tickets', 'fas fa-ticket', Ticket::class);
        yield MenuItem::linkToCrud('Reponse Tickets', 'fa-solid fa-reply', ReponseTicket::class);
        yield MenuItem::linkToCrud('Status Anime', 'fas fa-exclamation', AnimeStatus::class);
    }
}
