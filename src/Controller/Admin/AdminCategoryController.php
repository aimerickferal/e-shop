<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\CategorySearch;
use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\CategorySearchType;
use App\Form\Admin\AdminCategoryType;
use App\Form\ProductSearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository, private ProductRepository $productRepository, private EntityManagerInterface $entityManagerInterface)
    {
    }

    /**
     * Method that create a category.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/categories/creer', name: 'admin_category_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        // We create a new Category.
        $category = new Category();
        // We create the form.
        $form = $this->createForm(AdminCategoryType::class, $category);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We call the persit() method of the EntityManagerInterface to put on hold the data.
            $this->entityManagerInterface->persist($category);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'La categorie ' . $category->getName() . ' a bien été créée.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_category_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/category/create.html.twig',
            // We set a array of optional data.
            [
                'adminCreateCategoryForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the list of the categories.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/categories', name: 'admin_category_list', methods: 'GET', priority: 1)]
    public function list(Request $request): Response
    {
        // We find all the categories.
        $categories = $this->categoryRepository->findAll();

        // If we don't find any category.
        if (!$categories) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des catégories est vide. Nous vous invitons à vous en créer une.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_category_create',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new category search.
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
                    'admin_category_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/category/list.html.twig',
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
    #[Route('/admin/categories/{slug}/produits', name: 'admin_category_product_list', methods: 'GET', priority: 1)]
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
                'admin_category_list',
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
                'admin_category_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new product search.
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
                // If the category of the product is not identical to the category.
                if ($product->getCategory() !== $category) {
                    // We use the PHP method unset() to remove the product from the products array so that he is can't be display to the user.
                    unset($products[$index]);
                }
            }

            // If we don't find a product with the submitted name.
            if (!$products) {
                // // We display a flash message for the user.
                // $this->addFlash('error', 'Le produit ' . $form->get('name')->getData() . ' n\'appartient pas à la catégorie ' . $category->getName() . ' mais à la catégorie ' . $product->getCategory()->getName() . '.');
                // We display a flash message for the user.
                $this->addFlash('error', 'Le produit ' . $form->get('name')->getData() . ' n\'existe pas ou ne fait pas partie de la catégorie ' . $category->getName() . '.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_category_product_list',
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
            'admin/category/product-list.html.twig',
            // We set a array of optional data.
            [
                'category' => $category,
                'products' => $products,
                'searchProductForm' => $form->createView(),
                'available' => Product::AVAILABLE,
                'unavailable' => Product::UNAVAILABLE,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a category.
     * @param string $slug
     * @return Response
     */
    #[Route('/admin/categories/{slug}', name: 'admin_category_detail', methods: 'GET')]
    public function detail(string $slug): Response
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
                'admin_category_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/category/detail.html.twig',
            // We set a array of optional data.
            [
                'category' => $category
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a product according to its category.
     * @param string $categorySlug
     * @param string $productSlug
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/categories/{categorySlug}/produits/{productSlug}', name: 'admin_category_product_detail', methods: 'GET')]
    public function productDetail(string $categorySlug, string $productSlug, Request $request): Response
    {
        // We find the category by its slug.
        $category = $this->categoryRepository->findOneBy(
            [
                'slug' => $categorySlug
            ]
        );

        // We find the product by its slug.
        $product = $this->productRepository->findOneBy(
            [
                'slug' => $productSlug
            ]
        );

        // If we don't find any category or any product.
        if (!$category || !$product) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_category_product_list',
                // We set a array of optional data.
                [
                    'slug' => $request->attributes->get('categorySlug')
                ],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/category/product-detail.html.twig',
            // We set a array of optional data.
            [
                'category' =>  $category,
                'product' =>  $product,
                'available' => Product::AVAILABLE,
                'unavailable' => Product::UNAVAILABLE,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that update a category.
     * @param string $slug
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/categories/{slug}/mettre-a-jour', name: 'admin_category_update', methods: 'GET|POST')]
    public function update(string $slug, Request $request): Response
    {
        // We find the category by its slug.
        $category =  $this->categoryRepository->findOneBy(
            [
                'slug' => $slug
            ]
        );

        // If we don't find any category.
        if (!$category) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_category_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create the form.
        $form = $this->createForm(AdminCategoryType::class, $category);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'La categorie ' . $category->getName() . ' a bien été mise à jour.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_category_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/category/update.html.twig',
            // We set a array of optional data.
            [
                'category' => $category,
                'adminUpdateCategoryForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Metho that delete a category.
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    #[Route('/admin/categories/{id}/supprimer', name: 'admin_category_delete', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function delete(Request $request, Category $category): Response
    {
        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');

        // If the CSRF token is valid.
        if ($this->isCsrfTokenValid('admin-category-delete' . $category->getId(), $submittedToken)) {
            // We don't want to allow to the user the possibility of deleted a category who contain one or several products. 
            // If the number of products in the category is superior than 0.
            if (count($category->getProducts()) > 0) {
                // We display a flash message for the user.
                $this->addFlash('error', 'La catégorie ' . $category->getName() . ' ne peut pas être supprimée, car elle contient ' . count($category->getProducts()) . ' produits. Merci de supprimer les produits au préalable.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_category_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }

            // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
            $this->entityManagerInterface->remove($category);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'La catégorie ' . $category->getName() . ' a bien été supprimée.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_category_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }
        // Else the CSRF token is not valid.
        else {
            // We redirect the user to the page 403.
            return new Response(
                'Action interdite',
                // We specify the related HTTP response status code.
                403
            );
        }

        //! START : if we use the API
        // // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
        // $this->entityManagerInterface->remove($category);
        // // We call the flush() method of the EntityManagerInterface to backup the data in the database.
        // $this->entityManagerInterface->flush();


        // // We display a flash message for the user.
        // $this->addFlash('success', 'La catégorie ' . $category->getName() . ' a bien été supprimée.');

        // // We redirect the user.
        // return $this->redirectToRoute(
        //     'admin_category_list',
        //     // We set a array of optional data.
        //     [],
        //     // We specify the related HTTP response status code.
        //     301
        // );
        //! END : if we use the API
    }
}
