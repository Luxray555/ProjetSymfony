<?php

namespace App\Controller\Admin;

use App\Entity\Avatar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AvatarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Avatar::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
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
        ];
    }
}
