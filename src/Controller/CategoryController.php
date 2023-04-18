<?php

namespace App\Controller;

use App\Entity\CategorySearch;
use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\CategorySearchType;
use App\Form\ProductSearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository, private ProductRepository $productRepository)
    {
    }

    /** 
     * Method that display the list of the categories.
     * @param Request $request
     * @return Response
     */
    #[Route('/categories', name: 'category_list', methods: 'GET', priority: 2)]
    public function list(Request $request): Response
    {
        // We find all the categories.
        $categories = $this->categoryRepository->findAll();

        // If we don't find any category.
        if (!$categories) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des catégories est vide.');

            // We redirect the user.
            return $this->redirectToRoute(
                'home',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new user search. 
        $search = new CategorySearch();
        // We create the form.
        $form = $this->createForm(CategorySearchType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid. 
        if ($form->isSubmitted() && $form->isValid()) {
            // We find the category by its name.
            $categories = $this->categoryRepository->findCategoryByName($search);

            // If we don't find a category with the submitted name. 
            if (!$categories) {
                // We display a flash message for the user. 
                $this->addFlash('error', 'La catégorie ' . $form->get('name')->getData() . ' n\'existe pas.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'category_list',
                    // We set a array of optional data. 
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template. 
        return $this->render(
            'category/list.html.twig',
            // We set a array of optional data.
            [
                'categories' => $categories,
                'searchCategoryForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /** 
     * Method that display the list of the products related to its category.
     * @param string $slug 
     * @param Request $request 
     * @return Response
     */
    #[Route('/categories/{slug}/produits', name: 'category_product_list', methods: 'GET', priority: 2)]
    public function productList(string $slug, Request $request): Response
    {
        // We find the category by its slug. 
        $category = $this->categoryRepository->findOneBy(
            [
                'slug' => $slug
            ]
        );

        // If we don't find any category. 
        if (!$category) {
            // We redirect the user.
            return $this->redirectToRoute(
                'category_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a array to backup each products. 
        $products = [];
        // For each $product in $category->getProducts().
        foreach ($category->getProducts() as $product) {
            // We push each $product in the array. 
            $products[] = $product;
        }

        // If we don't find any product. 
        if (!$products) {
            // We display a flash message for the user. 
            $this->addFlash('error', 'La catégorie ' . $category->getName() .  ' ne contient aucun produit.');

            // We redirect the user.
            return $this->redirectToRoute(
                'category_list',
                // We set a array of optional data. 
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new user search. 
        $search = new ProductSearch();
        // We create the form.
        $form = $this->createForm(ProductSearchType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid. 
        if ($form->isSubmitted() && $form->isValid()) {
            // We find the product by its name.
            $products = $this->productRepository->findProductByName($search);

            // For each $product in $products .
            foreach ($products as $index => $product) {
                // If the category of the purchase is not identical to the category.
                if ($product->getCategory() !== $category) {
                    // We use the PHP method unset() to remove the product from the products array so that he is can't be display to the user.
                    unset($products[$index]);
                }
            }

            // If we don't find a product with the submitted name. 
            if (!$products) {
                // We display a flash message for the user.
                $this->addFlash('error', 'Aucun résultat. Le produit ' . $form->get('name')->getData() . ' n\'existe pas ou ne fait pas partie de la catégorie ' . $category->getName() . '.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'category_product_list',
                    // We set a array of optional data. 
                    [
                        'slug' => $category->getSlug()
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template. 
        return $this->render(
            'category/product-list.html.twig',
            // We set a array of optional data.
            [
                'category' =>  $category,
                'searchProductForm' => $form->createView(),
                'products' => $products,
                'available' => Product::AVAILABLE,
                'unavailable' => Product::UNAVAILABLE,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /** 
     * Method that display the detail of a product according to its category.
     * @param string $categorySlug 
     * @param string $productSlug 
     * @return Response
     */
    #[Route('/categories/{categorySlug}/produits/{productSlug}', name: 'category_product_detail', methods: 'GET', priority: 1)]
    public function productDetail(string $categorySlug, string $productSlug): Response
    {
        // We display our template. 
        return $this->render(
            'category/product-detail.html.twig',
            // We set a array of optional data.
            [
                'category' =>  $this->categoryRepository->findOneBy(
                    [
                        'slug' => $categorySlug
                    ]
                ),
                'product' =>  $this->productRepository->findOneBy(
                    [
                        'slug' => $productSlug
                    ]
                ),
                'available' => Product::AVAILABLE,
                'unavailable' => Product::UNAVAILABLE,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }
}
