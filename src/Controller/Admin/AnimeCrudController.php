<?php

namespace App\Controller\Admin;

use App\Entity\Anime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnimeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Anime::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('nom'),
            Field::new('synopsis'),
            ImageField::new('coverImageName')
                ->onlyOnIndex()
                ->setBasePath('/images/anime/cover'),
            TextareaField::new('coverImageFile')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
            ImageField::new('bannerImageName')
                ->onlyOnIndex()
                ->setBasePath('/images/anime/banner'),
            TextareaField::new('bannerImageFile')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),






        ];
    }

}
