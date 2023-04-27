<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\UserSearch;
use App\Form\Admin\AdminUserType;
use App\Form\Admin\AdminUserSearchType;
use App\Repository\UserRepository;
use App\Service\Email;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $entityManagerInterface, private Email $email, private FileUploader $fileUploader)
    {
    }

    /**
     * Method that create a user.
     * @param Request $request
     * @param UserPasswordHasherInterface $UserPasswordHasherInterface
     * @return Response
     */
    #[Route('/admin/utilisateurs/creer', name: 'admin_user_create', methods: 'GET|POST')]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        // We create a new user.
        $user = new User();
        // We create the form.
        $form = $this->createForm(AdminUserType::class, $user);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We set the hashed password to the user.
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // We call the uploadFile() method of the FileUploader service to upload the picture submitted by the user.
            $picture = $this->fileUploader->uploadFile($form, 'picture');

            // If we have a picture to upload.
            if ($picture) {
                // We set the picture to the user.
                $user->setPicture($picture);
            }
            // Else the user have not submitted any picture so we set a picture by default according to its civility title.
            else {
                // If the civility title of the user is User::MAN_CIVILITY_TITLE.
                if ($user->getCivilityTitle() === User::MAN_CIVILITY_TITLE) {
                    // We set the User::MAN_PICTURE to the user.
                    $user->setPicture(User::MAN_PICTURE);
                }
                // Else if the civility title of the user is User::WOMAN_CIVILITY_TITLE.
                elseif ($user->getCivilityTitle() === User::WOMAN_CIVILITY_TITLE) {
                    // We set the User::WOMAN_PICTURE to the user.
                    $user->setPicture(User::WOMAN_PICTURE);
                }
            }

            // We call the persit() method of the EntityManagerInterface to put on hold the data.
            $this->entityManagerInterface->persist($user);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            // $this->addFlash('success', 'Le compte de ' . $user->getFirstName() . ' ' . strtoupper($user->getLastName()) . ' a bien été créé.'); 
            $this->addFlash('success', 'Le compte de ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a bien été créé.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_user_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/user/create.html.twig',
            // We set a array of optional data.
            [
                'adminCreateUserForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the users.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/utilisateurs', name: 'admin_user_list', methods: 'GET', priority: 1)]
    public function list(Request $request): Response
    {
        // We find all the users.
        $users = $this->userRepository->findAll();

        // If we don't find any user.
        if (!$users) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des utilisateurs est vide. Nous vous invitons à vous en créer un.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_user_create',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new user search.
        $search = new UserSearch();
        // We create the form.
        $form = $this->createForm(AdminUserSearchType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We find the user by its last name.
            $users = $this->userRepository->findUserByLastName($search);

            // If we don't find a user with the submitted last name.
            if (!$users) {
                // We display a flash message for the user.
                $this->addFlash('error', 'Le nom ' . strtoupper($form->get('lastName')->getData()) . ' ne correspond à aucun utilisateur.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_user_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/user/list.html.twig',
            // We set a array of optional data.
            [
                'users' => $users,
                'searchUserForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a user.
     * @param User $user
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}', name: 'admin_user_detail', methods: 'GET', requirements: ['id' => '\d+'])]
    public function detail(User $user): Response
    {
        // We display our template.
        return $this->render(
            'admin/user/detail.html.twig',
            // We set a array of optional data.
            [
                'user' => $user
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that update a user.
     * @param Request $request
     * @param User $user
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}/mettre-a-jour', name: 'admin_user_update', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function update(Request $request, User $user): Response
    {
        // We create the form.
        $form = $this->createForm(AdminUserType::class, $user);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We call the uploadFile() method of the FileUploader service to upload the picture submitted by the user.
            $picture = $this->fileUploader->uploadFile($form, 'upload');

            // If we have a picture to upload.
            if ($picture) {
                // We get the current picture of the user that will be his previous picture after the update. 
                $previousPicture = $user->getPicture();

                // If the previous picture of the user is different than User::MAN_PICTURE and than User::WOMAN_PICTURE.
                if (
                    $previousPicture !== User::MAN_PICTURE &&
                    $previousPicture !== User::WOMAN_PICTURE
                ) {
                    // We use the PHP function unlink() to delete, from our folder, the previous picture of the user. 
                    unlink(User::PICTURE_UPLOAD_FOLDER_PATH . '/' . $previousPicture);
                }

                // We set the picture to the user.
                $user->setPicture($picture);
            }
            // Else the user have not submitted any picture so we set a picture by default depending on his gender.
            else {
                // If the user's gender is diffent than User::MAN_CIVILITY_TITLE or than User::WOMAN_CIVILITY_TITLE.
                if (
                    $user->getCivilityTitle() !== User::MAN_CIVILITY_TITLE || $user->getCivilityTitle() !== User::WOMAN_CIVILITY_TITLE
                ) {
                    // If the user picture is different than User::MAN_PICTURE and than User::WOMAN_PICTURE.
                    if (
                        $user->getPicture() !== User::MAN_PICTURE &&
                        $user->getPicture() !== User::WOMAN_PICTURE
                    ) {
                        // We don't want to change the picture that the user have already set for himself.
                        // We set the value of the initial user picture to the user.
                        $user->setPicture($user->getPicture());
                    }
                    // Else the user's picture is one of our picture by default.
                    else {
                        // If the civility title of the user is User::MAN_CIVILITY_TITLE.
                        if ($user->getCivilityTitle() === User::MAN_CIVILITY_TITLE) {
                            // We set the User::MAN_PICTURE to the user.
                            $user->setPicture(User::MAN_PICTURE);
                        }
                        // Else if the civility title of the user is User::WOMAN_CIVILITY_TITLE.
                        elseif ($user->getCivilityTitle() === User::WOMAN_CIVILITY_TITLE) {
                            // We set the User::WOMAN_PICTURE to the user.
                            $user->setPicture(User::WOMAN_PICTURE);
                        }
                    }
                }
            }

            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'Le profil de ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a bien été mis à jour.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_user_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/user/update.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'adminUpdateUserForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that delete the user picture and update the picture with the a picture according to the user civility title.
     * @param Request $request
     * @param User $user
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}/supprimer-photo', name: 'admin_user_delete_picture', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function deletePicture(Request $request, User $user): Response
    {
        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');

        // If the CSRF token is valid.
        if ($this->isCsrfTokenValid('delete-user-picture' . $user->getId(), $submittedToken)) {
            // We get the picture of the user. 
            $picture = $user->getPicture();

            // If the picture of the user is different than User::MAN_PICTURE and than User::WOMAN_PICTURE.
            if (
                $picture !== User::MAN_PICTURE &&
                $picture !== User::WOMAN_PICTURE
            ) {
                // We use the PHP function unlink() to delete, from our folder, the picture of the user. 
                unlink(User::PICTURE_UPLOAD_FOLDER_PATH . '/' . $picture);
            }

            // If the civility title of the user is User::MAN_CIVILITY_TITLE.
            if ($user->getCivilityTitle() === User::MAN_CIVILITY_TITLE) {
                // We set the User::MAN_PICTURE to the user.
                $user->setPicture(User::MAN_PICTURE);
            }
            // Else if the civility title of the user is User::WOMAN_CIVILITY_TITLE.
            elseif ($user->getCivilityTitle() === User::WOMAN_CIVILITY_TITLE) {
                // We set the User::WOMAN_PICTURE to the user.
                $user->setPicture(User::WOMAN_PICTURE);
            }

            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We display a flash message for the user.
            $this->addFlash('success', 'La photo de profil de ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a bien été supprimée. Une photo de profil par défaut a été mise en place.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_user_list',
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
    }

    /**
     * Metho that show some statistics for the User.
     * @return Response
     */
    #[Route('/admin/utilisateurs/statistiques', name: 'admin_user_statistics', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function statistics(): Response
    {
        // We find all the users.
        $users = $this->userRepository->findAll();
        // If we don't find any user.
        if (!$users) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des utilisateurs est vide.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_dashboard',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template.
        return $this->render(
            'admin/user/statistics.html.twig',
            // We set a array of optional data.
            [
                'numberOfUsers' => count($users),
                'numberOfRolesUser' => count($this->userRepository->findUsersByRoles("[]")),
                'numberOfRolesAdmin' => count($this->userRepository->findUsersByRoles(User::ROLE_ADMIN)),
                'numberOfMans' => count($this->userRepository->findByCivilityTitle([User::MAN_CIVILITY_TITLE])),
                'numberOfWomans' => count($this->userRepository->findByCivilityTitle([User::WOMAN_CIVILITY_TITLE])),
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that delete a user account 30 days after the request.
     * @param Request $request
     * @param User $user
     * @return Response
     */
    #[Route('/admin/utilisateurs/{id}/supprimer', name: 'admin_user_delete', methods: 'GET|POST', requirements: ['id' => '\d+'])]
    public function delete(Request $request, User $user): Response
    {
        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');
        // dump($request->request->get('token'));
        // dump($request->query->get('token'));
        // dump($request->attributes->get('token'));

        // If the CSRF token is valid.
        if ($this->isCsrfTokenValid('admin-user-delete' . $user->getId(), $submittedToken)) {
            // We get the picture of the user. 
            $picture = $user->getPicture();

            // For each $adresse in $user->getAddresses().
            foreach ($user->getAddresses() as $address) {
                // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
                $this->entityManagerInterface->remove($address);
            }

            // For each $purchase in $user->getPurchases().
            foreach ($user->getPurchases() as $purchase) {
                // The user property of the purchase will be null. 
                $purchase->setUser(null);
            }

            // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
            $this->entityManagerInterface->remove($user);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // If the picture of the user is different than User::MAN_PICTURE and than User::WOMAN_PICTURE.
            if (
                $picture !== User::MAN_PICTURE &&
                $picture !== User::WOMAN_PICTURE
            ) {
                // We use the PHP function unlink() to delete, from our folder, the picture of the user. 
                unlink(User::PICTURE_UPLOAD_FOLDER_PATH . '/' . $picture);
            }

            // We display a flash message for the user.
            $this->addFlash('success', 'Le compte de ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a bien été supprimé.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_user_list',
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

        //! START: if we use the API
        // // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
        // $this->entityManagerInterface->remove($user);
        // // We call the flush() method of the EntityManagerInterface to backup the data in the database.
        // $this->entityManagerInterface->flush();

        // // We display a flash message for the user.
        // $this->addFlash('success', 'Le compte de ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a bien été supprimé.');

        // // We redirect the user.
        // return $this->redirectToRoute(
        //     'admin_user_list',
        //     // We set a array of optional data.
        //     [],
        //     // We specify the related HTTP response status code.
        //     301
        // );
        //! END: if we use the API
    }
}
