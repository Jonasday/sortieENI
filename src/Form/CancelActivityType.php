<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancelActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('delete', SubmitType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'type' => 'submit',
                    'class' => 'btn btn-success',
                ]
            ])
            ->add('motif', TextareaType::class, [
                'label' => 'Motif :',
                'mapped'=> false,
                'attr' => [
                    'placeholder' => 'Pourquoi souhaitez-vous annuler votre sortie ?'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
