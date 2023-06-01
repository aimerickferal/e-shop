<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\AddressSearchByCity;
use App\Form\AddressSearchByCityType;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Service\Cart\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class AddressController extends AbstractController
{
    public function __construct(private AddressRepository $addressRepository, private EntityManagerInterface $entityManagerInterface)
    {
    }

    /**
     * Method that create a address for the logged in user.
     * @param Request $request
     * @return Response
     */
    #[Route('/adresses/creer', name: 'address_create', methods: 'GET|POST')]
    public function create(Request $request, Cart $cart): Response
    {
        // We create a new address.
        $address = new Address();
        // We create the form.
        $form = $this->createForm(AddressType::class, $address);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We set the logged in user to the address.
            $address->setUser($this->getUser());

            // We put the data on hold.
            $this->entityManagerInterface->persist($address);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Votre adresse a bien été créée.');

            // If the we get some items in the cart or if the query of the request contain the key returnToPurchase.
            if ($cart->getItems() || $request->query->get('returnToPurchase')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'purchase',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }

            // We redirect the user.
            return $this->redirectToRoute(
                'address_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'address/create.html.twig',
            // We set a array of optional data.
            [
                'userCreateAddressForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     *  Method that display the list of the logged in user's addresses.
     * @param Request $request
     * @return Response
     */
    #[Route('/adresses', name: 'address_list', methods: 'GET', priority: 2)]
    public function list(Request $request): Response
    {
        // We get the logged in user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // We create a empty array to backup each address.
        $addresses = [];
        foreach ($user->getAddresses() as $address) {
            // We push each address in the array.
            $addresses[] = $address;
        }
        // If we don't find any address.
        if (!$addresses) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'Aucune adresse. Nous vous invitons à vous en créer une.');

            // We redirect the user.
            return $this->redirectToRoute(
                'address_create',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new address search by city.
        $search = new AddressSearchByCity();
        // We create the form.
        $form = $this->createForm(AddressSearchByCityType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We find the city by its name.
            $addresses = $this->addressRepository->findAddressByCity($search);

            foreach ($addresses as $index => $address) {
                // If the user of the adress is not identical to the logged in user.
                if ($address->getUser() !== $user) {
                    // We use the PHP method unset() to remove the adress from the addresses array so that she can't be display to the user.
                    unset($addresses[$index]);
                }
            }

            // If we don't find a addresses with the submitted city.
            if (!$addresses) {
                // We display a flash message for the user.
                $this->addFlash('error', 'Vous ne possédez aucune adresse ayant pour ville ' . $form->get('city')->getData() . '.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'address_list',
                    // We set a array of optional data.
                    [
                        'id' => $user->getId(),
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'address/list.html.twig',
            // We set a array of optional data.
            [
                'addresses' => $addresses,
                'addressSearchByCityForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a logged in user's address.
     * @param Address $address
     * @return Response
     */
    #[Route('/adresses/{id}', name: 'address_detail', methods: 'GET')]
    public function detail(Address $address): Response
    {
        // We get the logged in user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // If the user of the address is not identical to the logged in user.
        if ($address->getUser() !== $user) {
            // We redirect the user.
            return $this->redirectToRoute(
                'address_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'address/detail.html.twig',
            // We set a array of optional data.
            [
                'address' => $address
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that update a address.
     * @param Request $request
     * @param Address $address
     * @return Response
     */
    #[Route('/adresses/{id}/mettre-a-jour', name: 'address_update', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function update(Request $request, Address $address): Response
    {
        // If the user of the address is not identical to the logged in user.
        if ($address->getUser() !== $this->getUser()) {
            // We redirect the user.
            return $this->redirectToRoute(
                'address_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create the form.
        $form = $this->createForm(AddressType::class, $address);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We put the data on hold.
            $this->entityManagerInterface->persist($address);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Votre adresse a bien été mise à jour.');

            // If the query of the request contain the key returnToPurchase.
            if ($request->query->get('returnToPurchase')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'purchase',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }

            // We redirect the user.
            return $this->redirectToRoute(
                'address_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'address/update.html.twig',
            // We set a array of optional data.
            [
                'userUpdateAddressForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that delete a address.
     * @param Request $request
     * @param Address $address
     * @return Response
     */
    #[Route('/adresses/{id}/supprimer', name: 'address_delete', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function delete(Request $request, Address $address): Response
    {
        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');

        if ($this->isCsrfTokenValid('address-delete' . $address->getId(), $submittedToken)) {
            // We delete our object.
            $this->entityManagerInterface->remove($address);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Votre adresse a bien été supprimée.');

            // We redirect the user.
            return $this->redirectToRoute(
                'address_list',
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
        // $this->entityManagerInterface->remove($address);
        // // We backup the data in the database. 
        // $this->entityManagerInterface->flush();

        // // We display a flash message for the user.
        // $this->addFlash('success', 'Votre adresse a bien été supprimée.');

        // // We redirect the user.
        // return $this->redirectToRoute(
        //     'address_list',
        //     // We set a array of optional data.
        //     [],
        //     // We specify the related HTTP response status code.
        //     301
        // );
        //! END: if we use the API
    }
}
