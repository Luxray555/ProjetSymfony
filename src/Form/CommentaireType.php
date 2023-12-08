<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire', null, [
                'label' => 'Publier un commentaire',
                'attr' => [
                    'placeholder' => 'Votre commentaire',
                    'class' => 'commentaire-textarea'
                ],
                'label_attr' => [
                    'class' => 'commentaire-label',
                ],
                'row_attr' => [
                    'class' => 'form commentaire-div',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
            'attr' => [
                'class' => 'commentaire-form', // Ajoutez la classe ici
            ],
        ]);
    }
}
