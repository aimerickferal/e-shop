<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Admin\AdminUserSearchByLastName;
use App\Form\Admin\AdminUserType;
use App\Form\Admin\AdminUserSearchByLastNameType;
use App\Repository\UserRepository;
use App\Service\Email;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

        if ($form->isSubmitted() && $form->isValid()) {
            // We set the hashed password to the user.
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // We upload the picture submitted by the user.
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

            // We put the data on hold.
            $this->entityManagerInterface->persist($user);
            // We backup the data in the database. 
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
                'adminUserCreateForm' => $form->createView()
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

        // We create a new admin user search by last name.
        $search = new AdminUserSearchByLastName();
        // We create the form.
        $form = $this->createForm(AdminUserSearchByLastNameType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

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
                'adminUserSearchByLastNameForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the list of admin who have a ROLE_ADMIN or a ROLE_SUPER_ADMIN.
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/utilisateurs/administrateurs', name: 'admin_user_admin_list', methods: 'GET')]
    #[IsGranted(User::ROLE_SUPER_ADMIN)]
    public function adminList(Request $request): Response
    {
        // We create a empty array for the admin uers.
        $users = [];

        // We find all the users with a ROLE_SUPER_ADMIN. 
        $roleSuperAdminUsers = $this->userRepository->findUsersByRoles(User::ROLE_SUPER_ADMIN);

        // We find all the users with a ROLE_ADMIN.
        $roleAdminUsers = $this->userRepository->findUsersByRoles(User::ROLE_ADMIN);

        // We use the PHP method array_merge() to merge the two array together so that we can have all the admins user (ROLE_ADMIN and ROLE_SUPER_ADMIN) in the same array.
        $users = array_merge($roleSuperAdminUsers, $roleAdminUsers);

        // If we don't find any admin user.
        if (!$users) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'La liste des administrateurs est vide. Nous vous invitons à vous en créer un.');

            // We redirect the user.
            return $this->redirectToRoute(
                'admin_user_create',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new admin user search by last name.
        $search = new AdminUserSearchByLastName();
        // We create the form.
        $form = $this->createForm(AdminUserSearchByLastNameType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We find the user by its last name.
            $users = $this->userRepository->findUserByLastName($search);

            foreach ($users as $index => $user) {
                // If the user have only one role that mean its the ROLE_USER so the user is not a admin.
                if (count($user->getRoles()) === 1) {
                    // We use the PHP method unset() to remove the user from the user array so that he is can't be display to the user because he is not a admin user.
                    unset($users[$index]);
                }

                // dump(in_array(User::ROLE_ADMIN, $user->getRoles()));
                // dump(in_array(User::ROLE_SUPER_ADMIN, $user->getRoles()));
                // dd(42);
            }

            // dd($users);

            // If we don't find a user with the submitted last name.
            if (!$users) {
                // We display a flash message for the user.
                $this->addFlash('error', 'Le nom ' . strtoupper($form->get('lastName')->getData()) . ' ne correspond à aucun administrateur.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'admin_user_admin_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }
        }

        // We display our template.
        return $this->render(
            'admin/user/admin-list.html.twig',
            // We set a array of optional data.
            [
                'users' => $users,
                'adminUserSearchForm' => $form->createView()
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

        if ($form->isSubmitted() && $form->isValid()) {
            // We upload the picture submitted by the user.
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

            // We backup the data in the database. 
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
                'adminUserUpdateForm' => $form->createView()
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

        if ($this->isCsrfTokenValid('delete-user-picture' . $user->getId(), $submittedToken)) {
            // We get the user's picture.
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

            // We backup the data in the database. 
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
        // Else the submitted CSRF token is not valid.
        else {
            // We redirect the user to the 403 page. 
            return new Response(
                'Action interdite',
                // We specify the related HTTP response status code.
                403
            );
        }
    }

    /**
     * Metho that show some statistics for the user.
     * @return Response
     */
    #[Route('/admin/utilisateurs/statistiques', name: 'admin_user_statistics', methods: 'GET', requirements: ['id' => '\d+'])]
    public function statistics(): Response
    {
        // We find all the users.
        $users = $this->userRepository->findAll();

        $numberOfAdmins = count($this->userRepository->findUsersByRoles(User::ROLE_ADMIN)) + count($this->userRepository->findUsersByRoles(User::ROLE_SUPER_ADMIN));

        // If we don't find any user.
        if (!$users) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'Aucun utilisateur.');

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
            // This data is backup in several HTML dataset properties that are get in the chart.js module.
            [
                'numberOfUsers' => count($users),
                'numberOfRolesUser' => count($this->userRepository->findUsersByRoles("[]")),
                'numberOfAdmins' => $numberOfAdmins,
                'numberOfMans' => count($this->userRepository->findByCivilityTitle([User::MAN_CIVILITY_TITLE])),
                'numberOfWomans' => count($this->userRepository->findByCivilityTitle([User::WOMAN_CIVILITY_TITLE]))
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that delete a user.
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

        if ($this->isCsrfTokenValid('admin-user-delete' . $user->getId(), $submittedToken)) {
            // We get the user's picture.
            $picture = $user->getPicture();

            foreach ($user->getAddresses() as $address) {
                // We delete our object.
                $this->entityManagerInterface->remove($address);
            }

            foreach ($user->getPurchases() as $purchase) {
                // The user property of the purchase will be null. 
                $purchase->setUser(null);
            }

            // We delete our object.
            $this->entityManagerInterface->remove($user);
            // We backup the data in the database. 
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
        // $this->entityManagerInterface->remove($user);
        // // We backup the data in the database. 
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
