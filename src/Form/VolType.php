<?php

namespace App\Form;

use App\Entity\Vol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('origin',TextType::class,[
                'attr'=>[
                    'class'=>'form-control '
                ]
            ])
            ->add('destination',TextType::class,[
                'attr'=>[
                    'class'=>'form-control '
                ]
            ])
            ->add('departure_date', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('arrival_date', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            //->add('status')
            ->add('initial_price',TextType::class,[
                'attr'=>[
                    'class'=>'form-control '
                ]
            ])
            ->add('company')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
