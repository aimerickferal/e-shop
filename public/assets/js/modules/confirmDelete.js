const confirmDelete = {
  // Proprietes availables in the object.
  // ======================= DOM ELEMENTS =======================
  userDeleteLinks: [],
  addressDeleteLinks: [],
  productDeleteLinks: [],
  categoryDeleteLinks: [],
  deliveryModeDeleteLinks: [],
  init: function () {
    console.log("Hello world, I'm confirmDelete.js 🗑");

    // ======================= DOM ELEMENTS =======================

    // User
    confirmDelete.userDeleteLinks = document.querySelectorAll(
      ".page__user-delete-link"
    );
    for (let userDeleteLink of confirmDelete.userDeleteLinks) {
      // We add a listener and a handler on the click event.
      userDeleteLink.addEventListener(
        "click",
        confirmDelete.handleDeleteUserLinks
      );
    }

    // Address
    confirmDelete.addressDeleteLinks = document.querySelectorAll(
      ".page__address-delete-link"
    );
    for (let addressDeleteLink of confirmDelete.addressDeleteLinks) {
      // We add a listener and a handler on the click event.
      addressDeleteLink.addEventListener(
        "click",
        confirmDelete.handleDeleteAddressLinks
      );
    }

    // Product
    confirmDelete.productDeleteLinks = document.querySelectorAll(
      ".page__product-delete-link"
    );
    for (let productDeleteLink of confirmDelete.productDeleteLinks) {
      // We add a listener and a handler on the click event.
      productDeleteLink.addEventListener(
        "click",
        confirmDelete.handleDeleteProductLinks
      );
    }

    // Category
    confirmDelete.categoryDeleteLinks = document.querySelectorAll(
      ".page__category-delete-link"
    );
    for (let categoryDeleteLink of confirmDelete.categoryDeleteLinks) {
      // We add a listener and a handler on the click event.
      categoryDeleteLink.addEventListener(
        "click",
        confirmDelete.handleDeleteCategoryLinks
      );
    }

    // DeliveryMode
    confirmDelete.deliveryModeDeleteLinks = document.querySelectorAll(
      ".page__delievry-mode-delete-link"
    );
    for (let deliveryModeDeleteLink of confirmDelete.deliveryModeDeleteLinks) {
      // We add a listener and a handler on the click event.
      deliveryModeDeleteLink.addEventListener(
        "click",
        confirmDelete.handleDeleteDeliveryModeLinks
      );
    }
  },
  /**
   * Method that instructs the browser to display a dialog with an optional message specific to the related user, and wait until the user either confirm or cancels the dialog.
   * @param {Event} event
   * @return {void}
   */
  handleDeleteUserLinks: function (event) {
    console.log("confirmDelete.handleDeleteUserLinks()");

    // We get the DOM element form which the event occured.
    const clickedLink = event.currentTarget;
    console.log(event.currentTarget);

    // The data of the user first name and last name are backup in a HTML dataset attribute.
    let firstName = clickedLink.dataset.userfirstname;
    let lastName = clickedLink.dataset.userlastname;

    // We display a dialog box with a message to te browser.
    let answer = window.confirm(
      "Confirmez-vous la suppression du compte de " +
        firstName +
        " " +
        lastName +
        " ?"
    );

    confirmDelete.checkUserAnswer(event, answer);
  },
  /**
   * Method that instructs the browser to display a dialog with an optional message specific to the related address, and wait until the user either confirm or cancels the dialog.
   * @param {Event} event
   * @return {void}
   */
  handleDeleteAddressLinks: function (event) {
    console.log("confirmDelete.handleDeleteAddressLinks()");

    // We get the DOM element form which the event occured.
    const clickedLink = event.currentTarget;

    // The data of the user first name and last name are backup in a HTML dataset attribute.
    let firstName = clickedLink.dataset.userfirstname;
    let lastName = clickedLink.dataset.userlastname;

    // We display a dialog box with a message to te browser.
    let answer = window.confirm(
      "Confirmez-vous la suppression de l'adresse de " +
        firstName +
        " " +
        lastName +
        " ?"
    );

    confirmDelete.checkUserAnswer(event, answer);
  },
  /**
   * Method that instructs the browser to display a dialog with an optional message specific to the related product, and wait until the user either confirm or cancels the dialog.
   * @param {Event} event
   * @return {void}
   */
  handleDeleteProductLinks: function (event) {
    console.log("confirmDelete.handleDeleteProductLinks()");

    // We get the DOM element form which the event occured.
    const clickedLink = event.currentTarget;

    // The data of the product name is backup in a HTML dataset attribute.
    let productName = clickedLink.dataset.productname;

    // We display a dialog box with a message to te browser.
    let answer = window.confirm(
      "Confirmez-vous la suppression du produit " + productName + " ?"
    );

    confirmDelete.checkUserAnswer(event, answer);
  },
  /**
   * Method that instructs the browser to display a dialog with an optional message specific to the related category, and wait until the user either confirm or cancels the dialog.
   * @param {Event} event
   * @return {void}
   */
  handleDeleteCategoryLinks: function (event) {
    console.log("confirmDelete.handleDeleteCategoryLinks()");

    // We get the DOM element form which the event occured.
    const clickedLink = event.currentTarget;

    // The data of the category name is backup in a HTML dataset attribute.
    let categoryName = clickedLink.dataset.categoryname;

    // We display a dialog box with a message to te browser.
    let answer = window.confirm(
      "Confirmez-vous la suppression de la catégorie " + categoryName + " ?"
    );

    confirmDelete.checkUserAnswer(event, answer);
  },
  /**
   * Method that instructs the browser to display a dialog with an optional message specific to the related delivery mode, and wait until the user either confirm or cancels the dialog.
   * @param {Event} event
   * @return {void}
   */
  handleDeleteDeliveryModeLinks: function (event) {
    console.log("confirmDelete.handleDeleteDeliveryModeLinks()");

    // We get the DOM element form which the event occured.
    const clickedLink = event.currentTarget;

    // The data of the delivery mode name is backup in a HTML dataset attribute.
    let deliveryModeName = clickedLink.dataset.deliverymodename;

    // We display a dialog box with a message to te browser.
    let answer = window.confirm(
      "Confirmez-vous la suppression de la " + deliveryModeName + " ?"
    );

    confirmDelete.checkUserAnswer(event, answer);
  },
  /**
   * Method that check the user answer to the window.confirm() dialog box.
   * @param {Event} event
   * @param {Boolean} answer
   * @return {void}
   */
  checkUserAnswer: function (event, answer) {
    console.log("confirmDelete.checkUserAnswer()");

    console.log(answer);

    // When the window.confirm() dialog box is open if the user click on "Cancel" the return value of window.confirm() will be false.
    // If the answer is false
    if (!answer) {
      // the user don't want to delete the entity so we stop the default action.
      event.preventDefault();
      // We leave confirmDelete.handleDeleteUserLinks().
      return;
    }
  },
};
