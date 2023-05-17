<?php

namespace App\Form\Admin;

use App\Entity\Admin\AdminUserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', null, []);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdminUserSearch::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    /**
     * Method that clean the parameters of the query in the URL.
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
