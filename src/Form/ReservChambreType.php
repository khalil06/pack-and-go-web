<?php

namespace App\Form;

use App\Entity\Reservationchambre;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use \Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('checkIn', DateType::class, [
                'attr' => ['class' => 'js-datepicker'],
                'widget' => 'single_text',
                'html5' => FALSE
            ])
            ->add('checkOut', DateType::class, [
                'attr' => ['class' => 'js-datepicker '],
                'widget' => 'single_text',
                'html5' => FALSE
            ])
            ->add('idUser');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservationchambre::class,
        ]);
    }
}
