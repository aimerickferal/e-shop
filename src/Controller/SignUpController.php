<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpFormType;
use App\Security\EmailVerifier;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class SignUpController extends AbstractController
{

    #[Route('/inscription', name: 'app_sign_up')]
    public function signUp(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManagerInterface, FileUploader $fileUploader): Response
    {
        $user = new User();
        $form = $this->createForm(SignUpFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($form->getData());
            // dump($user->getCivilityTitle());
            // dump($user->getFirstName());
            // dump($user->getLastName());
            // dump($user->getEmail());
            // dump($user->getPicture());
            // dd($form->get('plainPassword')->getData());

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // We upload the picture submitted by the user. 
            $picture = $fileUploader->uploadFile($form, 'picture');

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

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('sign-up/sign-up.html.twig', [
            'signUpForm' => $form->createView(),
        ]);
    }
}
