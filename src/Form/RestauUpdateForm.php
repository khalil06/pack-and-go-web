<?php

namespace App\Form;

use App\Entity\Resteau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestauUpdateForm extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('typer')
        ->add('nomr')
        ->add('adressr')
        ->add('paysr')
        ->add('telr')

    ;

}

    public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => Resteau::class,
    ]);
}

}