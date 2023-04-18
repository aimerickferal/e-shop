<?php

namespace App\Form\Admin;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminCategoryType extends AbstractType
{
    public function __construct(private SluggerInterface $sluggerInterface)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // We use the addEventlistener method on PRE_SUBMIT to check the data of some fields, before submitting the data to the form.
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->add('name', null, [
                'empty_data' => ''
            ])
            ->add('slug', HiddenType::class, []);
    }

    /**
     * Method that slugify the name of a category.
     * @param FormEvent
     * @return void
     */
    public function onPreSubmit(FormEvent $event)
    {
        // We get the form. 
        $form = $event->getForm();

        // We get the data of the category.
        $category = $event->getData();

        // We set the reference of the category. 
        $category['slug'] = strtolower($this->sluggerInterface->slug($category['name']));

        // We set the data of the event with the new data of the category.
        $event->setData($category);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
