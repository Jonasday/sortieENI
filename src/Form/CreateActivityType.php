<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class CreateActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : ',
                'required' => true
            ])

            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie : ',
                'required' => true
            ])

            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date limite d\'inscription : ',
                'required' => true
            ])

            ->add('nbInscriptionsMax', NumberType::class, [
                'label' => 'Nombre de places : ',
                'required' => true
            ])

            ->add('duree', NumberType::class, [
                'label' => 'Durée : ',
                'required' => true
            ])

            ->add('infosSortie', TextareaType::class, [
                'label' => 'Description : ',
                'required' => false
                    ])

            //->add('organisateur')
            //->add('lstParticipant')

            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])

            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom'
            ])

            ->add('lieu',EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ])

            ->add('rue', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'rue',
                'label' => 'Rue : ',
            ])

            ->add('codePostal', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'codePostal',
                'label' => 'Code Postal : ',

            ])

            ->add('latitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'latitude',
                'label' => 'Latitude : ',
            ])

            ->add('longitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'longitude',
                'label' => 'Longitude : ',
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
