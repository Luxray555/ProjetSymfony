<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserCrudController extends AbstractCrudController
{
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
            ImageField::new('ppImageName')
                ->onlyOnIndex()
                ->setBasePath('/images/user/pp'),
            TextareaField::new('ppImageFile')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
            ImageField::new('bannerImageName')
                ->onlyOnIndex()
                ->setBasePath('/images/user/banner'),
            TextareaField::new('bannerImageFile')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
            Field::new('bio'),
            ArrayField::new('roles'),
            Field::new('isVerified'),
        ];
    }

}
