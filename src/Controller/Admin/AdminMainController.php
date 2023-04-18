<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\CategoryRepository;
use App\Repository\DeliveryModeRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMainController extends AbstractController
{
    /** 
     * Method that display the dashboard.
     * @param UserRepository $userRepository
     * @param AddressRepository $addressRepository
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     * @param DeliveryModeRepository $deliveryModeRepository
     * @param PurchaseRepository $purchaseRepository
     * @return Response
     */
    #[Route('/admin', name: 'admin_dashboard', methods: 'GET', priority: 3)]
    public function dashboard(UserRepository $userRepository, AddressRepository $addressRepository, CategoryRepository $categoryRepository, ProductRepository $productRepository, DeliveryModeRepository $deliveryModeRepository, PurchaseRepository $purchaseRepository): Response
    {
        // We display our template. 
        return $this->render(
            'admin/main/dashboard.html.twig',
            // We set a array of optional data.
            [
                'numberOfUsers' => count($userRepository->findAll()),
                // 'users' => count($userRepository->findUsersByRoles("[]")),
                'admins' => count($userRepository->findUsersByRoles(User::ROLE_ADMIN)),
                'addresses' => count($addressRepository->findAll()),
                'categories' => count($categoryRepository->findAll()),
                'products' => count($productRepository->findAll()),
                'deliveryModes' => count($deliveryModeRepository->findAll()),
                'purchases' => count($purchaseRepository->findAll())
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }
}
