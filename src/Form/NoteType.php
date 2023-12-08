<?php

namespace App\Form;

use App\Entity\Note;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', ChoiceType::class, [
                'attr' => [
                    'class' => 'stars',
                ],
                'data' => 0,
                'choices' => [
                    '0' => 0,
                    '0.5' => '0.5',
                    '1' => 1,
                    '1.5' => '1.5',
                    '2' => 2,
                    '2.5' => '2.5',
                    '3' => 3,
                    '3.5' => '3.5',
                    '4' => 4,
                    '4.5' => '4.5',
                    '5' => 5,
                ],
                'expanded'  => true,
                'choice_label' => function ($choice, $key, $value) {
                    return false;
                },
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
