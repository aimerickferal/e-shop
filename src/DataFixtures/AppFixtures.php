<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\DeliveryMode;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use App\Service\PurchaseAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface, private PurchaseAddress $purchaseAddress)
    {
    }

    public function load(ObjectManager $objectManager): void
    {
        // User 

        // We create a empty array for the users. 
        $users = [];

        // We create a new User with a ROLE_ADMIN. 
        $userAdmin = new User();
        // We set the properties of the user. 
        $userAdmin
            ->setRoles(['ROLE_ADMIN'])
            ->setCivilityTitle(User::MAN_CIVILITY_TITLE)
            ->setFirstName('Clark')
            ->setLastName('Kent')
            ->setEmail('clark.kent@email.com')
            ->setPassword($this->userPasswordHasherInterface->hashPassword($userAdmin, '2CBb4cb73201f865638932A41@'))
            ->setPicture(User::MAN_PICTURE);

        // We push the user admin in the array of users.
        $users[] = $userAdmin;

        // We put the data on hold.
        $objectManager->persist($userAdmin);

        // We create a array of users with the data of the users we want to create. 
        $usersToCreate = [
            0 => [
                'Civility Title' => User::WOMAN_CIVILITY_TITLE,
                'First Name' => 'Lana',
                'Last Name' => 'Lang',
                'E-mail' => 'lana.lang@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::WOMAN_PICTURE,
            ],
            1 => [
                'Civility Title' => User::WOMAN_CIVILITY_TITLE,
                'First Name' => 'Chloe',
                'Last Name' => 'Sullivan',
                'E-mail' => 'chloe.sullivan@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::WOMAN_PICTURE,
            ],
            2 => [
                'Civility Title' => User::WOMAN_CIVILITY_TITLE,
                'First Name' => 'Lois',
                'Last Name' => 'Lane',
                'E-mail' => 'lois.lane@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::WOMAN_PICTURE,
            ],
            3 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Pete',
                'Last Name' => 'Ross',
                'E-mail' => 'pete.ross@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            4 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Jonathan',
                'Last Name' => 'Kent',
                'E-mail' => 'jonathan.kent@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            5 => [
                'Civility Title' => User::WOMAN_CIVILITY_TITLE,
                'First Name' => 'Martha',
                'Last Name' => 'Kent',
                'E-mail' => 'martha.kent@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::WOMAN_PICTURE,
            ],
            6 => [
                'Civility Title' => User::WOMAN_CIVILITY_TITLE,
                'First Name' => 'Kara',
                'Last Name' => 'Kent',
                'E-mail' => 'kara.kent@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::WOMAN_PICTURE,
            ],
            7 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Lex',
                'Last Name' => 'Luthor',
                'E-mail' => 'lex.luthor@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            8 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Lionel',
                'Last Name' => 'Luthor',
                'E-mail' => 'lionel.luthor@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            9 => [
                'Civility Title' => User::WOMAN_CIVILITY_TITLE,
                'First Name' => 'Tess',
                'Last Name' => 'Mercer',
                'E-mail' => 'tess.mercer@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::WOMAN_PICTURE,
            ],
            10 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Jimmy',
                'Last Name' => 'Olson',
                'E-mail' => 'jimmy.olson@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            11 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Bart',
                'Last Name' => 'Allen',
                'E-mail' => 'bart.allen@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            12 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Oliver',
                'Last Name' => 'Queen',
                'E-mail' => 'oliver.queen@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            13 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Arthur',
                'Last Name' => 'Curry',
                'E-mail' => 'arthur.curry@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
            14 => [
                'Civility Title' => User::MAN_CIVILITY_TITLE,
                'First Name' => 'Victor',
                'Last Name' => 'Stone',
                'E-mail' => 'victor.stone@email.com',
                'Password' => '2CBb4cb73201f865638932A41@',
                'Picture' => User::MAN_PICTURE,
            ],
        ];

        foreach ($usersToCreate as $userToCreate) {
            // We create a new user. 
            $user = new User();
            $user
                ->setCivilityTitle($userToCreate['Civility Title'])
                ->setFirstName($userToCreate['First Name'])
                ->setLastName($userToCreate['Last Name'])
                ->setEmail(strtolower($userToCreate['First Name']) . '.' . strtolower($userToCreate['Last Name']) . '@email.com')
                ->setPassword($this->userPasswordHasherInterface->hashPassword($user, $userToCreate['Password']))
                ->setPicture($userToCreate['Picture']);

            // We push the user in the array of users.
            $users[] = $user;

            // We put the data on hold.
            $objectManager->persist($user);
        }

        // Address

        // We create differents addresses. 
        $kentFarmAddress = [
            'First Name' => '',
            'Last Name' => '',
            'Street Number' => '710',
            'Street Name' => 'Hickory Lane',
            'Zip Code' => '66605',
            'City' => 'Smallville',
            'Country' => 'Kansas - USA',
            'Phone Number' => '0642424242',
        ];

        $talonAddress = [
            'First Name' => '',
            'Last Name' => '',
            'Street Number' => '710',
            'Street Name' => 'Main Street',
            'Zip Code' => '66605',
            'City' => 'Smallville',
            'Country' => 'Kansas - USA',
            'Phone Number' => '0642424242',
        ];

        $luthorMansionAddress = [
            'First Name' => '',
            'Last Name' => '',
            'Street Number' => '710',
            'Street Name' => 'Mansion Street',
            'Zip Code' => '66605',
            'City' => 'Smallville',
            'Country' => 'Kansas - USA',
            'Phone Number' => '0642424242',
        ];

        $watchtowerAddress = [
            'First Name' => '',
            'Last Name' => '',
            'Street Number' => '710',
            'Street Name' => 'Watchtower Street',
            'Zip Code' => '11105',
            'City' => 'Metropolis',
            'Country' => 'Kansas - USA',
            'Phone Number' => '0642424242',
        ];

        $centralCityAddress = [
            'First Name' => '',
            'Last Name' => '',
            'Street Number' => '710',
            'Street Name' => 'Flash Street',
            'Zip Code' => '22205',
            'City' => 'Central City',
            'Country' => 'Illinois - USA',
            'Phone Number' => '0642424242',
        ];

        $starCityAddress = [
            'First Name' => '',
            'Last Name' => '',
            'Street Number' => '710',
            'Street Name' => 'Green Arrow Street',
            'Zip Code' => '44405',
            'City' => 'Star City',
            'Country' => 'California - USA',
            'Phone Number' => '0642424242',
        ];

        $tempestKeyAddress = [
            'First Name' => '',
            'Last Name' => '',
            'Street Number' => '710',
            'Street Name' => 'Aquaman Street',
            'Zip Code' => '33305',
            'City' => 'Tempest Key',
            'Country' => 'Florida - USA',
            'Phone Number' => '0642424242',
        ];

        // $gatewayCityAddress = [
        //     'First Name' => '',
        //     'Last Name' => '',
        //     'Street Number' => '710',
        //     'Street Name' => 'Wonder Woman Street',
        //     'Zip Code' => '55505',
        //     'City' => 'Gateway City',
        //     'Country' => 'California - USA',
        //     'Phone Number' => '0642424242',
        // ];

        // $gothamCityAddress = [
        //     'First Name' => '',
        //     'Last Name' => '',
        //     'Street Number' => '710',
        //     'Street Name' => 'Batman Street',
        //     'Zip Code' => '77705',
        //     'City' => 'Gotham City',
        //     'Country' => 'Illinois - USA',
        //     'Phone Number' => '0642424242',
        // ];

        // We create a empty array for the addresses. 
        $addresses = [];

        foreach ($users as $user) {
            // If the last name of the user is identical to the given last names. 
            if (
                $user->getLastName() === 'KENT' ||
                $user->getLastName() === 'LANG' ||
                $user->getLastName() === 'SULLIVAN' ||
                $user->getLastName() === 'LANE' ||
                $user->getLastName() === 'ROSS' ||
                $user->getLastName() === 'OLSON' ||
                $user->getLastName() === 'ALLEN' ||
                $user->getLastName() === 'QUEEN' ||
                $user->getLastName() === 'CURRY' ||
                $user->getLastName() === 'STONE'
            ) {
                // We create a new address.
                $address = new Address();
                $address
                    ->setUser($user)
                    ->setFirstName($user->getFirstName())
                    ->setLastName($user->getLastName())
                    ->setStreetNumber($watchtowerAddress['Street Number'])
                    ->setStreetName($watchtowerAddress['Street Name'])
                    ->setZipCode($watchtowerAddress['Zip Code'])
                    ->setCity($watchtowerAddress['City'])
                    ->setCountry($watchtowerAddress['Country'])
                    ->setPhoneNumber($watchtowerAddress['Phone Number']);

                // We push the address in the array of addresses.
                $addresses[] = $address;

                // We put the data on hold.
                $objectManager->persist($address);

                // If the last name of the user is identical to the give last name. 
                if (
                    $user->getLastName() === 'KENT' ||
                    $user->getLastName() === 'LANG' ||
                    $user->getLastName() === 'SULLIVAN' ||
                    $user->getLastName() === 'LANE' ||
                    $user->getLastName() === 'ROSS' ||
                    $user->getLastName() === 'OLSON'
                ) {
                    // We create a new address.
                    $address = new Address();
                    $address
                        ->setUser($user)
                        ->setFirstName($user->getFirstName())
                        ->setLastName($user->getLastName())
                        ->setStreetNumber($talonAddress['Street Number'])
                        ->setStreetName($talonAddress['Street Name'])
                        ->setZipCode($talonAddress['Zip Code'])
                        ->setCity($talonAddress['City'])
                        ->setCountry($talonAddress['Country'])
                        ->setPhoneNumber($talonAddress['Phone Number']);

                    // We push the address in the array of addresses.
                    $addresses[] = $address;

                    // We put the data on hold.
                    $objectManager->persist($address);

                    // If the last name of the user is identical to the give last name. 
                    if (
                        $user->getLastName() === 'KENT' ||
                        $user->getLastName() === 'LANE'
                    ) {
                        // We create a new address.
                        $address = new Address();
                        $address
                            ->setUser($user)
                            ->setFirstName($user->getFirstName())
                            ->setLastName($user->getLastName())
                            ->setStreetNumber($kentFarmAddress['Street Number'])
                            ->setStreetName($kentFarmAddress['Street Name'])
                            ->setZipCode($kentFarmAddress['Zip Code'])
                            ->setCity($kentFarmAddress['City'])
                            ->setCountry($kentFarmAddress['Country'])
                            ->setPhoneNumber($kentFarmAddress['Phone Number']);

                        // We push the address in the array of addresses.
                        $addresses[] = $address;

                        // We put the data on hold.
                        $objectManager->persist($address);
                    }
                }
                // Else if the last name of the user is identical to the given last names. 
                else if (
                    $user->getLastName() === 'ALLEN' ||
                    $user->getLastName() === 'QUEEN' ||
                    $user->getLastName() === 'CURRY' ||
                    $user->getLastName() === 'STONE'
                ) {

                    // If the last name of the user is identical to the give last name. 
                    if ($user->getLastName() === 'ALLEN') {
                        // We create a new address.
                        $address = new Address();
                        $address
                            ->setUser($user)
                            ->setFirstName($user->getFirstName())
                            ->setLastName($user->getLastName())
                            ->setStreetNumber($centralCityAddress['Street Number'])
                            ->setStreetName($centralCityAddress['Street Name'])
                            ->setZipCode($centralCityAddress['Zip Code'])
                            ->setCity($centralCityAddress['City'])
                            ->setCountry($centralCityAddress['Country'])
                            ->setPhoneNumber($centralCityAddress['Phone Number']);

                        // We push the address in the array of addresses.
                        $addresses[] = $address;

                        // We put the data on hold.
                        $objectManager->persist($address);
                    }
                    // Else if the last name of the user is identical to the give last name. 
                    else if ($user->getLastName() === 'QUEEN') {
                        // We create a new address.
                        $address = new Address();
                        $address
                            ->setUser($user)
                            ->setFirstName($user->getFirstName())
                            ->setLastName($user->getLastName())
                            ->setStreetNumber($starCityAddress['Street Number'])
                            ->setStreetName($starCityAddress['Street Name'])
                            ->setZipCode($starCityAddress['Zip Code'])
                            ->setCity($starCityAddress['City'])
                            ->setCountry($starCityAddress['Country'])
                            ->setPhoneNumber($starCityAddress['Phone Number']);

                        // We push the address in the array of addresses.
                        $addresses[] = $address;

                        // We put the data on hold.
                        $objectManager->persist($address);
                    }
                    // Else if the last name of the user is identical to the give last name. 
                    else if ($user->getLastName() === 'CURRY') {
                        // We create a new address.
                        $address = new Address();
                        $address
                            ->setUser($user)
                            ->setFirstName($user->getFirstName())
                            ->setLastName($user->getLastName())
                            ->setStreetNumber($tempestKeyAddress['Street Number'])
                            ->setStreetName($tempestKeyAddress['Street Name'])
                            ->setZipCode($tempestKeyAddress['Zip Code'])
                            ->setCity($tempestKeyAddress['City'])
                            ->setCountry($tempestKeyAddress['Country'])
                            ->setPhoneNumber($tempestKeyAddress['Phone Number']);

                        // We push the address in the array of addresses.
                        $addresses[] = $address;

                        // We put the data on hold.
                        $objectManager->persist($address);
                    }
                }
            }
            // Else if the last name of the user is identical to the give last name. 
            else if (
                $user->getLastName() === 'LUTHOR' ||
                $user->getLastName() === 'MERCER'
            ) {
                // We create a new address.
                $address = new Address();
                $address
                    ->setUser($user)
                    ->setFirstName($user->getFirstName())
                    ->setLastName($user->getLastName())
                    ->setStreetNumber($luthorMansionAddress['Street Number'])
                    ->setStreetName($luthorMansionAddress['Street Name'])
                    ->setZipCode($luthorMansionAddress['Zip Code'])
                    ->setCity($luthorMansionAddress['City'])
                    ->setCountry($luthorMansionAddress['Country'])
                    ->setPhoneNumber($luthorMansionAddress['Phone Number']);

                // We push the address in the array of addresses.
                $addresses[] = $address;

                // We put the data on hold.
                $objectManager->persist($address);
            }
        }

        // Category & Product

        // We create a array of categories with the data of the categories we want to create. 
        $categoriesToCreate = [
            0 => [
                'Name' => 'T-Shirt',
                'Slug' => 't-shirt',
            ],
            1 => [
                'Name' => 'Sweat',
                'Slug' => 'sweat',
            ],
            2 => [
                'Name' => 'Jean',
                'Slug' => 'jean',
            ],
            3 => [
                'Name' => 'Jogging',
                'Slug' => 'jogging',
            ],
            4 => [
                'Name' => 'Jean Short',
                'Slug' => 'jean-short',
            ],
            5 => [
                'Name' => 'Jogging Short',
                'Slug' => 'joggin-short',
            ],
            6 => [
                'Name' => 'Sneaker',
                'Slug' => 'sneaker',
            ],
            7 => [
                'Name' => 'Shoe',
                'Slug' => 'shoe',
            ],
        ];

        // We create a array of t-shirts with the data of the t-shirts we want to create. 
        $tShirts = [
            0 => [
                'Name' => 'T-Shirt Noir',
                'Slug' => 't-shirt-noir',
                // 'Name' => 'Black T-Shirt',
                // 'Slug' => 'black-t-shirt',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            1 => [
                'Name' => 'T-Shirt Blanc',
                'Slug' => 't-shirt-blanc',
                // 'Name' => 'White T-Shirt',
                // 'Slug' => 'white-t-shirt',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'T-Shirt Gris',
                'Slug' => 't-shirt-gris',
                // 'Name' => 'Grey T-Shirt',
                // 'Slug' => 'grey-t-shirt',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'T-Shirt Rouge',
                'Slug' => 't-shirt-rouge',
                // 'Name' => 'Red T-Shirt',
                // 'Slug' => 'red-t-shirt',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'T-Shirt Bleu',
                'Slug' => 't-shirt-bleu',
                // 'Name' => 'Blue T-Shirt',
                // 'Slug' => 'blue-t-shirt',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'T-Shirt Orange',
                'Slug' => 't-shirt-range',
                // 'Name' => 'Orange T-Shirt',
                // 'Slug' => 'orange-t-shirt',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            6 => [
                'Name' => 'T-Shirt Violet',
                'Slug' => 't-shirt-violet',
                // 'Name' => 'Purple T-Shirt',
                // 'Slug' => 'purple-t-shirt',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a array of sweats with the data of the sweats we want to create. 
        $sweats = [
            0 => [
                'Name' => 'Sweat Noir',
                'Slug' => 'sweat-noir',
                // 'Name' => 'Black Sweat',
                // 'Slug' => 'black-sweat',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            1 => [
                'Name' => 'Sweat Blanc',
                'Slug' => 'sweat-blanc',
                // 'Name' => 'White Sweat',
                // 'Slug' => 'white-sweat',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'Sweat Gris',
                'Slug' => 'sweat-gris',
                // 'Name' => 'Grey Sweat',
                // 'Slug' => 'grey-sweat',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'Sweat Rouge',
                'Slug' => 'sweat-rouge',
                // 'Name' => 'Red Sweat',
                // 'Slug' => 'red-sweat',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'Blue Sweat',
                'Slug' => 'blue-sweat-bleu',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'Sweat Orange',
                'Slug' => 'sweat-orange',
                // 'Name' => 'Orange Sweat',
                // 'Slug' => 'orange-sweat',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            6 => [
                'Name' => 'Sweat Violet',
                'Slug' => 'sweat-violet',
                // 'Name' => 'Purple Sweat',
                // 'Slug' => 'purple-sweat',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a array of jeans with the data of the jeans we want to create. 
        $jeans = [
            0 => [
                'Name' => 'Jean Noir',
                'Slug' => 'jean-noir',
                // 'Name' => 'Black Jean',
                // 'Slug' => 'black-jean',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '14999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            1 => [
                'Name' => 'Jean Blanc',
                'Slug' => 'jean-blanc',
                // 'Name' => 'White Jean',
                // 'Slug' => 'white-jean',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '14999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'Jean Gris',
                'Slug' => 'jean-gris',
                // 'Name' => 'Grey Jean',
                // 'Slug' => 'grey-jean',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '14999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'Jean Rouge',
                'Slug' => 'jean-rouge',
                // 'Name' => 'Red Jean',
                // 'Slug' => 'red-jean',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '14999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'Jean Bleu',
                'Slug' => 'jean-bleu',
                // 'Name' => 'Blue Jean',
                // 'Slug' => 'blue-jean',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '14999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'Jean Orange',
                'Slug' => 'jean-orange',
                // 'Name' => 'Orange Jean',
                // 'Slug' => 'oange-jean',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '14999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            6 => [
                'Name' => 'Jean Violet',
                'Slug' => 'jean-violet',
                // 'Name' => 'Purple Jean',
                // 'Slug' => 'purple-jean',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '14999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a array of joggings with the data of the joggings we want to create. 
        $joggings = [
            0 => [
                'Name' => 'Jogging Noir',
                'Slug' => 'jogging-noir',
                // 'Name' => 'Black Jogging',
                // 'Slug' => 'black-jogging',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '4999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            1 => [
                'Name' => 'Jogging Blanc',
                'Slug' => 'jogging-blanc',
                // 'Name' => 'White Jogging',
                // 'Slug' => 'white-jogging',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '4999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'Jogging Gris',
                'Slug' => 'jogging-gris',
                // 'Name' => 'Grey Jogging',
                // 'Slug' => 'grey-jogging',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '4999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'Jogging Rouge',
                'Slug' => 'jogging-Rouge',
                // 'Name' => 'Red Jogging',
                // 'Slug' => 'red-jogging',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '4999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'Jogging Bleu',
                'Slug' => 'jogging-bleu',
                // 'Name' => 'Blue Jogging',
                // 'Slug' => 'blue-jogging',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '4999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'Jogging Orange',
                'Slug' => 'jogging-orange',
                // 'Name' => 'orange-Jogging',
                // 'Slug' => 'orange-jogging',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '4999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            6 => [
                'Name' => 'Jogging Violet',
                'Slug' => 'jogging-violet',
                // 'Name' => 'Purple Jogging',
                // 'Slug' => 'purple-jogging',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '4999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a array of shorts in jean with the data of the shorts in jean we want to create. 
        $shortsInJean = [
            0 => [
                'Name' => 'Short En Jean Noir',
                'Slug' => 'short-en-jean-noir',
                // 'Name' => 'Black Jean Short',
                // 'Slug' => 'black-jean-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '7999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            1 => [
                'Name' => 'Short En Jean Blanc',
                'Slug' => 'short-en-jean-blanc',
                // 'Name' => 'White Jean Short',
                // 'Slug' => 'white-jean-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '7999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'Short En Jean Gris',
                'Slug' => 'short-en-jean-gris',
                // 'Name' => 'Grey Jean Short',
                // 'Slug' => 'grey-jean-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '7999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'Short En Jean Rouge',
                'Slug' => 'short-en-jean-rouge',
                // 'Name' => 'Red Jean Short',
                // 'Slug' => 'red-jean-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '7999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'Short En Jean Bleu',
                'Slug' => 'short-en-jean-bleu',
                // 'Name' => 'Blue Jean Short',
                // 'Slug' => 'blue-jean-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '7999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'Short En Jean Orange',
                'Slug' => 'short-en-jean-orange',
                // 'Name' => 'Orange Jean Short',
                // 'Slug' => 'orange-jean-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '7999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            6 => [
                'Name' => 'Short En Jean Violet',
                'Slug' => 'short-en-jean-violet',
                // 'Name' => 'Purple Jean Short',
                // 'Slug' => 'purple-jean-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '7999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a array of shorts in jogging with the data of the shorts in jogging we want to create. 
        $shortsInJogging = [
            0 => [
                'Name' => 'Short En Jogging Noir',
                'Slug' => 'short-en-jogging-noir',
                // 'Name' => 'Black Joggin Short',
                // 'Slug' => 'black-jogging-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '2499',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            1 => [
                'Name' => 'Short En Jogging Blanc',
                'Slug' => 'short-en-jogging-blanc',
                // 'Name' => 'White Joggin Short',
                // 'Slug' => 'white-jogging-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '2499',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'Short En Jogging Gris',
                'Slug' => 'short-en-jogging-gris',
                // 'Name' => 'Grey Joggin Short',
                // 'Slug' => 'grey-jogging-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '2499',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'Short En Jogging Rouge',
                'Slug' => 'short-en-jogging-rouge',
                // 'Name' => 'Red Joggin Short',
                // 'Slug' => 'red-jogging-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '2499',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'Short En Jogging Bleu',
                'Slug' => 'short-en-jogging-bleu',
                // 'Name' => 'Blue Joggin Shortu',
                // 'Slug' => 'blue-jogging-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '2499',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'Short En Jogging Orange',
                'Slug' => 'short-en-jogging-orange',
                // 'Name' => 'Orange Joggin Short',
                // 'Slug' => 'orange-jogging-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '2499',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            6 => [
                'Name' => 'Short En Jogging Violet',
                'Slug' => 'short-en-jogging-violet',
                // 'Name' => 'Purple Joggin Short',
                // 'Slug' => 'purple-jogging-short',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '2499',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a array of baskets with the data of the baskets want to create. 
        $baskets = [
            0 => [
                'Name' => 'Basket Noir',
                'Slug' => 'basket-noir',
                // 'Name' => 'Black Sneakers',
                // 'Slug' => 'black-sneakers',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            1 => [
                'Name' => 'Basket Blanche',
                'Slug' => 'basket-blanche',
                // 'Name' => 'White Sneakers',
                // 'Slug' => 'white-sneakers',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'Basket Grise',
                'Slug' => 'basket-grise',
                // 'Name' => 'Grey Sneakers',
                // 'Slug' => 'grey-sneakers',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'Basket Rouge',
                'Slug' => 'basket-rouge',
                // 'Name' => 'Red Sneakers',
                // 'Slug' => 'red-sneakers',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'Basket Bleu',
                'Slug' => 'basket-bleu',
                // 'Name' => 'Blue Sneakers',
                // 'Slug' => 'blue-sneakers',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'Basket Orange',
                'Slug' => 'basket-orange',
                // 'Name' => 'Orange Sneakers',
                // 'Slug' => 'orange-sneakers',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE

            ],
            6 => [
                'Name' => 'Basket Violette',
                'Slug' => 'basket-violette',
                // 'Name' => 'Purple Sneakers',
                // 'Slug' => 'purple-sneakers',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a array of shoess with the data of the shoess want to create. 
        $shoess = [
            1 => [
                'Name' => 'Chaussure Noir',
                'Slug' => 'chaussure-noir',
                // 'Name' => 'Black Shoes',
                // 'Slug' => 'black-shoes',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            2 => [
                'Name' => 'Chaussure Blanche',
                'Slug' => 'chaussure-blanche',
                // 'Name' => 'White Shoes',
                // 'Slug' => 'white-shoes',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            3 => [
                'Name' => 'Chaussure Grise',
                'Slug' => 'chaussure-grise',
                // 'Name' => 'Grey Shoes',
                // 'Slug' => 'grey-shoes',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            22 => [
                'Name' => 'Chaussure Rouge',
                'Slug' => 'chaussure-rouge',
                // 'Name' => 'Red Shoes',
                // 'Slug' => 'red-shoes',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            4 => [
                'Name' => 'Chaussure Bleu',
                'Slug' => 'chaussure-bleu',
                // 'Name' => 'Blue Shoes',
                // 'Slug' => 'blue-shoes',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            5 => [
                'Name' => 'Chaussure Orange',
                'Slug' => 'chaussure-orange',
                // 'Name' => 'Orange Shoes',
                // 'Slug' => 'orange-shoes',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::AVAILABLE
            ],
            6 => [
                'Name' => 'Chaussure Violette',
                'Slug' => 'chaussure-violette',
                // 'Name' => 'Purple Shoes',
                // 'Slug' => 'purple-shoes',
                'Reference' => '',
                'Picture' => Product::PICTURE_BY_DEFAULT,
                'Price' => '9999',
                'Description' => 'Lorem ipsum dolor sit amet. Et provident consequuntur id cumque omnis 33 incidunt cumque. Sed fugiat nihil ut possimus asperiores 33 quos suscipit sed corrupti voluptate.',
                'Availability' => Product::UNAVAILABLE
            ]
        ];

        // We create a empty array for the categories. 
        $categories = [];

        // We create a empty array for the products. 
        $products = [];

        foreach ($categoriesToCreate as $categorieToCreate) {
            // we create a new category.
            $category = new Category();
            $category
                ->setName($categorieToCreate['Name'])
                ->setSlug($categorieToCreate['Slug']);

            // We push each category in the array of categories.
            $categories[] = $category;

            // We put the data on hold.
            $objectManager->persist($category);
        }

        foreach ($categories as $category) {
            // If the name of the category is identical to the name of the first categoriesToCreate. 
            if (
                $category->getName() ===
                $categoriesToCreate[0]['Name']
            ) {
                // For each tShirt in tShirts.
                foreach ($tShirts as $tShirt) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($tShirt['Name'])
                        ->setSlug($tShirt['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $tShirt['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($tShirt['Picture'])
                        ->setPrice($tShirt['Price'])
                        ->setDescription($tShirt['Description'])
                        ->setAvailability($tShirt['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
            // Else if the name of the category is identical to the name of the second categoriesToCreate. 
            else if (
                $category->getName() ===
                $categoriesToCreate[1]['Name']
            ) {
                // For each sweat in sweats.
                foreach ($sweats as $sweat) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($sweat['Name'])
                        ->setSlug($sweat['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $sweat['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($sweat['Picture'])
                        ->setPrice($sweat['Price'])
                        ->setDescription($sweat['Description'])
                        ->setAvailability($sweat['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
            // Else if the name of the category is identical to the name of the third categoriesToCreate. 
            else if (
                $category->getName() ===
                $categoriesToCreate[2]['Name']
            ) {
                // For each jean in jeans.
                foreach ($jeans as $jean) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($jean['Name'])
                        ->setSlug($jean['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $jean['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($jean['Picture'])
                        ->setPrice($jean['Price'])
                        ->setDescription($jean['Description'])
                        ->setAvailability($jean['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
            // Else if the name of the category is identical to the name of the foutrh categoriesToCreate. 
            else if (
                $category->getName() ===
                $categoriesToCreate[3]['Name']
            ) {
                // For each jogging in joggings.
                foreach ($joggings as $jogging) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($jogging['Name'])
                        ->setSlug($jogging['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $jogging['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($jogging['Picture'])
                        ->setPrice($jogging['Price'])
                        ->setDescription($jogging['Description'])
                        ->setAvailability($jogging['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
            // Else if the name of the category is identical to the name of the fifth categoriesToCreate. 
            else if (
                $category->getName() ===
                $categoriesToCreate[4]['Name']
            ) {
                // For each shortInJean in shortsInJean.
                foreach ($shortsInJean as $shortInJean) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($shortInJean['Name'])
                        ->setSlug($shortInJean['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $shortInJean['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($shortInJean['Picture'])
                        ->setPrice($shortInJean['Price'])
                        ->setDescription($shortInJean['Description'])
                        ->setAvailability($shortInJean['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
            // Else if the name of the category is identical to the name of the sixth categoriesToCreate. 
            else if (
                $category->getName() ===
                $categoriesToCreate[5]['Name']
            ) {
                // For each shortInJogging in shortsInJogging.
                foreach ($shortsInJogging as $shortInJogging) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($shortInJogging['Name'])
                        ->setSlug($shortInJogging['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $shortInJogging['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($shortInJogging['Picture'])
                        ->setPrice($shortInJogging['Price'])
                        ->setDescription($shortInJogging['Description'])
                        ->setAvailability($shortInJogging['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
            // Else if the name of the category is identical to the name of the seventh categoriesToCreate. 
            else if (
                $category->getName() ===
                $categoriesToCreate[6]['Name']
            ) {
                // For each basket in baskets.
                foreach ($baskets as $basket) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($basket['Name'])
                        ->setSlug($basket['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $basket['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($basket['Picture'])
                        ->setPrice($basket['Price'])
                        ->setDescription($basket['Description'])
                        ->setAvailability($basket['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
            // Else if the name of the category is identical to the name of the eighth categoriesToCreate. 
            else if (
                $category->getName() ===
                $categoriesToCreate[7]['Name']
            ) {
                // For each shoes in shoess.
                foreach ($shoess as $shoes) {
                    // We create a new product.
                    $product = new Product();
                    $product
                        ->setName($shoes['Name'])
                        ->setSlug($shoes['Slug'])
                        ->setReference(strtoupper(substr(
                            str_replace(' ', '', $shoes['Name']),
                            0,
                            4
                        ) . bin2hex(random_bytes(4))))
                        ->setPicture($shoes['Picture'])
                        ->setPrice($shoes['Price'])
                        ->setDescription($shoes['Description'])
                        ->setAvailability($shoes['Availability'])
                        ->setCategory($category);

                    // We push the product in the array of products.
                    $products[] = $product;

                    // We put the data on hold.
                    $objectManager->persist($product);
                }
            }
        }

        // DeliveryModes

        // We create a array of delivery modes with the data of the delivery modes we want to create. 
        $deliveryModesToCreate = [
            0 => [
                'Name' => 'Livraison à Domicile',
                'Description' => 'En 48 à 72h ouvrées. Offert dès 99 €.',
                // 'Name' => 'Home delivery',
                // 'Description' => 'In 48 to 72 working hours. Free from 99 €.',
                'Price' => 599,
                'Min Cart Amount For Free Delivery' => 9900,
                'Picture' => DeliveryMode::PICTURE_BY_DEFAULT,
            ],
            1 => [
                'Name' => 'Livraison Express à Domicile',
                'Description' => 'Avec signature. En 24 à 48h. Offert dès 139 €.',
                // 'Name' => 'Express home delivery',
                // 'Description' => 'With signature. In 24 to 48 hours. Free from 139 €.',
                'Price' => 999,
                'Min Cart Amount For Free Delivery' => 13900,
                'Picture' => DeliveryMode::PICTURE_BY_DEFAULT,
            ],
        ];

        // We create a empty array for the delivery modes. 
        $deliveryModes = [];

        foreach ($deliveryModesToCreate as $deliveryModeToCreate) {
            // We create a new delivery mode. 
            $deliveryMode = new DeliveryMode();
            $deliveryMode
                ->setName($deliveryModeToCreate['Name'])
                ->setDescription($deliveryModeToCreate['Description'])
                ->setPrice($deliveryModeToCreate['Price'])
                ->setMinCartAmountForFreeDelivery($deliveryModeToCreate['Min Cart Amount For Free Delivery'])
                ->setPicture($deliveryModeToCreate['Picture']);

            // We push the delivery mode in the array of delivery modes.
            $deliveryModes[] = $deliveryMode;

            // We put the data on hold.
            $objectManager->persist($deliveryMode);
        }

        // Purchase

        // dd($addresses);

        // We create a empty array for the purchases. 
        $purchases = [];

        foreach ($users as $user) {
            // We start a counter at 0 and we run some code untill he reach 50.
            for ($count = 0; $count < 2; $count++) {
                // We create a new purchase. 
                $purchase = new Purchase();
                $purchase
                    ->setUser($user)
                    ->setReference(strtolower(bin2hex(random_bytes(6))))
                    ->setSubtotal(mt_rand(2000, 6000))
                    ->setBillingAddress($this->purchaseAddress->insertBreakLineCharactersInAddressForFixtures($addresses[0]))
                    ->setDeliveryAddress($this->purchaseAddress->insertBreakLineCharactersInAddressForFixtures($addresses[1] ?? $addresses[0]))
                    ->setDeliveryMode($deliveryModes[0])
                    ->setDeliveryModePrice(999)
                    ->setTotal($purchase->getSubtotal() + $purchase->getDeliveryModePrice())
                    ->setCheckoutMethod(Purchase::CHECKOUT_METHOD_CARD_WITH_STRIPE)
                    ->setStatus(Purchase::STATUS_PAID)
                    ->setBill(Purchase::BILL_BY_DEFAULT);

                $purchases[] = $purchase;

                // We put the data on hold.
                $objectManager->persist($purchase);

                // PurchaseItem

                // We create a empty array for the purchased products. 
                $purchasedProducts = [];

                foreach ($products as $product) {
                    // We create a new PurchaseItem.
                    $purchaseItem = new PurchaseItem();
                    $purchaseItem
                        ->setPurchase($purchase)
                        ->setProduct($product)
                        ->setProductName($product->getName())
                        ->setProductReference($product->getReference())
                        ->setProductPrice($product->getPrice())
                        ->setQuantity((2))
                        ->setTotal($purchaseItem->getProductPrice() * $purchaseItem->getQuantity());

                    // We push the product in the array of purchased products.
                    $purchasedProducts[] = $product;

                    // If the number of elements in the array of purchased products is superior to 6.
                    if (count($purchasedProducts) > 6) {
                        // We stop. 
                        break;
                    }

                    // We put the data on hold.
                    $objectManager->persist($purchaseItem);
                }
            }
        }

        // We backup the data in the database.
        $objectManager->flush();
    }
}
