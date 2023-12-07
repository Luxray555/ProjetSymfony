<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\ReponseContactType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->add(Crud::PAGE_INDEX, Action::new('respond', 'Répondre')
                ->linkToCrudAction('respondToMessage'));
    }

    public function respondToMessage(AdminContext $context, Request $request, MailerInterface $mailer, AdminUrlGenerator $adminUrlGenerator)
    {
        $contact = $context->getEntity()->getInstance();
        $form = $this->createForm(ReponseContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from('contact@oxyjen.io')
                ->to($contact->getMail())
                ->subject('Re: ' . $contact->getObjet())
                ->text($data['reponse']);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('error', 'L\'email entrée par l\'utilisateur n\'éxiste pas.');
            }

            $this->addFlash('success', 'Réponse envoyée avec succés!');
            return $this->redirect($adminUrlGenerator->setDashboard(DashboardController::class)->generateUrl());
        }

        return $this->render('admin/contact_reponse.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
