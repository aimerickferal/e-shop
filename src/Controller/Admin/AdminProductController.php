<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\ProductSearchByName;
use App\Form\ProductSearchByNameType;
use App\Form\Admin\AdminProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository, private FileUploader $fileUploader, private EntityManagerInterface $entityManagerInterface)
    {
    }

    /**
     * Method that create a product.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/produits/creer', name: 'admin_product_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        // We create a new product.
        $product = new Product();
        // We create the form.
        $form = $this->createForm(AdminProductType::class, $product);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We upload the picture submitted by the user.
            $picture = $this->fileUploader->uploadFile($form, 'picture');

            // If we have a picture to upload.
            if ($picture) {
                //  We set to the picture property the value of picture.
                $product->setPicture($picture);
            }

            // We put the data on hold.
            $this->entityManagerInterface->persist($product);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été crée.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_product_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/product/create.html.twig',
            // We set a array of optional data.
            [
                'adminProductCreateForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the list of products.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/produits', name: 'admin_product_list', methods: 'GET', priority: 2)]
    public function list(Request $request): Response
    {
        // We find all the products.
        $products = $this->productRepository->findAll();

        // If we don't find any product.
        if (!$products) {
            // We display a flash message for the user.
            $this->addFlash('notice', 'Aucun produit. Nous vous invitons à vous en créer un.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_product_create',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new product search by name.
        $search = new ProductSearchByName();
        // We create the form.
        $form = $this->createForm(ProductSearchByNameType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We find the product by its name.
            $products = $this->productRepository->findProductByName($search);

            // If we don't find a product with the submitted name.
            if (!$products) {
                // We display a flash message for the user.
                $this->addFlash('error', 'Le produit ' . $form->get('name')->getData() . ' n\'existe pas.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_product_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/product/list.html.twig',
            // We set a array of optional data.
            [
                'products' => $products,
                'productSearchByNameForm' => $form->createView(),
                'available' => Product::AVAILABLE,
                'unavailable' => Product::UNAVAILABLE
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
    #[Route('/admin/produits/{slug}', name: 'admin_product_detail', methods: 'GET')]
    public function detail(string $slug): Response
    {
        // We find the product by its slug.
        $product =  $this->productRepository->findOneBy(
            ['slug' => $slug]
        );

        // If we don't find any product.
        if (!$product) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_product_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/product/detail.html.twig',
            // We set a array of optional data.
            [
                'product' => $product,
                'available' => Product::AVAILABLE,
                'unavailable' => Product::UNAVAILABLE,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that update a product.
     * @param Request $request
     * @param string $slug
     * @return Response
     */
    #[Route('/admin/produits/{slug}/mettre-a-jour', name: 'admin_product_update', methods: 'GET|POST')]
    public function update(Request $request, string $slug): Response
    {
        // We find the product by its slug.
        $product =  $this->productRepository->findOneBy(
            ['slug' => $slug]
        );

        // If we don't find any product.
        if (!$product) {
            // If the query of the request contain the key returnToAdminProductList.
            if ($request->query->get('returnToAdminProductList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_product_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
            // Else if the query of the request contain the string returnToAdminCategoryProductList.
            elseif ($request->query->get('returnToAdminCategoryProductList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_category_product_list',
                    // We set a array of optional data.
                    [
                        'slug' => $request->attributes->get('slug')
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We create the form.
        $form = $this->createForm(AdminProductType::class, $product);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We upload the picture submitted by the user.
            $picture = $this->fileUploader->uploadFile($form, 'upload');

            // If we have a picture to upload.
            if ($picture) {
                // We get the current picture of the product that will be his previous picture after the update. 
                $previousPicture = $product->getPicture();

                // We set the picture to the product.
                $product->setPicture($picture);

                // If the previous picture of the product is different than 
                if ($previousPicture !== Product::PICTURE_BY_DEFAULT) {
                    // We use the PHP function unlink() to delete, from our folder, the previous picture of the product. 
                    unlink(Product::PICTURE_UPLOAD_FOLDER_PATH . '/' . $previousPicture);
                }
            }

            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été mis à jour.');

            // If the query of the request contain the key returnToAdminCategoryProductList.
            if ($request->query->get('returnToAdminCategoryProductList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_category_product_list',
                    // We set a array of optional data.
                    [
                        'slug' => $product->getCategory()->getSlug()
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_product_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/product/update.html.twig',
            // We set a array of optional data.
            [
                'product' => $product,
                'adminProductUpdateForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }


    /**
     * Metho that delete a product.
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    #[Route('/admin/produits/{id}/supprimer', name: 'admin_product_delete', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function delete(Request $request, Product $product): Response
    {
        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');

        if ($this->isCsrfTokenValid('admin-product-delete' . $product->getId(), $submittedToken)) {
            // We get the product's picture. 
            $picture = $product->getPicture();

            // We delete our object.
            $this->entityManagerInterface->remove($product);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // If the picture of the product is different than Product::PICTURE_BY_DEFAULT. 
            if ($picture !== Product::PICTURE_BY_DEFAULT) {
                // We use the PHP function unlink() to delete, from our folder, the picture of the product. 
                unlink(Product::PICTURE_UPLOAD_FOLDER_PATH . '/' . $picture);
            }

            // We display a flash message for the user.
            $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été supprimé.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_product_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }
        // Else the submitted CSRF token is not valid.
        else {
            // We redirect the user to the 403 page. 
            return new Response(
                'Action interdite',
                // We specify the related HTTP response status code.
                403
            );
        }

        //! START: if we use the API
        // // We delete our object.
        // $this->entityManagerInterface->remove($product);
        // // We backup the data in the database. 
        // $this->entityManagerInterface->flush();

        // // We display a flash message for the user.
        // $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été supprimé.');

        // // We redirect the user.
        // return $this->redirectToRoute(
        //     'admin_product_list',
        //     // We set a array of optional data.
        //     [],
        //     // We specify the related HTTP response status code.
        //     301
        // );
        //! END: if we use the API
    }
}
