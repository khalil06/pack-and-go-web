<?php

namespace App\Form;

use App\Entity\Reservationchambre;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('checkIn',  DateType::class, [
                'years' => range(date('Y') , date('Y') + 5)
            ])

            ->add('checkOut',  DateType::class, [
                'years' => range(date('Y'), date('Y') + 5)
            ])
            ->add('idUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservationchambre::class,
        ]);
    }
}
