<?php

namespace App\Form;

use App\Entity\Dossiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossiersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('objet')
            ->add('dateexpedition')
            ->add('daterecepnumeric')
            ->add('daterecepeffectif')
            ->add('referencesuivie')
            ->add('dureetraitement')
            ->add('dureeeffectif')
            ->add('suggestions')
            ->add('piecejointes')
            ->add('resultat')
            ->add('typedossier')
            ->add('traitement')
            ->add('uniteorigine')
            ->add('unitedestinataire')
            ->add('precdossiers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dossiers::class,
        ]);
    }
}
