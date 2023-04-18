<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Entity\AddressSearch;
use App\Entity\User;
use App\Form\AddressSearchType;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAddressController extends AbstractController
{

    public function __construct(private AddressRepository $addressRepository, private EntityManagerInterface $entityManagerInterface)
    {
    }

    /**
     * Method that create a address for a user.
     * @param Request $request
     * @param User $user
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}/adresses/creer', name: 'admin_address_create', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function create(Request $request, User $user): Response
    {
        // We create a new address.
        $address = new Address();

        // We create the form.
        $form = $this->createForm(AddressType::class, $address);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We set the user to the address.
            $address->setUser($user);

            // We call the persit() method of the EntityManagerInterface to put on hold the data.
            $this->entityManagerInterface->persist($address);

            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'L\' adresse de ' . $user->getFirstName() . ' '  . $user->getLastName() . ' a bien été créée.');

            // If the query of the request contain the string returnToAdminPurchaseCreate.
            if ($request->query->get('returnToAdminPurchaseCreate')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_purchase_create',
                    // We set a array of optional data.
                    [
                        'id' => $user->getId()
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_address_user_list',
                // We set a array of optional data.
                [
                    'id' => $user->getId()
                ],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/address/create.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'adminCreateAddressForm' => $form->createView(),
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the addresses related to a user.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/adresses', name: 'admin_address_list', methods: 'GET', priority: 2)]
    public function list(Request $request): Response
    {
        // We find all the users.
        $addresses = $this->addressRepository->findAll();

        // If we don't find any address.
        if (!$addresses) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des adresses est vide. Nous vous invitons à créer une adresse pour un utilisateur.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_user_list',
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

            // If we don't find a addresses with the submitted city.
            if (!$addresses) {
                // We display a flash message for the user.
                $this->addFlash('error', 'La ville ' . $form->get('city')->getData() . ' ne correspond à aucune adresse.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_address_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/address/list.html.twig',
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
     * Method that display the addresses related to a user.
     * @param Request $request
     * @param User $user
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}/adresses', name: 'admin_address_user_list', methods: 'GET', requirements: ['id' => '\d+'], priority: 2)]
    public function userList(Request $request, User $user): Response
    {
        // We create a array to backup each address.
        $addresses = [];

        // For each $adresse in $user->getAddresses().
        foreach ($user->getAddresses() as $address) {
            // We push each $address in the array .
            $addresses[] = $address;
        }

        // If we don't find any address.
        if (!$addresses) {
            // We display a flash message for the user.
            $this->addFlash('warning', $user->getFirstName() . ' '  . $user->getLastName() . ' ne possède actuellement aucune adresse. Nous vous invitons à lui  en créer une.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_address_create',
                // We set a array of optional data.
                [
                    'id' => $user->getId()
                ],
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
            // // We find the city by its name.
            // $addresses = $this->addressRepository->findBy(
            //     [
            //         'city' => $form->get('city')->getData(),
            //         'user' => $user
            //     ]
            // );

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
                $this->addFlash('error', $user->getFirstName() . ' '  . $user->getLastName() . ' ne posséde aucune adresse ayant pour ville ' . $form->get('city')->getData() . '.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_address_user_list',
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
            'admin/address/user-list.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'searchAddressForm' => $form->createView(),
                'addresses' => $addresses
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a address related to a user.
     * @param int $addressId
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/utilisateurs/{userId}/adresses/{addressId}', name: 'admin_address_detail', methods: 'GET', requirements: ['id' => '\d+'])]
    public function detail(int $addressId, Request $request): Response
    {
        // We find the address by his id.
        $address =  $this->addressRepository->find($addressId);
        // If we don't find any address.
        if (!$address) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_address_user_list',
                // We set a array of optional data.
                [
                    'id' => $request->attributes->get('userId')
                ],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/address/detail.html.twig',
            // We set a array of optional data.
            [
                'user' => $address->getUser(),
                'address' => $address
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that update a address related to a user.
     * @param int $addressId
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/utilisateurs/{userId}/adresses/{addressId}/mettre-a-jour', name: 'admin_address_update', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function update(int $addressId, Request $request): Response
    {
        // We find the address by its id.
        $address = $this->addressRepository->find($addressId);
        // If we don't find any address.
        if (!$address) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_address_user_list',
                // We set a array of optional data.
                [
                    'id' => $request->attributes->get('userId')
                ],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We get the user related to the address.
        $user = $address->getUser();

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
            $this->addFlash('success', 'L\' adresse de ' . $user->getFirstName() . ' '  . $user->getLastName() . ' a bien été mise à jour.');

            // If the query of the request contain the string returnToAdminAddressList.
            if ($request->query->get('returnToAdminAddressList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_address_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
            // Else the query of the request doesn't contain any string. 
            else {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_address_user_list',
                    // We set a array of optional data.
                    [
                        'id' => $user->getId()
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/address/update.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'adminUpdateAddressForm' => $form->createView(),
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that delete a address related to a user.
     * @param int $addressId
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/utilisateurs/{userId}/adresses/{addressId}/supprimer', name: 'admin_address_delete', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function delete(int $addressId, Request $request): Response
    {
        // We find the address by its id.
        $address = $this->addressRepository->find($addressId);
        // If we don't find any address.
        if (!$address) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_address_user_list',
                // We set a array of optional data.
                [
                    'id' => $request->attributes->get('userId')
                ],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We get the user related to the address.
        $user = $address->getUser();

        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');

        // If the CSRF token is valid.
        if ($this->isCsrfTokenValid('admin-address-delete' . $address->getId(), $submittedToken)) {
            // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
            $this->entityManagerInterface->remove($address);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'L\' adresse de ' . $user->getFirstName() . ' '  . $user->getLastName() . ' a bien été supprimée.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_address_user_list',
                // We set a array of optional data.
                [
                    'id' => $user->getId()
                ],
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
        // $this->addFlash('success', 'L\' adresse de ' . $user->getFirstName() . ' '  . strtoupper($user->getLastName()) . ' a bien été supprimée.');

        // // We redirect the user.
        // return $this->redirectToRoute(
        //     'admin_address_user_list',
        //     // We set a array of optional data.
        //     [
        //         'id' => $user->getId()
        //     ],
        //     // We specify the related HTTP response status code.
        //     301
        // );
        //! END : if we use the API
    }
}
