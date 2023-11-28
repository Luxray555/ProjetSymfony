<?php

namespace App\Controller\Admin;

use App\Entity\Anime;
use App\Repository\AnimeStatusRepository;
use App\Repository\GenreRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnimeCrudController extends AbstractCrudController
{
    private AnimeStatusRepository $animeStatusRepository;

    private GenreRepository $genreRepository;
    public function __construct( AnimeStatusRepository $animeStatusRepository, GenreRepository $genreRepository)
    {
        $this->animeStatusRepository = $animeStatusRepository;
        $this->genreRepository = $genreRepository;
    }

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
            DateTimeField::new('dateAjout')
                ->hideWhenCreating(),
            AssociationField::new('genres', 'Genres')
                ->onlyOnForms()
                ->autocomplete()
                ->setFormTypeOptions([
                    'multiple' => true,
                    'by_reference' => false,
                    'required' => true,
                ]),
            ChoiceField::new('status', 'Status')
                ->setFormTypeOption('choices', $this->getStatusChoices())
                ->onlyOnForms()
                ->autocomplete(),
        ];
    }

    private function getStatusChoices(): array
    {
        $statusChoices = $this->animeStatusRepository->createQueryBuilder('s')
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult();

        $formattedChoices = [];

        foreach ($statusChoices as $status) {
            $formattedChoices[$status->getNom()] = $status;
        }

        return $formattedChoices;
    }
}
