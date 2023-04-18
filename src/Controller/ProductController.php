<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\ProductSearchType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    /** 
     * Method that display the list of the products.
     * @param Request $request
     * @return Response
     */
    #[Route('/produits', name: 'product_list', methods: 'GET', priority: 2)]
    public function list(Request $request): Response
    {
        // We find all the products.
        $products = $this->productRepository->findAll();

        // // We find all the available products.
        // $products = $this->productRepository->findBy(
        //     [
        //         'availability' => Product::AVAILABLE,
        //     ]
        // );

        // If we don't find any product.
        if (!$products) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des produits est vide.');

            // We redirect the user.
            return $this->redirectToRoute(
                'user_profile',
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

            // If we don't find a product with the submitted name. 
            if (!$products) {
                // We display a flash message for the user. 
                $this->addFlash('error', 'Le produit ' . $form->get('name')->getData() . ' n\'existe pas.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'product_list',
                    // We set a array of optional data. 
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template. 
        return $this->render(
            'product/list.html.twig',
            // We set a array of optional data.
            [
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
     * Method that display the detail of a product.
     * @param string $slug 
     * @return Response
     */
    #[Route('/produits/{slug}', name: 'product_detail', methods: 'GET', priority: 3)]
    public function detail(string $slug): Response
    {
        // We display our template. 
        return $this->render(
            'product/detail.html.twig',
            // We set a array of optional data.
            [
                'product' => $this->productRepository->findOneBy(['slug' => $slug]),
                'available' => Product::AVAILABLE,
                'unavailable' => Product::UNAVAILABLE,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }
}
