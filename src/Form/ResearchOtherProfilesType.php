<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchOtherProfilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom : ',
                'required' => true
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom : ',
                'required' => true
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone : ',
                'required' => true
            ])
            ->add('email', TextType::class, [
                'label' => 'Email :  ',
                'required' => true
            ])
            ->add('campus', TextType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
            ]);

    }





    //->add('roles')
    //->add('actif')
    //->add('lstSortie')

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
