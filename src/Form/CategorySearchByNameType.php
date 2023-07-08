<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CategorySearchByName;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorySearchByNameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', EntityType::class, [
                'class' => Category::class,
                'choice_attr' => function (Category $category, $key, $index) {
                    return ['class' => 'form-field__category-search-by-name-input'];
                },
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Sélectionner une catégorie',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorySearchByName::class,
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
