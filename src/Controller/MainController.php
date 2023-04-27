<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\ContactType;
use App\Form\ProductSearchType;
use App\Repository\ProductRepository;
use App\Service\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Method that display the home page.
     * @param Request $request 
     * @param ProductRepository $productrRepository
     * @return Response
     */
    #[Route('/', name: 'home', methods: 'GET')]
    public function home(Request $request, ProductRepository $productRepository): Response
    {
        // We remove the cart form the session.
        // $request->getSession()->remove('cart');

        // // We get the logged user.
        // /**
        //  * @var User
        //  */
        // $user = $this->getUser();

        // We find all the products.
        $products = $productRepository->findAll();

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

        if ($form->isSubmitted() && $form->isValid()) {
            // We find the product by its name.
            $products = $productRepository->findProductByName($search);

            // If we don't find a category with the submitted name. 
            if (!$products) {
                // We display a flash message for the user. 
                $this->addFlash('error', 'Bonjour, le produit ' . $form->get('name')->getData() . ' n\'existe pas.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'home',
                    // We set a array of optional data. 
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template. 
        return $this->render(
            'main/home.html.twig',
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
     * Method that display the contact page and handle the ContactType. 
     * @param Request $request
     * @param Email $email
     * @return Response
     */
    #[Route('/contact', name: 'contact', methods: 'GET|POST', priority: 3)]
    public function contact(Request $request, Email $email): Response
    {
        // We create the form.
        $form = $this->createForm(ContactType::class);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We call the sendEmailFromUser() method of the Email service with the value of $form->getData() in argument.
            $email->sendEmailFromUser($form->getData());

            // We display a flash message for the user. 
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            // We redirect the user.
            return $this->redirectToRoute(
                'home',
                // We set a array of optional data. 
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template. 
        return $this->render(
            'main/contact.html.twig',
            // We set a array of optional data.
            [
                'contactForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the about page. 
     * @return Response
     */
    #[Route('/a-propos', name: 'about', methods: 'GET')]
    public function about(): Response
    {
        // We display our template. 
        return $this->render(
            'main/about.html.twig',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the legal_notices page. 
     * @return Response
     */
    #[Route('/mentions-legales', name: 'legal_notices', methods: 'GET')]
    public function legalMentions(): Response
    {
        // We display our template. 
        return $this->render(
            'main/legal-notices.html.twig',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }


    /**
     * Method that display the general_terms_of_sale page. 
     * @return Response
     */
    #[Route('/conditions-generales-de-vente', name: 'general_terms_of_sale', methods: 'GET')]
    public function termsOfSales(): Response
    {
        // We display our template. 
        return $this->render(
            'main/general-terms-of-sale.html.twig',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the general_terms_of_use page. 
     * @return Response
     */
    #[Route('/conditions-generales-d-utilisation', name: 'general_terms_of_use', methods: 'GET')]
    public function termsOfUse(): Response
    {
        // We display our template. 
        return $this->render(
            'main/general-terms-of-use.html.twig',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the delivery_and_customer_service page. 
     * @return Response
     */
    #[Route('/livraison-et-service-apres-vente', name: 'delivery_and_customer_service', methods: 'GET')]
    public function deliveryAndCustomerService(): Response
    {
        // We display our template. 
        return $this->render(
            'main/delivery-and-customer-service.html.twig',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the secure_payment page. 
     * @return Response
     */
    #[Route('/paiement-securise', name: 'secure_payment', methods: 'GET')]
    public function securePayment(): Response
    {
        // We display our template. 
        return $this->render(
            'main/secure-payment.html.twig',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    //! START: test of templated email
    // /**
    //  * ...
    //  * @return Response
    //  */
    // #[Route('/toto', name: 'toto', methods: 'GET')]
    // public function toto(): Response
    // {
    //     // We get the logged user.
    //     /**
    //      * @var User
    //      */
    //     $user = $this->getUser();

    //     // We display our template. 
    //     return $this->render(
    //         'emails/contact.html.twig',
    //         // We set a array of optional data.
    //         [
    //             'civilityTitle' => 'Monsieur',
    //             'firstName' => 'Clark',
    //             'lastName' => 'KENT',
    //             'userEmail' => 'clark.kent@email.com',
    //             'phoneNumber' => '0658748452',
    //             'message' => 'Le message',
    //         ],
    //         // We specify the related HTTP response status code.
    //         new Response('', 200)
    //     );
    // }

    // /**
    //  * ...
    //  * @return Response
    //  */
    // #[Route('/toto', name: 'toto', methods: 'GET')]
    // public function toto(): Response
    // {
    //     // We get the logged user.
    //     /**
    //      * @var User
    //      */
    //     $user = $this->getUser();

    //     // We display our template. 
    //     return $this->render(
    //         'emails/user/delete-request.html.twig',
    //         // 'emails/user/delete.html.twig',
    //         // 'emails/user/reactivation.html.twig',
    //         // We set a array of optional data.
    //         [
    //             'user' => $user,
    //         ],
    //         // We specify the related HTTP response status code.
    //         new Response('', 200)
    //     );
    // }
    //! END: test of templated email
}
