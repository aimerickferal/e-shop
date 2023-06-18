# **Documentation**

## **Setup**

- HTML 5
- CSS 3
- JavaScript ECMAScript 2020
- PHP 8
- Symfony 6
- MariaDB Version 15.1 Distribution 10.11.2

## **Setup**

- HTML 5
- CSS 3
- JavaScript ECMAScript 2020
- PHP 8
- Symfony 6
- MariaDB Version 15.1 Distribution 10.11.2

To use the projet follows these steps:

- Git clone the `dev` branch of the repository
- Set Up your `.env.local` file with the help on the informations located in the `.env` file
- Run the command `php bin/console doctrine:database:create`
- Run the command `php bin/console make:migration`
- Run the command `php bin/console doctrine:migrations:migrate` or `php bin/console doctrine:schema:update --force`
- Run the command `php bin/console doctrine:fixtures:load`
- Run the command `php -S localhost:8080 -t public`
- Open you browser and go the URL `http://localhost:8080/`

## **Database**

### **User**

- id
- email
- roles
- password
- firtName
- lastName
- civilityTitle
- picture
- addresses | OneToMany
- purchases | OneToMany
- createdAt
- updatesAt

| id  | email                | roles          | password                                  | first_name | last_name | civility_title | picture  | created_at          | updated_at          |
| --- | -------------------- | -------------- | ----------------------------------------- | ---------- | --------- | -------------- | -------- | ------------------- | ------------------- |
| 1   | clark.kent@email.com | ["ROLE_ADMIN"] | $2y$13$jbioeyqTvwNuJLvClhWeh.n2qBXADEO4rb | Clark      | KENT      | Monsieur       | user.svg | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

Relation between **User** & **Purchase** :

- A **User** is related to how many **Purchase** at least ? -> 0
- A **User** est lié à comnbien de **Purchase** at most ? -> N

Relation between **User** & **Address** :

- A **User** est lié à combien d' **Address** at least ? -> 0
- A **User** est lié à combien d' **Address** at least ? -> N

### **Product**

- id
- name
- slug
- reference
- picture
- price
- description
- category | Many To One, allowed to be null : no, but you say yes
- createdAt
- updatedAt

| id  | name         | slug         | reference  | picture     | price | description | category      | created_at          | updated_at          |
| --- | ------------ | ------------ | ---------- | ----------- | ----- | ----------- | ------------- | ------------------- | ------------------- |
| 1   | Product Name | product-name | XJIJEJPO12 | product.png | 9999  | Lorem...    | Category Name | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

Relation between **Product** & **Category** :

- A **Product** is related to how many **Category** at least ? -> 1
- A **Product** is related to how many **Category** at most ? -> 1

Relation between **Product** & **PurchaseItem** :

- A **Product** is related to how many **PurchaseItem** at least ? - > 0
- A **Product** is related to how many **PurchaseItem** at most ? - > N

### **Category**

- id
- name
- slug
- produts | OneToMany
- createdAt
- updatedAt

| id  | name         | slug         | created_at          | updated_at          |
| --- | ------------ | ------------ | ------------------- | ------------------- |
| 1   | Product Name | product-name | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

Relation between **Category** & **Product** :

- A **Category** is related to how many **Product** at least ? -> 0
- A **Category** is related to how many **Product** at most ? -> N

### **Address**

- id
- firstName
- lastName
- streetNumber
- streetName
- zipCode
- city
- country
- phoneNumber
- user | ManyToOne, allowed to be null : no
- createdAt
- updatedAt

| id  | first_name | last_mame | street_number | street_name  | zip_code | city       | country      | phone_number | user_id | created_at          | updated_at          |
| --- | ---------- | --------- | ------------- | ------------ | -------- | ---------- | ------------ | ------------ | ------- | ------------------- | ------------------- |
| 1   | Clark      | KENT      | 42            | Hickory Lane | 66605    | Smallville | Kansas - USA | 0642424242   | 1       | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

Relations entre **Address** & **User** :

- A **Address** is related to how many **User** at least ? -> 1
- A **Address** is related to how many **User** at most ? -> 1

### **Purchase**

- id
- reference
- billingAddress
- deliveryAddress
- subtotal
- deliveryMode
- deliveryModePrice
- total
- checkoutMethod
- stripeSessionId
- status
- bill
- user | ManyToOne, allowed to be null : yes
- purchaseItems | OneToMan, allowed to be null : no
- purchaseAt
- updatedAt

| id  | reference    | billing_address                                                       | delivery_address                                                               | subtotal | delivery_mode      | delivery_mode_price | total | checkout_method             | stripe_session_id                                                  | status | bill     | user_id | purchased_at        | updated_at          |
| --- | ------------ | --------------------------------------------------------------------- | ------------------------------------------------------------------------------ | -------- | ------------------ | ------------------- | ----- | --------------------------- | ------------------------------------------------------------------ | ------ | -------- | ------- | ------------------- | ------------------- |
| 1   | 3153c8b2b80a | Clark KENT 42 Hickory Lane 66605 - Smallville Kansas - USA 0642424242 | Clark KENT 42 Justice League street 88805 - Metropolis Kansas - USA 0642424242 | 999      | Delivery Mode Name | 999                 | 999   | Paiement par Carte Bancaire | cs_test_a1macXCsNtn1ZPG0uMhM9D06xHtviFRkhm97Pneoa1mhd0W5OjwItyQhvk | Payée  | bill.pdf | 1       | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

Relations entre **Purchase** & **User** :

- A **Purchase** is related to how many **User** at least ? -> 1
- A **Purchase** is related to how many **User** at most ? -> 1

Relation between **Purchase** & **PurchaseItem** :

- A **Purchase** is related to how many **PurchaseItem** at least -> 1 ;
- A **Purchase** is related to how many **PurchaseItem** at most -> N ;

### **PurchaseItem**

- id
- productName
- productreference
- productPrice
- quantity
- total
- product | ManyToOne, allowed to be null : yes
- purchase | ManyToOne, allowed to be null : no

| id  | product_name | product_reference | product_price | quantity | total | product_id | pruchase_id |
| --- | ------------ | ----------------- | ------------- | -------- | ----- | ---------- | ----------- |
| 1   | Product Name | XJIJEJPO12        | 999           | 2        | 999   | 1          | 1           |

Relation between **PurchaseItem** & **Product** :

- A **PurchaseItem** is related to how many **Product** at least ? -> 1
- A **PurchaseItem** is related to how many **Product** at most ? -> N

Relation between **PurchaseItem** & **Purchase** :

- A **PurchaseItem** is related to how many **Purchase** at least -> 1
- A **PurchaseItem** is related to how many **Purchase** at most -> 1

### **DeliveryMode**

- id
- name
- description
- price
- min_cart_amount_for_free_delivery
- picture
- createdAt
- updatedAt

| id  | name               | description | price | min_cart_amount_for_free_delivery | picture           | created_at          | updated_at          |
| --- | ------------------ | ----------- | ----- | --------------------------------- | ----------------- | ------------------- | ------------------- |
| 1   | Delivery Mode Name | Lorem...    | 999   | 999                               | home-delivery.png | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

## **Routes**

| URL                                                               | Route Name                    | Methods HTTP | Controller                  | Method Name                  | Status |
| ----------------------------------------------------------------- | ----------------------------- | ------------ | --------------------------- | ---------------------------- | ------ |
| /                                                                 | home                          | GET          | MainController              | home()                       | ✅     |
| /contact                                                          | contact                       | GET , POST   | MainController              | contact()                    | ✅     |
| /a-propos                                                         | about                         | GET          | MainController              | about()                      | ✅     |
| /mentions-legales                                                 | legal_notices                 | GET          | MainController              | legalMentions()              | ✅     |
| /conditions-generales-d-utilisation                               | terms_of_services             | GET          | MainController              | termsOfServices()            | ✅     |
| /conditions-generales-de-ventes                                   | general_terms_of_sale         | GET          | MainController              | termsOfSales()               | ✅     |
| /livraison-et-service-apres-vente                                 | delivery_and_customer_service | GET          | MainController              | deliveryAndCustomerService() | ✅     |
| /paiement-securise                                                | secure_payment                | GET          | MainController              | securePayment()              | ✅     |
| /inscription                                                      | app_sign_up                   | GET, POST    | SignUpController            | signUp()                     | ✅     |
| /connexion                                                        | app_login                     | GET, POST    | SecurityController          | login()                      | ✅     |
| /deconnexion                                                      | app_logout                    | GET, POST    | SecurityController          | logout()                     | ✅     |
| /profil                                                           | user_profile                  | GET, POST    | UserController              | profile()                    | ✅     |
| /supprimer-photo                                                  | user_delete_picture           | GET, POST    | UserController              | deletePicture()              | ✅     |
| /supprimer-mon-compte                                             | user_delete_my-account        | GET, POST    | UserController              | delete()                     | ❌     |
| /reinitialisation-mot-de-passe/demande                            | app_forgot_password_request   | GET, POST    | ResetPasswordController     | request()                    | ❌     |
| /reinitialisation-mot-de-passe/verification-e-mail                | app_check_email               | GET          | ResetPasswordController     | checkEmail()                 | ❌     |
| /reinitialisation-mot-de-passe/reinitialisation/{token}           | app_reset_password            | GET          | ResetPasswordController     | reset()                      | ❌     |
| /admin                                                            | admin_dashboard               | GET          | AdminMainController         | dashboard()                  | ✅     |
| /admin/utilisateurs/creer                                         | admin_user_create             | GET, POST    | AdminUserController         | create()                     | ✅     |
| /admin/utilisateurs                                               | admin_user_list               | GET          | AdminUserController         | list()                       | ✅     |
| /admin/utilisateurs/administrateurs                               | admin_user_admin_list         | GET          | AdminUserController         | adminList()                  | ✅     |
| /admin/utilisateurs/{id}                                          | admin_user_detail             | GET          | AdminUserController         | detail()                     | ✅     |
| /admin/utilisateurs/{id}/mettre-a-jour                            | admin_user_update             | GET, POST    | AdminUserController         | update()                     | ✅     |
| /admin/utilisateurs/{id}/supprimer-photo                          | admin_user_delete_picture     | GET, POST    | AdminUserController         | deletePicture()              | ✅     |
| /admin/utilisateurs/{id}/supprimer                                | admin_user_delete             | GET, POST    | AdminUserController         | delete()                     | ✅     |
| /admin/utilisateurs/statistiques                                  | admin_user_statistics         | GET, POST    | AdminUserController         | statistics()                 | ✅     |
| /admin/produits/creer                                             | admin_product_create          | GET, POST    | AdminProductController      | create()                     | ✅     |
| /admin/produits                                                   | admin_product_list            | GET          | AdminProductController      | list()                       | ✅     |
| /admin/produits/{slug}                                            | admin_product_detail          | GET          | AdminProductController      | detail()                     | ✅     |
| /admin/produits/{slug}/mettre-a-jour                              | admin_product_update          | GET, POST    | AdminProductController      | update()                     | ✅     |
| /admin/produits/{id}/supprimer                                    | admin_product_delete          | GET, POST    | AdminProductController      | delete()                     | ✅     |
| /admin/categories/creer                                           | admin_category_create         | GET, POST    | AdminCategoryController     | create()                     | ✅     |
| /admin/categories                                                 | admin_category_list           | GET          | AdminCategoryController     | list()                       | ✅     |
| /admin/categories/{slug}/produits                                 | admin_category_product_list   | GET          | AdminCategoryController     | productList()                | ✅     |
| /admin/categories/{slug}                                          | admin_category_detail         | GET          | AdminCategoryController     | detail()                     | ✅     |
| /admin/categories/{categorySlug}/produits/{productSlug}           | admin_category_product_detail | GET          | AdminCategoryController     | productDetail()              | ✅     |
| /admin/categories/{slug}/mettre-a-jour                            | admin_category_update         | GET, POST    | AdminCategoryController     | update()                     | ✅     |
| /admin/categories/{id}/supprimer                                  | admin_category_delete         | GET, POST    | AdminCategoryController     | delete()                     | ✅     |
| /admin/utilisateurs/{id}/adresses/creer                           | admin_address_create          | GET, POST    | AdminAddressController      | create()                     | ✅     |
| /admin/adresses                                                   | admin_address_list            | GET          | AdminAddressController      | list()                       | ✅     |
| /admin/utilisateurs/{id}/adresses                                 | admin_address_user_list       | GET          | AdminAddressController      | userList()                   | ✅     |
| /admin/utilisateurs/{userId}/adresses/{addressId}                 | admin_address_detail          | GET          | AdminAddressController      | detail()                     | ✅     |
| /admin/utilisateurs/{userId}/adresses/{addressId}/mettre-a-jour   | admin_address_update          | GET, POST    | AdminAddressController      | update()                     | ✅     |
| /admin/utilisateurs/{userId}/adresses/{addressId}/supprimer       | admin_address_delete          | GET, POST    | AdminAddressController      | delete()                     | ✅     |
| /admin/modes-de-livraison/creer                                   | admin_delivery_mode_create    | GET, POST    | AdminDeliveryModeController | create()                     | ✅     |
| /admin/modes-de-livraison                                         | admin_delivery_mode_list      | GET          | AdminDeliveryModeController | list()                       | ✅     |
| /admin/modes-de-livraison/{id}                                    | admin_delivery_mode_detail    | GET          | AdminDeliveryModeController | detail()                     | ✅     |
| /admin/modes-de-livraison/{id}/mettre-a-jour                      | admin_delivery_mode_update    | GET, POST    | AdminDeliveryModeController | update()                     | ✅     |
| /admin/modes-de-livraison/{id}/supprimer                          | admin_delivery_mode_delete    | GET, POST    | AdminDeliveryModeController | delete()                     | ✅     |
| /admin/utilisateurs/{id}/commandes/creer                          | admin_purchase_create         | GET, POST    | AdminPurchaseController     | create()                     | ✅     |
| /admin/commandes                                                  | admin_purchase_list           | GET          | AdminPurchaseController     | list()                       | ✅     |
| /admin/utilisateurs/{id}/commandes                                | admin_purchase_user_list      | GET          | AdminPurchaseController     | userList()                   | ✅     |
| /admin/commandes/{reference}                                      | admin_purchase_detail         | GET          | AdminPurchaseController     | detail()                     | ✅     |
| /admin/utilisateurs/{userId}/commandes/{purchaseId}               | admin_purchase_user_detail    | GET          | AdminPurchaseController     | userDetail()                 | ✅     |
| /admin/utilisateurs/{userId}/commandes/{purchaseId}/mettre-a-jour | admin_purchase_update         | GET, POST    | AdminPurchaseController     | update()                     | ✅     |
| /admin/purchases/{id}/supprimer                                   | admin_purchase_delete         | GET, POST    | AdminPurchaseController     | delete()                     | ✅     |
| /admin/commandes/{reference}/telecharger/facture                  | admin_purchase_download_bill  | GET          | AdminPurchaseController     | downloadBill()               | ✅     |
| /produits                                                         | product_list                  | GET          | AdminProductController      | list()                       | ✅     |
| /produits/{slug}                                                  | product_detail                | GET          | AdminProductController      | detail()                     | ✅     |
| /categories                                                       | category_list                 | GET          | AdminCategoryController     | list()                       | ✅     |
| /categories/{slug}/produits                                       | category_product_list         | GET          | AdminCategoryController     | productList()                | ✅     |
| /categories/{categorySlug}/produits/{productSlug}                 | category_product_detail       | GET          | AdminCategoryController     | productDetail()              | ✅     |
| /adresses/creer                                                   | address_create                | GET, POST    | AdminAddressController      | create()                     | ✅     |
| /adresses                                                         | address_list                  | GET          | AdminAddressController      | list()                       | ✅     |
| /adresses/{id}                                                    | address_detail                | GET          | AdminAddressController      | detail()                     | ✅     |
| /adresses/{id}/mettre-a-jour                                      | address_update                | GET, POST    | AdminAddressController      | update()                     | ✅     |
| /adresses/{id}/supprimer                                          | address_delete                | GET, POST    | AdminAddressController      | delete()                     | ✅     |
| /panier/ajouter/produits/{id}                                     | cart_add                      | GET          | CartController              | add()                        | ✅     |
| /panier                                                           | cart_detail                   | GET          | CartController              | add()                        | ✅     |
| /panier/produits/{id}/supprimer                                   | cart_delete                   | GET          | CartController              | delete()                     | ✅     |
| /panier/produits/{id}/decrementer                                 | cart_decremente               | GET          | CartController              | decremente()                 | ✅     |
| /commandes                                                        | purchase_list                 | GET          | PurchaseController          | list()                       | ✅     |
| /commandes/{reference}                                            | purchase_detail               | GET          | PurchaseController          | detail()                     | ✅     |
| /commandes/{reference}/telecharger/facture                        | purchase_download_bill        | GET          | PurchaseController          | downloadBill()               | ✅     |
| /demande-supression-compte                                        | user_delete_request           | GET          | UserController              | deleteRequest()              | ❌     |
| /supprimer-mon-compte                                             | user_delete_my-account        | GET, POST    | UserController              | delete()                     | ❌     |

## **Role Hierarchy**

ROLE_ADMIN:

- User:
  - CREATE ❌ (ROLE_SUPER_ADMIN only)
  - READ ✅
  - UPDATE only for ROLE_USER except password ❌ & roles ❌ (ROLE_SUPER_ADMIN only) ✅
  - DELETE ❌ (ROLE_SUPER_ADMIN only)

## Divers

Frais de préparation  
Frais de livraison  
Frais d'expédition

Frais d'expédition = frais de préparation + frais de port

## Data Dictionnary

| Fields | Types | Particularities | Descriptions |
| ------ | ----- | --------------- | ------------ |
