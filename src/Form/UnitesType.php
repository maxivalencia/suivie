<?php

namespace App\Form;

use App\Entity\Unites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unite')
            ->add('abreviation')
            ->add('localite')
            ->add('mail')
            ->add('phone')
            ->add('commune')
            ->add('unitesuperieur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Unites::class,
        ]);
    }
}
