<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\AddressSearch;
use App\Form\AddressSearchType;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
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

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We set the logged in user to the address.
            $address->setUser($this->getUser());

            // We call the persit() method of the EntityManagerInterface to put on hold the data.
            $this->entityManagerInterface->persist($address);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
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
     *  Method that display the logged in user's addresses.
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

        // We create a array to backup each address.
        $addresses = [];
        // For each $adresse in $user->getAddresses().
        foreach ($user->getAddresses() as $address) {
            // We push each $address in the array.
            $addresses[] = $address;
        }
        // If we don't find any address.
        if (!$addresses) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'Vous ne possédez actuellement aucune adresse. Nous vous invitons à vous en créer une.');

            // We redirect the user.
            return $this->redirectToRoute(
                'address_create',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new address search.
        $search = new AddressSearch();
        // We create the form.
        $form = $this->createForm(AddressSearchType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We find the city by its name.
            $addresses = $this->addressRepository->findAddressByCity($search);

            // For each $address in $addresses .
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
                'searchAddressForm' => $form->createView(),
                'addresses' => $addresses
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a logged in user's address.
     * @param int $id
     * @return Response
     */
    #[Route('/adresses/{id}', name: 'address_detail', methods: 'GET', requirements: ['id' => '\d+'])]
    public function detail(int $id): Response
    {
        // We find the address by its id.
        $address =  $this->addressRepository->find($id);

        // If we don't find any address.
        if (!$address) {
            // We redirect the user.
            return $this->redirectToRoute(
                'address_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

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

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We call the persit() method of the EntityManagerInterface to put on hold the data.
            $this->entityManagerInterface->persist($address);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
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

        // If the CSRF token is valid.
        if ($this->isCsrfTokenValid('address-delete' . $address->getId(), $submittedToken)) {
            // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
            $this->entityManagerInterface->remove($address);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
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
        // $this->entityManagerInterface->remove($address);
        // // We call the flush() method of the EntityManagerInterface to backup the data in the database.
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
        //! END : if we use the API
    }
}
