<?php

namespace App\Service;

use App\Entity\DeliveryMode;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\User;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;


class FileUploader
{
    public function __construct(private SluggerInterface $sluggerInterface)
    {
    }

    /**
     * Method that upload a file picture. 
     * @param Form $form
     * @param string $fieldName
     * @param string $uploadedFolder
     * @return string $safeFileName  
     */
    public function uploadFile(Form $form, string $fieldName, string $uploadFolder = null)
    {
        // We get the file to upload. 
        $uploadedFile = $form->get($fieldName)->getData();

        // If we don't have a file. 
        if (!$uploadedFile) {
            // We leave the method. 
            return;
        }

        // dd($form->getName());

        // If the name of the form is strictly equal to at least one of the compared forms. 
        if (
            $form->getName() === 'sign_up_form' ||
            $form->getName() === 'user' ||
            $form->getName() === 'admin_user'
        ) {
            // // The value of $uploadeFolder is the value of the .env variable PICTURE_UPLOAD_FOLDER_PATH.
            // $uploadFolder = $_ENV['PICTURE_UPLOAD_FOLDER_PATH'];

            // The value of $uploadeFolder is the value of the PHP constant User::PICTURE_UPLOAD_FOLDER_PATH. 
            $uploadFolder = User::PICTURE_UPLOAD_FOLDER_PATH;
        }
        // Else if the name of the form is strictly equal to "admin_product".
        else if ($form->getName() === 'admin_product') {
            // The value of $uploadeFolder is the value of the PHP constant Product::PICTURE_UPLOAD_FOLDER_PATH.  
            $uploadFolder = Product::PICTURE_UPLOAD_FOLDER_PATH;
        }
        // Else if the name of the form is strictly equal to "admin_delivery_mode".
        else if ($form->getName() === 'admin_delivery_mode') {
            // The value of $uploadeFolder is the value of the PHP constant DeliveryMode::PICTURE_UPLOAD_FOLDER_PATH.  
            $uploadFolder = DeliveryMode::PICTURE_UPLOAD_FOLDER_PATH;
        }
        // Else if the name of the form is strictly equal to "admin_purchase".
        else if ($form->getName() === 'admin_purchase') {
            // The value of $uploadeFolder is the value of the PHP constant Purchase::BILL_UPLOAD_FOLDER_PATH.  
            $uploadFolder = Purchase::BILL_UPLOAD_FOLDER_PATH;
        }

        // The $originalFileName is the $uploadedFile name witch is the name that the client give him and his path.
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        // We slugify the $originalFileName. 
        $slugigyFileName = $this->sluggerInterface->slug($originalFileName);

        // We create a $safeFileName for the $uploadedFile by concatenating the  $slugigyFileName of the $uploadedFile with a unique ID generate by the php function uniqid() https://www.php.net/manual/en/function.uniqid.php and the extension of the $uploadedFile.
        $safeFileName = $slugigyFileName . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        // We try to move the uploaded file.
        try {
            // We move the file to the uploads folder. 
            $uploadedFile->move($uploadFolder, $safeFileName);
        }
        // We catch the errors.
        catch (FileException $errors) {
            // TODO #4 START : handle catch $errors in the uploadFile() method of FileUploader service.



            // TODO #4 END : handle catch $errors in the uploadFile() method of FileUploader service.
        }
        // We return the name of the uploaded file just in case we need it.
        return $safeFileName;
    }
}
