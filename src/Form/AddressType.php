<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'empty_data' => ''
            ])
            ->add('lastName', null, [
                'empty_data' => ''
            ])
            ->add('streetNumber', null, [
                'empty_data' => ''
            ])
            ->add('streetName', null, [
                'empty_data' => ''
            ])
            ->add('zipCode', null, [
                'empty_data' => ''
            ])
            ->add('city', null, [
                'empty_data' => ''
            ])
            ->add('country', null, [
                'empty_data' => ''
            ])
            ->add('phoneNumber', null, [
                'empty_data' => ''
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
