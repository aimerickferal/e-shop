<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Email;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManagerInterface, private Email $email)
    {
    }

    /** 
     * Method that display the detail of the logged in user's profile. 
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    #[Route('/profil', name: 'user_profile', methods: 'GET|POST', priority: 3)]
    public function profile(Request $request, FileUploader $fileUploader): Response
    {
        // We get the logged in user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // TODO #2 START: solve issue on switch civilityTitle.  
        // dd($user->getCivilityTitle());
        // TODO #2 END: solve issue on switch civilityTitle.   

        // We create the form.
        $form = $this->createForm(UserType::class, $user);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid. 
        if ($form->isSubmitted() && $form->isValid()) {
            // TODO #2 END: solve issue on switch civilityTitle.   
            // dump($user->getCivilityTitle());
            // dd(42);
            // TODO #2 END: solve issue on switch civilityTitle.

            // We call the uploadFile() method of the FileUploader service to upload the picture submitted by the user. 
            $picture = $fileUploader->uploadFile($form, 'upload');

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

            // TODO #2 START: solve issue on switch civilityTitle.  
            // The civility title doesn't switch normaly like all the other properties.
            // If we use onPreSubmit() in UserType.php : the civility title switch correctly to the new one. 
            // If don't use onPreSubmit() in UserType.php : the civility title doesn't switch, he keep is hold value.
            // Why we have to use onPreSubmit() so that the civility title switch correctly ? 
            // TODO #2 END: solve issue on switch civilityTitle.    
            // }

            // We call the flush() method of the EntityManagerInterface to backup the data in the database. 
            $this->entityManagerInterface->flush();

            // We display a flash message for the user. 
            // $this->addFlash('success', 'Bonjour ' . $user->getFirstName() . ', votre profil a bien été mis à jour.');
            $this->addFlash('success', 'Votre profil a bien été mis à jour.');

            // We redirect the user.
            return $this->redirectToRoute(
                'user_profile',
                // We set a array of optional data. 
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We display our template. 
        return $this->render(
            'user/profile.html.twig',
            // We set a array of optional data.
            [
                'userProfileForm' => $form->createView()
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /** 
     * Method that delete the user picture and update the picture with the a picture according to the user civility title.
     * @param Request $request
     * @return Response
     */
    #[Route('/supprimer-ma-photo', name: 'user_delete_picture', methods: 'GET|POST', priority: 4)]
    public function deletePicture(Request $request): Response
    {
        // We get the logged user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // We catch the csrfToken that the user submit after his click on the delete my picture button.
        $submittedToken = $request->query->get('token');

        // If the submitted token is valid.
        if ($this->isCsrfTokenValid('delete-my-user-picture' . $user->getId(), $submittedToken)) {
            // We get the picture of the user. 
            $picture = $user->getPicture();

            // If the picture of the user is different than User::MAN_PICTURE and than User::WOMAN_PICTURE.
            if (
                $picture !== User::MAN_PICTURE &&
                $picture !== User::WOMAN_PICTURE
            ) {
                // We use the PHP function unlink() to delete, from our folder, the previous picture of the user. 
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
            $this->addFlash('success', 'Votre photo de profil a bien été supprimée. Une photo de profil par défaut a été mise en place.');

            // We redirect the user.
            return $this->redirectToRoute(
                'user_profile',
                // We set a array of optional data. 
                [],
                // We specify the related HTTP response status code.
                301
            );
        }
        // Else the submitted token is not valid.
        else {
            // We redirect the user to the page 403.
            return new Response(
                'Action interdite',
                // We specify the related HTTP response status code.
                403
            );
        }
    }

    //! START: user account deactivation
    // /** 
    //  * Method that allow a user to delete is account. 
    //  * @return Response
    //  */
    // #[Route('/demande-supression-compte', name: 'user_delete_request', methods: 'GET', priority: 5)]
    // public function deleteRequest(): Response
    // {
    //     // We display our template. 
    //     return $this->render(
    //         'user/delete-request.html.twig',
    //         // We set a array of optional data.
    //         [],
    //         // We specify the related HTTP response status code.
    //         new Response('', 200)
    //     );
    // }
    //! END: user account deactivation

    /** 
     * Method that deactivate the user. 
     * @param Request $request
     * @return Response
     */
    #[Route('/supprimer-mon-compte', name: 'user_delete', methods: 'GET|POST', priority: 6)]
    public function delete(Request $request): Response
    {
        // We get the logged user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // We get the CSRF token.
        $submittedToken = $request->request->get('token') ?? $request->query->get('token');

        // If the CSRF token is valid. 
        if ($this->isCsrfTokenValid('user-delete' . $user->getId(), $submittedToken)) {

            dd(42);

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

            // For each $adresse in $user->getAddresses().
            foreach ($user->getAddresses() as $address) {
                // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
                $this->entityManagerInterface->remove($address);
            }

            // For each $purchase in $user->getPurchases().
            foreach ($user->getPurchases() as $purchase) {
                // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
                $this->entityManagerInterface->remove($purchase);
            }

            // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
            $this->entityManagerInterface->remove($user);
            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $this->entityManagerInterface->flush();

            // We redirect the user.
            return $this->redirectToRoute(
                'app_logout',
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
}
