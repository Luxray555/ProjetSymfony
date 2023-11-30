<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Security\EmailVerifier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserCrudController extends AbstractCrudController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('username'),
            TextField::new('password')->hideOnIndex(),
            AssociationField::new('avatar')
                ->renderAsEmbeddedForm()
                ->hideOnIndex(),
            ImageField::new('avatar.ppImageName')
                ->onlyOnIndex()
                ->setBasePath('/images/user/pp'),
            /*TextareaField::new('avatar.ppImageFile')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),*/
            ImageField::new('avatar.bannerImageName')
                ->onlyOnIndex()
                ->setBasePath('/images/user/banner'),
            /*TextareaField::new('avatar->bannerImageFile')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),*/
            Field::new('bio'),
            ArrayField::new('roles'),
            Field::new('isVerified'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $sendVerifAction = Action::new('sendVerifEmail', 'Envoyer un email de vérification')
            ->linkToCrudAction('sendVerificationEmail');

        return $actions
            ->add(Crud::PAGE_INDEX, $sendVerifAction);
    }

    public function sendVerificationEmail(AdminContext $context, MailerInterface $mailer): RedirectResponse
    {
        $user = $context->getEntity()->getInstance();

        if ($user->isVerified()) {
            $this->addFlash('warning', 'Cet utilisateur a déjà validé son email.');
        } else {
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from('no-reply@oxyjen.io')
                    ->to(new Address($user->getEmail()))
                    ->subject('AnimeWorld - Confirmation de votre adresse email.')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            $this->addFlash('success', 'Email de vérification envoyé avec succés.');
        }

        // Redirect back to the list
        return $this->redirect($context->getReferrer());
    }

}
