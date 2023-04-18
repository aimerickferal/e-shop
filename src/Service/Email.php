<?php

namespace App\Service;

use App\Entity\Purchase;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Email
{

    public function __construct(protected MailerInterface $mailerInterface, protected PurchaseAddress $purchaseAddress)
    {
    }

    /**
     * Method that create a email template with some receive data and send the email.
     * @param array $data 
     * @return void 
     */
    public function sendEmailFromUser(array $data): void
    {
        // We create the email. 
        $email = new TemplatedEmail();

        // We set our data to the email.
        $email
            ->from($data['email'])
            ->to(new Address('feralaimerick@gmail.com', 'Aimerick FERAL'))
            ->subject($data['subject'])
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'civilityTitle' => $data['civilityTitle'],
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'userEmail' => $data['email'],
                'phoneNumber' => $data['phoneNumber'],
                'message' => $data['message'],
            ]);

        // We send the email.
        $this->mailerInterface->send($email);
    }

    /**
     * Method that send a email to a user to confirm is purchase and show him a recap of is purchase. 
     * @param User $user
     * @param Purchase $purchase
     * @param array $purchaseItems
     * @return void 
     */
    public function confimPurchaseToUser(User $user, Purchase $purchase, array $purchaseItems)
    {
        // We create the email. 
        $email = new TemplatedEmail();

        // We set our data to the email.
        $email
            ->from('noreply@e-shop.fr')
            ->to(new Address($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName()))
            ->subject('Purchase ' . $purchase->getReference())
            ->htmlTemplate('emails/purchase/confirmation.html.twig')
            ->context([
                'user' => $user,
                'purchase' => $purchase,
                'billingAddress' => $this->purchaseAddress->showAddress($purchase->getBillingAddress()),
                'deliveryAddress' => $this->purchaseAddress->showAddress($purchase->getDeliveryAddress()),
                'purchaseItems' => $purchaseItems
            ]);

        // We send the email.
        $this->mailerInterface->send($email);
    }

    // /**
    //  * Method that send a email to a user to inform of the deletion of is account.
    //  * @return void 
    //  */
    // public function informUserOfAccountDeletion(User $user)
    // {
    //     // We create the email. 
    //     $email = new TemplatedEmail();

    //     // We set our data to the email.
    //     $email
    //         ->from('noreply@e-shop.fr')
    //         ->to(new Address($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName()))
    //         ->subject('Suppression de votre compte')
    //         ->htmlTemplate('emails/user/delete.html.twig')
    //         ->context([
    //             'user' => $user,
    //         ]);

    //     // We send the email.
    //     $this->mailerInterface->send($email);
    // }
}
