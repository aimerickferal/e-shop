<?php

namespace App\Controller\Admin;

use App\Entity\DeliveryMode;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\PurchaseSearch;
use App\Entity\User;
use App\Form\PurchaseSearchType;
use App\Form\Admin\AdminPurchaseType;
use App\Repository\DeliveryModeRepository;
use App\Repository\PurchaseRepository;
use App\Service\Cart\Cart;
use App\Service\FileUploader;
use App\Service\PurchaseAddress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPurchaseController extends AbstractController
{
    public function __construct(private PurchaseRepository $purchaseRepository, private PurchaseAddress $purchaseAddress, private FileUploader $fileUploader, private EntityManagerInterface $entityManagerInterface)
    {
    }

    /**
     * Method that create a purchase for a user according to the CartItems() present in the cart.
     * @return Request $request
     * @param User $user
     * @return Cart $cart
     * @return DeliveryModeRepository $deliveryModeRepository
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}/commandes/creer', name: 'admin_purchase_create', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function create(Request $request, User $user, Cart $cart, DeliveryModeRepository $deliveryModeRepository): Response
    {

        // // We create a empty array to backup each address.
        // $addresses = [];
        // // For each $adresse in $user->getAddresses().
        // foreach ($user->getAddresses() as $address) {
        //     // We push each address in the array.
        //     $addresses[] = $address;
        // }
        // // If we don't find any address.
        // if (!$addresses) {
        //     // We display a flash message for the user.
        //     $this->addFlash('warning', $user->getFirstName() . ' '  . strtoupper($user->getLastName()) . ' ne possède actuellement aucune adresse. Nous vous invitons à lui  en créer une.');

        //     // We redirect the user.
        //     return $this->redirectToRoute(
        //         'admin_address_create',
        //         // We set a array of optional data.
        //         [
        //             'id' => $user->getId()
        //         ],
        //         // We specify the related HTTP response status code.
        //         301
        //     );
        // }

        // We create a new purchase.
        $purchase = new Purchase();
        // We set the user to the purchase.
        $purchase->setUser($user);
        // We create the form.
        $form = $this->createForm(AdminPurchaseType::class, $purchase);
        // We link the form to the request.
        $form->handleRequest($request);

        // We create a array to backup the pictures of each delivery mode.
        $deliveryModePictures = [];
        foreach ($deliveryModeRepository->findAll() as $deliveryMode) {
            // We push each delivery mode pictures in the array .
            $deliveryModePictures[] = $deliveryMode->getPicture();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // If we don't find any CartItems() in the cart.
            if (!$cart->getItems()) {
                // We display a flash message for the user.
                $this->addFlash('error', 'La commande ne contient aucun produit. Merci  de vous rendre sur la page d\'accueil ou sur la page produits afin d\'ajouter des produits au panier.');

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

            // We set the billing address to the purchase.
            $purchase->setBillingAddress($this->purchaseAddress->insertBreakLineCharactersInAddress($user, $form->get('billingAddress')->getData()));

            // We set the delivery address to the purchase.
            $purchase->setDeliveryAddress($this->purchaseAddress->insertBreakLineCharactersInAddress($user, $form->get('deliveryAddress')->getData()));

            // We set some properties to the purchase.
            $purchase
                ->setSubtotal($cart->getTotal())
                ->setDeliveryModePrice(DeliveryMode::DELIVERY_PRICE_FREE)
                ->setTotal($purchase->getSubtotal() + DeliveryMode::DELIVERY_PRICE_FREE)
                ->setCheckoutMethod(Purchase::CHECKOUT_METHOD_DISPOSAL);

            // For each $cartItems in $cart->getItems().
            foreach ($cart->getItems() as $cartItems) {
                // We create a new PurchaseItem.
                $purchaseItem = new PurchaseItem();
                // We set the properties of the purchaseItem.
                $purchaseItem
                    ->setPurchase($purchase)
                    ->setProductName($cartItems->product->getName())
                    ->setProductReference($cartItems->product->getReference())
                    ->setProductPrice($cartItems->product->getPrice())
                    ->setProduct($cartItems->product)
                    ->setQuantity($cartItems->quantity)
                    ->setTotal($cartItems->getTotal());

                // We put the data on hold.
                $this->entityManagerInterface->persist($purchaseItem);
            }

            // We call the uploadFile() method of the FileUploader service to upload the bill submited by the user.
            $bill = $this->fileUploader->uploadFile($form, 'bill');

            // If we have a bill to upload.
            if ($bill) {
                // We set the bill to the purchase.
                $purchase->setBill($bill);
            }

            // We put the data on hold.
            $this->entityManagerInterface->persist($purchase);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We remove the cart form the session.
            $request->getSession()->remove('cart');

            // We display a flash message for the user.
            $this->addFlash('success', 'La commande ' . $purchase->getReference() . ' pour ' . $user->getFirstName() . ' '  . $user->getLastName() . ' a bien été créée.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_purchase_user_list',
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
            'admin/purchase/create.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'adminPurchaseCreateForm' => $form->createView(),
                'deliveryModePictureUploadFolderPath' => DeliveryMode::PICTURE_UPLOAD_FOLDER_PATH,
                'deliveryModePictures' => $deliveryModePictures,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the purchases.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/commandes', name: 'admin_purchase_list', methods: 'GET')]
    public function list(Request $request): Response
    {
        // We find all the purchases.
        $purchases = $this->purchaseRepository->findAll();

        //! START: purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.
        // // For each purchase in $purchases.
        // foreach ($purchases as $index => $purchase) {
        //     // if the status of the purchase status is identical to the value of the PHP constant STATUS_ABANDONNED_CHECKOUT.
        //     if ($purchase->getStatus() === Purchase::STATUS_ABANDONNED_CHECKOUT) {
        //         // We use the PHP method unset() to remove the purchase from the purchases array so that she is can't be display to the user.
        //         unset($purchases[$index]);
        //     }
        // }
        //! END: purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.

        // If we don't find any purchase.
        if (!$purchases) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des commandes est vide.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_dashboard',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new purchase search.
        $search = new PurchaseSearch();
        // We create the form.
        $form = $this->createForm(PurchaseSearchType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We find the purchase by its reference.
            $purchases = $this->purchaseRepository->findPurchaseByReference($search);

            // If we don't find a purchase with the submitted reference.
            if (!$purchases) {
                // We display a flash message for the user.
                $this->addFlash('error', 'La commande ' . $form->get('reference')->getData() . ' n\'existe pas.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_purchase_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/purchase/list.html.twig',
            // We set a array of optional data.
            [
                'purchaseSearchForm' => $form->createView(),
                'purchases' => $purchases,
                'statusPaid' => Purchase::STATUS_PAID,
                'statusInProgress' => Purchase::STATUS_IN_PROGRESS,
                'statusSend' => Purchase::STATUS_SEND,
                'statusDeliver' => Purchase::STATUS_DELIVER,
                'statusAnnul' => Purchase::STATUS_ANNUL
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the purchases related to a user.
     * @param Request $request
     * @param User $user
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}/commandes', name: 'admin_purchase_user_list', methods: 'GET', requirements: ['id' => '\d+'])]
    public function userList(Request $request, User $user): Response
    {
        // We create a array to backup each purchase.
        $purchases = [];
        // We create a array to backup each reference.
        $references = [];
        foreach ($user->getPurchases() as $purchase) {
            //! START: purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.
            // // if the status of the purchase status is identical to the value of the PHP constant STATUS_ABANDONNED_CHECKOUT.
            // if ($purchase->getStatus() === Purchase::STATUS_ABANDONNED_CHECKOUT) {
            //     // We begin the next iteration of the loop so we don't put the purchase in the purchases array. 
            //     continue;
            // }
            //! END: purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.

            // We push each purchase in the array.
            $purchases[] = $purchase;
            // We push each purchase reference in the array.
            $references[] = $purchase->getReference();
        }

        // If we don't find any purchase.
        if (!$purchases) {
            // We display a flash message for the user.
            $this->addFlash('warning', $user->getFirstName() . ' '  . $user->getLastName() . ' ne possède actuellement aucune commande. Nous vous invitons à lui  en créer une.');

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

        // We create a new purchase search.
        $search = new PurchaseSearch();
        // We create the form.
        $form = $this->createForm(PurchaseSearchType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We find the purchase by its reference.
            $purchases = $this->purchaseRepository->findPurchaseByReference($search);

            // If we don't find a purchase with the submitted reference.
            if (!$purchases) {
                // We display a flash message for the user.
                $this->addFlash('error', 'La commande ' . $form->get('reference')->getData() . ' n\'existe pas.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_purchase_user_list',
                    // We set a array of optional data.
                    [
                        'id' => $user->getId(),
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }

            foreach ($purchases as $purchase) {
                // If the user of the purchase is not identical to the user.
                if ($purchase->getUser() !== $user) {
                    // We display a flash message for the user.
                    $this->addFlash('error', 'La commande ' . $form->get('reference')->getData() . ' n\'appartient pas à ' . $user->getFirstName() . ' ' . $user->getLastName() . ' mais à ' . $purchase->getUser()->getFirstName() . ' ' . $purchase->getUser()->getLastName() . '.');

                    // We redirect the user.
                    return $this->redirectToRoute(
                        'admin_purchase_user_list',
                        // We set a array of optional data.
                        [
                            'id' => $user->getId(),
                        ],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
            }
        }

        // We display our template.
        return $this->render(
            'admin/purchase/user-list.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'purchaseSearchForm' => $form->createView(),
                'purchases' => $purchases,
                'statusPaid' => Purchase::STATUS_PAID,
                'statusInProgress' => Purchase::STATUS_IN_PROGRESS,
                'statusSend' => Purchase::STATUS_SEND,
                'statusDeliver' => Purchase::STATUS_DELIVER,
                'statusAnnul' => Purchase::STATUS_ANNUL
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a purchase.
     * @param string $reference
     * @return Response
     */
    #[Route('/admin/commandes/{reference}', name: 'admin_purchase_detail', methods: 'GET')]
    public function detail(string $reference): Response
    {
        // We find the purchase by its reference.
        $purchase =  $this->purchaseRepository->findOneBy(['reference' => $reference]);

        // We create a array to backup each purchase item.
        $purchaseItems = [];
        foreach ($purchase->getPurchaseItems() as $purchaseItem) {
            // We push each address in the array.
            $purchaseItems[] = $purchaseItem;
        }

        // We display our template.
        return $this->render(
            'admin/purchase/detail.html.twig',
            // We set a array of optional data.
            [
                'user' => $purchase->getUser(),
                'purchase' => $purchase,
                'billingAddress' => $this->purchaseAddress->showAddress($purchase->getBillingAddress()),
                'deliveryAddress' => $this->purchaseAddress->showAddress($purchase->getDeliveryAddress()),
                'purchaseItems' => $purchaseItems,
                'statusPaid' => Purchase::STATUS_PAID,
                'statusInProgress' => Purchase::STATUS_IN_PROGRESS,
                'statusSend' => Purchase::STATUS_SEND,
                'statusDeliver' => Purchase::STATUS_DELIVER,
                'statusAnnul' => Purchase::STATUS_ANNUL
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a purchase related to a user.
     * @param string $reference
     * @return Response
     */
    #[Route('/admin/utilisateurs/{userId}/commandes/{reference}', name: 'admin_purchase_user_detail', methods: 'GET')]
    public function userDetail(string $reference): Response
    {
        // We find the purchase by its reference.
        $purchase =  $this->purchaseRepository->findOneBy(['reference' => $reference]);

        // If we don't find any purchase.
        if (!$purchase) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_purchase_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a array to backup each purchase item.
        $purchaseItems = [];
        foreach ($purchase->getPurchaseItems() as $purchaseItem) {
            // We push each address in the array.
            $purchaseItems[] = $purchaseItem;
        }

        // We display our template.
        return $this->render(
            'admin/purchase/user-detail.html.twig',
            // We set a array of optional data.
            [
                'user' => $purchase->getUser(),
                'purchase' => $purchase,
                'billingAddress' => $this->purchaseAddress->showAddress($purchase->getBillingAddress()),
                'deliveryAddress' => $this->purchaseAddress->showAddress($purchase->getDeliveryAddress()),
                'purchaseItems' => $purchaseItems,
                'statusPaid' => Purchase::STATUS_PAID,
                'statusInProgress' => Purchase::STATUS_IN_PROGRESS,
                'statusSend' => Purchase::STATUS_SEND,
                'statusDeliver' => Purchase::STATUS_DELIVER,
                'statusAnnul' => Purchase::STATUS_ANNUL
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that update a purchase related to a user.
     * @param string $reference
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/utilisateurs/{userId}/commandes/{reference}/mettre-a-jour', name: 'admin_purchase_update', methods: 'GET|POST')]
    public function update(string $reference, Request $request): Response
    {
        // We find the purchase by its reference.
        $purchase =  $this->purchaseRepository->findOneBy(['reference' => $reference]);

        // If we don't find any purchase or if the status of the purchase is identical to Purchase::STATUS_DELIVER or Purchase::STATUS_ANNUL.
        if (
            !$purchase ||
            $purchase->getStatus() === Purchase::STATUS_DELIVER ||  $purchase->getStatus() === Purchase::STATUS_ANNUL
        ) {
            // If the status of the purchase is identical to Purchase::STATUS_DELIVER or Purchase::STATUS_ANNUL. 
            if (
                $purchase->getStatus() === Purchase::STATUS_DELIVER ||
                $purchase->getStatus() === Purchase::STATUS_ANNUL
            ) {
                // We display a flash message for the user.
                $this->addFlash('error', 'La commande ' . strtoupper($purchase->getReference()) . ' n\'est pas modifiable car elle a été ' . strtolower($purchase->getStatus()) . '.');
            }

            // If the query of the request contain the key returnToAdminPurchaseUserList.
            if ($request->query->get('returnToAdminPurchaseUserList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_purchase_user_list',
                    // We set a array of optional data.
                    [
                        'id' => $request->attributes->get('userId')
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }
            // Else if the query of the request contain the string returnToAdminPurchaseList.
            elseif ($request->query->get('returnToAdminPurchaseList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_purchase_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We get the user related to the purchase.
        $user = $purchase->getUser();
        // If we don't find a user.
        if (!$user) {
            // We display a flash message for the user.
            $this->addFlash('error', 'La commande ' . $purchase->getReference() . ' n\'est pas modifiable car le compte de l\'utilisateur auquel elle est liée a été supprimé.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_purchase_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create the form.
        $form = $this->createForm(AdminPurchaseType::class, $purchase);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We call the uploadFile() method of the FileUploader service to upload the bill submited by the user.
            $bill = $this->fileUploader->uploadFile($form, 'upload');

            // If we have a bill to upload.
            if ($bill) {
                // We get the current bill of the purchase that will be his previous bill after the update. 
                $previousBill = $purchase->getBill();

                // We set the bill to the purchase.
                $purchase->setBill($bill);

                // If the previous bill of the purchase is different than the previous bill. 
                if ($previousBill !== Purchase::BILL_BY_DEFAULT) {
                    // We use the PHP function unlink() to delete, from our folder, the previous bill of the purchase. 
                    unlink(Purchase::BILL_UPLOAD_FOLDER_PATH . '/' . $previousBill);
                }
            }
            // Else the user have not submitted any bill.
            else {
                // We set the value of the initial bill to the purchase.
                $purchase->setBill($purchase->getBill());
            }

            // We put the data on hold.
            $this->entityManagerInterface->persist($purchase);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'La commande ' . strtoupper($purchase->getReference()) . ' de ' . $user->getFirstName() . ' '  . $user->getLastName() . ' a bien été mise à jour.');

            // If the query of the request contain the key returnToAdminPurchaseUserList.
            if ($request->query->get('returnToAdminPurchaseUserList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_purchase_user_list',
                    // We set a array of optional data.
                    [
                        'id' => $request->attributes->get('userId')
                    ],
                    // We specify the related HTTP response status code.
                    301
                );
            }
            // Else if the query of the request contain the string returnToAdminPurchaseList.
            elseif ($request->query->get('returnToAdminPurchaseList')) {
                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_purchase_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/purchase/update.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'purchase' => $purchase,
                'adminPurchaseUpdateForm' => $form->createView(),
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Metho that delete a purchase.
     * @param Request $request
     * @param Purchase $purchase
     * @return Response
     */
    #[Route('/admin/commandes/{id}/supprimer', name: 'admin_purchase_delete', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function delete(Request $request, Purchase $purchase): Response
    {
        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');

        if ($this->isCsrfTokenValid('admin-purchase-delete' . $purchase->getId(), $submittedToken)) {
            // We delete our object.
            $this->entityManagerInterface->remove($purchase);
            // We backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'La commande ' . $purchase->getReference() . ' a bien été supprimée.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_purchase_list',
                // We set a array of optional data.
                [
                    'user' => $purchase->getUser(),
                ],
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
        // $this->entityManagerInterface->remove($purchase);
        // // We backup the data in the database. 
        // $this->entityManagerInterface->flush();

        // // We display a flash message for the user.
        // $this->addFlash('success', 'La commande ' . $purchase->getReference() . ' a bien été supprimée.');

        // // We redirect the user.
        // return $this->redirectToRoute(
        //     'admin_purchase_list',
        //     // We set a array of optional data.
        //     [
        //         'user' => $purchase->getUser(),
        //     ],
        //     // We specify the related HTTP response status code.
        //     301
        // );
        //! END: if we use the API
    }

    /**
     * Method that download the purchase of the user according to the purchase reference.
     * @param string $reference
     * @return Response
     */
    #[Route('/admin/commandes/{reference}/telecharger/facture', name: 'admin_purchase_download_bill', methods: 'GET')]
    public function downloadBill(string $reference): Response
    {
        // We find the purchase by its reference.
        $purchase =  $this->purchaseRepository->findOneBy(['reference' => $reference]);

        // If we don't find any purchase.
        if (!$purchase) {
            // We redirect the user.
            return $this->redirectToRoute(
                'admin_purchase_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // The path to the files is relative to the public folder.
        return $this->file(Purchase::BILL_UPLOAD_FOLDER_PATH . "/" . $purchase->getBill(), "facture-" . $purchase->getReference());
    }
}
