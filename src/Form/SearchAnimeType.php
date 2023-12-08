<?php

namespace App\Form;

use App\Repository\AnimeStatusRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\GenreRepository;

class SearchAnimeType extends AbstractType
{

    private GenreRepository $genreRepository;
    private AnimeStatusRepository $animeStatusRepository;

    public function __construct(GenreRepository $genreRepository, AnimeStatusRepository $animeStatusRepository)
    {
        $this->genreRepository = $genreRepository;
        $this->animeStatusRepository = $animeStatusRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', SearchType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un anime',
                    'class' => 'form-control search-control',
                ],
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => false,
                'choices' => $this->getStatus(),
                'attr' => [
                    'class' => 'form-control status-control',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'placeholder' => 'Status',
            ])
            ->add('genres', ChoiceType::class, [
                'label' => false,
                'multiple' => true,
                'expanded' => true,
                'choices' => $this->getGenres(),
                'attr' => [
                    'class' => 'form-control genre-control',
                ],
                'label_html' => true,
                'required' => false,
                'placeholder' => 'Genres',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'form-control btn-control',
                ],
            ]);
    }

    private function getStatus(): array
    {
        $status = $this->animeStatusRepository
            ->createQueryBuilder('s')
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult();

        $choices = [];

        foreach ($status as $stat) {
            $choices[$stat->getNom()] = $stat;
        }
        return $choices;
    }

    private function getGenres(): array
    {
        $genres = $this->genreRepository
            ->createQueryBuilder('g')
            ->orderBy('g.nom', 'ASC')
            ->getQuery()
            ->getResult();

        $choices = [];

        foreach ($genres as $genre) {
            $choices[$genre->getNom()] = $genre;
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form-search',
            ],
        ]);
    }
}
