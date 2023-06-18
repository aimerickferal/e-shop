# **Todo**

- use class for titles
- term = galatea
- fix the header
- add img size in % as much as possible if not use em
- catch errors on upload
- resize image on upload
- TODO: solve issue on switch civilityTitle.
- Fix delete my user account feature : id = delete-my-user-account-link
- Stripe Checkout:

  - add TVA on invoice
  - send invoice by e-mail to user
  - use webhook with checkout.session.completed event to backup or not the purchase
  - set country by default to France: https://stackoverflow.com/questions/70843839/in-stripe-checkout-page-display-country-or-region-fields-how-to-remove-it/70845469#70845469

- secrure routes with Role Hierarchy for user entity
- only ROLE_ADMIN can update user roles:
  - AdminUserType.php enable display roles field only for ROLE_SUPER_ADMIN
  - Make:

```javascript
  /**
   * Method that check if only one input of the several given inputs is checkd.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorMessage
   * @return {void}
   */
  checkIfOnlyOneInputIsChecked: function (input, errorMessage) {
    console.log("form.checkIfOnlyOneInputIsChecked()");
  },
```

Things to do make the project fonctional in prod:

- Send e-mail of contact form
- Make PayPal checkout
- Fix delete Product blocked by the PurchaseItem constraint

## **Commit**

## Video script

- registration
- login
- infinite scroolidod
- add 1 t shirt
- click detail 1 t shirt add
- search red
- add
- panier
- incrementation / decremenation
- continuer shooping
- category
- go purchase
- detail purchase
- address
- profil
- dashboard
- user CRUD + stats
- product CRUD
- category CRUD
- delivery mode CRUD

error: quand l'action de l'utilisateur a échoué
warning: quand on doit transmettre une info après action de l'utilisateur sans échec (important)
notice: quand on doit transmettre une info sans action de l'utilisateur (pas imporant)
