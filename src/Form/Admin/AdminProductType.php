<?php

namespace App\Form\Admin;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminProductType extends AbstractType
{
    public function __construct(private SluggerInterface $sluggerInterface)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // We use the addEventlistener method on PPRE_SET_DATA to modify the form depending on the pre-populated data.
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])
            // We use the addEventlistener method on PRE_SUBMIT to check the data of some fields, before submitting the data to the form.
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->add('name', null, [
                'empty_data' => ''
            ])
            ->add('slug', HiddenType::class, [])
            ->add('reference', HiddenType::class, [])
            ->add('price', MoneyType::class, [
                'empty_data' => '',
                'currency' => false,
                'divisor' => 100
            ])
            ->add('description', TextareaType::class, [])
            ->add('picture', HiddenType::class, [])
            ->add('availability', ChoiceType::class, [
                'choices' => [
                    Product::AVAILABLE => Product::AVAILABLE,
                    Product::UNAVAILABLE => Product::UNAVAILABLE
                ],
                'data' =>  Product::AVAILABLE,
                'choice_attr' => [
                    Product::AVAILABLE => [
                        'class' => 'form-field__product-availability-input form-field__product-availability-available-input',
                    ],
                    Product::UNAVAILABLE => [
                        'class' => 'form-field__product-availability-input form-field__product-availability-unavailable-input',
                    ],
                ],
                'expanded' => true
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_attr' => function (Category $category, $key, $index) {
                    return ['class' => 'form-field__product-category-input'];
                },
                'expanded'      => true,
            ]);
    }

    /**
     * Method that modify the form and display the picture field in case of product creation and the upload field in case of product update.
     * @param FormEvent $event
     * @return void
     */
    public function onPreSetData(FormEvent $event)
    {
        // We get the form.
        $form = $event->getForm();

        // We get the data of the product.
        $product = $event->getData();

        // If we don't find any product in the database. This mean we are in creation mode.
        if (!$product->getId()) {
            $form
                ->add('picture', FileType::class, [
                    "required" => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.'
                        ]),
                        new File([
                            'maxSize' => '300k',
                            'maxSizeMessage' => 'Merci de télécharger un fichier de maximum {{ limit }} bytes.',
                            'mimeTypes' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml'
                            ],
                            'mimeTypesMessage' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.',
                        ])
                    ]
                ]);
        }
        // Else we find a product in the database. This mean we are in update mode.
        else {
            // We dynamically add the fields that will be required for the update form.
            $form
                ->add('upload', FileType::class, [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '300k',
                            'maxSizeMessage' => 'Merci de télécharger un fichier de maximum {{ limit }} bytes.',
                            'mimeTypes' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml'
                            ],
                            'mimeTypesMessage' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.',
                        ])
                    ]
                ])
                ->add('availability', ChoiceType::class, [
                    'choices' => [
                        Product::AVAILABLE => Product::AVAILABLE,
                        Product::UNAVAILABLE => Product::UNAVAILABLE
                    ],
                    'choice_attr' => [
                        Product::AVAILABLE => [
                            'class' => 'form-field__product-availability-input form-field__product-availability-available-input',
                        ],
                        Product::UNAVAILABLE => [
                            'class' => 'form-field__product-availability-input form-field__product-availability-unavailable-input',
                        ],
                    ],
                    'expanded' => true,
                ]);
        }
    }

    /**
     * Method that slugify the name of a product and create a unique reference from its name.
     * @param FormEvent
     * @return void
     */
    public function onPreSubmit(FormEvent $event)
    {
        // We get the form.
        $form = $event->getForm();

        // We get the data of the product.
        $product = $event->getData();

        // We set the slug with the value of the product's name slugged.
        $product['slug'] = strtolower($this->sluggerInterface->slug($product['name']));

        // If the submit doesn't contain a product with a reference.
        if (!$product['reference']) {
            // We set the reference of the product.
            $product['reference'] = strtoupper(substr(str_replace(' ', '', $product['name']), 0, 4) . bin2hex(random_bytes(4)));
        }

        // We set the data of the event with the new data of the product.
        $event->setData($product);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
