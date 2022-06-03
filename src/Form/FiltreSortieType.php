<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Model\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class,[
                'label' => 'Campus',
                'class' => Campus::class,
                'choice_label' => 'nom',
                'required' => false,
            ])
            ->add('motsClef', SearchType::class,[
                'label' => 'Le nom de la sortie contient :',
                'required' => false,
                'attr' => [
                    'placeholder' => 'search'
                ]
            ])
            ->add('dateMin', DateTimeType::class, [
                'label' => 'Entre le',
                'date_widget'=>'single_text',
                'time_widget'=>'single_text',
                'required' => false,
            ])
            ->add('dateMax', DateTimeType::class, [
                'label' => 'Et le',
                'date_widget'=>'single_text',
                'time_widget'=>'single_text',
                'required' => false,
            ])
            ->add('sortieOrganisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",
                'required' => false,
            ])
            ->add('sortieInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit/e',
                'required' => false,
            ])
            ->add('sortiePasInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
            ])
            ->add('sortiePasse', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Recherche'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
}
