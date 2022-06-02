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

            ->add('email', TextType::class, [
                'label' => 'email : ',
                'required' => true
            ])
            //->add('roles')
            ->add('password', TextType::class, [
                'label' => 'password : ',
                'required' => true
            ])
            ->add('confirmation',TextType::class,[
                'mapped' => false
            ])
            ->add('nom', TextType::class, [
                'label' => 'confirmation',
                'required' => true
            ])
            ->add('prenom', TextType::class, [
                'label' => 'prenom',
                'required' => true
            ])
            ->add('telephone', TextType::class, [
                'label' => 'telephone',
                 'required' => true
            ])
            ->add('actif', TextType::class, [
                'label' => 'actif',
                'required' => true
            ])
           // ->add('lstSortie')
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
               ])
        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
