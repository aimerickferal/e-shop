# **Documentation**

## **Setup**

- HTML 5
- CSS 3
- JavaScript ECMAScript 2020
- PHP 8
- Symfony 6
- MariaDB Version 15.1 Distribution 10.11.2

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
<!-- - isActivated : bool (0 or 1) -->

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
- picture
- price
- description
- category | Many To One, allowed to be null : no, but you say yes
- createdAt
- updatedAt

| id  | name         | slug         | picture     | price | description | category      | created_at          | updated_at          |
| --- | ------------ | ------------ | ----------- | ----- | ----------- | ------------- | ------------------- | ------------------- |
| 1   | Product Name | product-name | product.png | 9999  | Lorem...    | Category Name | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

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
- user | ManyToOne, allowed to be null : no
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

| id  | reference    | billing_address                                                       | delivery_address                                                               | subtotal | delivery_mode      | delivery_mode_price | total | checkout_method             | stripe_session_id  | status | bill     | user_id | purchased_at        | updated_at          |
| --- | ------------ | --------------------------------------------------------------------- | ------------------------------------------------------------------------------ | -------- | ------------------ | ------------------- | ----- | --------------------------- | ------------------ | ------ | -------- | ------- | ------------------- | ------------------- |
| 1   | 3153c8b2b80a | Clark KENT 42 Hickory Lane 66605 - Smallville Kansas - USA 0642424242 | Clark KENT 42 Justice League street 88805 - Metropolis Kansas - USA 0642424242 | 999      | Delivery Mode Name | 999                 | 999   | Paiement par Carte Bancaire | hur783hfb99383yf30 | Payée  | bill.pdf | 1       | 2022-02-09 10:03:11 | 2022-02-09 10:03:11 |

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

## Data Dictionnary

| Fields | Types | Particularities | Descriptions |
| ------ | ----- | --------------- | ------------ |

## Divers

Frais de préparation  
Frais de livraison  
Frais d'expédition

Frais d'expédition = frais de préparation + frais de port

## Markdown Array Template

|     |     |     |
| --- | --- | --- |
|     |     |     |
