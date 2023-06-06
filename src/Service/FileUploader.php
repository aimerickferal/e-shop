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
     * @return string $safeFileName  
     */
    public function uploadFile(Form $form, string $fieldName)
    {
        // We get the file to upload. 
        $uploadedFile = $form->get($fieldName)->getData();

        // We don't have a file to upload. 
        if (!$uploadedFile) {
            // We leave the method. 
            return;
        }

        // The original file Name is the uploaded file name witch is the name that the client give him and his path.
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        // We slugify the original file name. 
        $slugigyFileName = $this->sluggerInterface->slug($originalFileName);

        // We create a safe file name for the uploaded file by concatenating the  slugigy file name of the uploaded file with a unique ID generate by the php function uniqid() https://www.php.net/manual/en/function.uniqid.php and the extension of the uploaded file.
        $safeFileName = $slugigyFileName . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        // We try to move the uploaded file.
        try {
            // We move the file to the upload folder. 
            $uploadedFile->move($this->getUploadFolderPath($form->getName()), $safeFileName);
        }
        // We catch the errors.
        catch (FileException $errors) {
            // TODO START: catch errors on upload

            // TODO END: catch errors on upload
        }
        // We return the name of the uploaded file just in case we need it.
        return $safeFileName;
    }

    /**
     * Method that return the name of the folder where the file is uploaded accordingly to the name of the form. 
     * @param string $formName
     * @return string $uploadFolder  
     */
    public function getUploadFolderPath(string $formName): string
    {
        $uploadFolderPath = null;

        // The value of the upload folder path is set accordingly of the form name.  
        if (
            $formName === 'sign_up_form' ||
            $formName === 'user' ||
            $formName === 'admin_user'
        ) {
            $uploadFolderPath = User::PICTURE_UPLOAD_FOLDER_PATH;
        } else if ($formName === 'admin_product') {
            $uploadFolderPath = Product::PICTURE_UPLOAD_FOLDER_PATH;
        } else if ($formName === 'admin_delivery_mode') {
            $uploadFolderPath = DeliveryMode::PICTURE_UPLOAD_FOLDER_PATH;
        } else if ($formName === 'admin_purchase') {
            $uploadFolderPath = Purchase::BILL_UPLOAD_FOLDER_PATH;
        }

        return $uploadFolderPath;
    }
}
