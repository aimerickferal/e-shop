<?php

namespace App\Form;

use App\Entity\AddressSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, []);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddressSearch::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    /**
     * Method that clean the parameters of the query in the url.
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
