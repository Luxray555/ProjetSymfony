<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', IntegerType::class, [
                'label' => 'Note',
                'attr' => [
                    'placeholder' => 'Votre note',
                    'class' => 'note-number',
                    'html5' => true,
                    'scale' => 1,
                    'min' => 0,
                    'max' => 5,
                    'step' => 0.5,
                ],
                'label_attr' => [
                    'class' => 'note-label',
                ],
                'row_attr' => [
                    'class' => 'form note-number-form',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
