<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;


class CreateActivityType extends AbstractType
{
    private EntityManagerInterface $em;

    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : ',
                'required' => true,
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie : ',
                'required' => true,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date limite d\'inscription : ',
                'required' => true,
                'widget' => 'single_text',
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
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'mapped' => false
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ])
            ->add('rue', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'rue',
                'label' => 'Rue : ',
                'mapped' => false
            ])
            ->add('codePostal', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'codePostal',
                'label' => 'Code Postal : ',
                'mapped' => false
            ])
            ->add('latitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'latitude',
                'label' => 'Latitude : ',
                'mapped' => false
            ])
            ->add('longitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'longitude',
                'label' => 'Longitude : ',
                'mapped' => false
            ])
            ->add('checkpoint', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'type' => 'submit',
                    'class' => 'btn btn-success',
                ]
            ])
            ->add('publish', SubmitType::class, [
                'label' => 'Publier la sortie',
                'attr' =>
                    [
                        'type' => 'submit',
                        'class' => 'btn btn-success',
                    ]
            ]);

//        $builder->addEventListener(
//            FormEvents::PRE_SET_DATA,
//
//            function (FormEvent $event) {
//                $form = $event->getForm();
//
//                // this would be your entity, i.e. SportMeetup
//                $data = $event->getData();
//
//                $ville = $data->getVille();
//                $lieux = null === $ville ? [] : $ville->getLstLieu();
//
//                $form->add('lieu', EntityType::class, [
//                    'class' => Lieu::class,
//                    'placeholder' => 'Choisir un lieu...',
//                    'choices' => $lieux,
//                ]);
//            }
//        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
