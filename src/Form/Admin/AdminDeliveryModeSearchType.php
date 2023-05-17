<?php

namespace App\Form\Admin;

use App\Entity\Admin\AdminDeliveryModeSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminDeliveryModeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, []);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdminDeliveryModeSearch::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    /**
     * Method that clean the parameters of the query in the URL.
     * @return string
     */
    public function getBlockPrefix(): string 
    {
        return '';
    }
}
