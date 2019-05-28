<?php

namespace App\Form;

use App\Entity\Dossiers;
use App\Entity\TypeDossiers;
use App\Entity\Unites;
use App\Entity\Traitements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DossiersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Reférence',
            ])
            ->add('objet', TextType::class, [
                'label' => 'Objet de votre demande',
            ])
            //->add('dateexpedition') // fait
            //->add('daterecepnumeric') // fait
            //->add('daterecepeffectif') // fait
            //->add('referencesuivie') // fait
            ->add('dureetraitement', null, [
                'label' => 'Durée prévue du traitement',
            ])
            //->add('dureeeffectif')
            //->add('suggestions')
            ->add('piecejointes', TextType::class, [
                'label' => 'Pièces-jointes',
                'required'   => false,
            ])
            //->add('resultat')
            ->add('typedossier', EntityType::class, [
                'class' => TypeDossiers::class,
                'label' => 'Type de dossier',
                'required'   => true,
                'attr' => [
                    'class' => 'multi',
                    'multiple' => false,
                    'data-live-search' => true,
                ],
            ])
            /*->add('traitement', EntityType::class, [
                'class' => Traitements::class,
                'label' => 'Etat de traitement',
                'required' => true,
                'attr' => [
                    'class' => 'multi',
                    'multiple' => false,
                    'data-live-search' => true
                ]
            ])*/
            //->add('uniteorigine') // fait
            ->add('unitedestinataire', EntityType::class, [
                'class' => Unites::class,
                'label' => 'Unité destinataire',
                'required' => true,
                'attr' => [
                    'class' => 'multi',
                    'multiple' => false,
                    'data-live-search' => true,
                ],
            ])
            ->add('montant', null, [
                'label' => 'Montant de l\'objet(laissez vide inexistant)',
            ])
            //->add('precdossiers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dossiers::class,
        ]);
    }
}
