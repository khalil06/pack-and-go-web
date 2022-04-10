<?php

namespace App\Form;

use App\Entity\Resteau;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class RestauFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typer')
            ->add('nomr')
            ->add('adressr')
            ->add('paysr')
            ->add('telr')
            ->add('imgr', FileType::class,array('data_class'=>null,'required'=>false))

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Resteau',
            ]);
    }
}
