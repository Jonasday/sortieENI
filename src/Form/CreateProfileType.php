<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo : ',
                'required' => true
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom :',
                'required' => true
            ])

            ->add('telephone', TextType::class, [
                'label' => 'Telephone :',
                'required' => true
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])

            ->add('email', TextType::class, [
                'label' => 'Email : ',
                'required' => true
            ])
            //->add('roles')
            ->add('password', TextType::class, [
                'label' => 'Password : ',
                'required' => true
            ])
            ->add('confirmation', TextType::class, [
                'mapped' => false
            ])
            ->add('nom', TextType::class, [
                'label' => 'Confirmation :',
                'required' => true
            ]);
            //->add('actif')



    }

    // ->add('lstSortie')
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
