const confirmDelete = {
  // Proprietes availables in the object.
  // ======================= DOM ELEMENTS =======================
  deleteUserLinks: [],
  deleteAddressLinks: [],
  deleteProductLinks: [],
  deleteCategoryLinks: [],
  deleteDeliveyModeLinks: [],
  init: function () {
    console.log("Hello world, I'm confirmDelete.js 🗑");

    // ======================= DOM ELEMENTS =======================

    // User
    confirmDelete.deleteUserLinks = document.querySelectorAll(
      ".page__delete-user-link"
    );
    // For each link of form.deleteUserLinks.
    for (let link of confirmDelete.deleteUserLinks) {
      // We add a listener and a handler on the click event.
      link.addEventListener("click", confirmDelete.handleDeleteUserLinks);
    }

    // Address
    confirmDelete.deleteAddressLinks = document.querySelectorAll(
      ".page__delete-address-link"
    );
    // For each link of form.deleteAddressLinks.
    for (let link of confirmDelete.deleteAddressLinks) {
      // We add a listener and a handler on the click event.
      link.addEventListener("click", confirmDelete.handleDeleteAddressLinks);
    }

    // Product
    confirmDelete.deleteProductLinks = document.querySelectorAll(
      ".page__delete-product-link"
    );
    // For each link of form.deleteProductLinks.
    for (let link of confirmDelete.deleteProductLinks) {
      // We add a listener and a handler on the click event.
      link.addEventListener("click", confirmDelete.handleDeleteProductLinks);
    }

    // Category
    confirmDelete.deleteCategoryLinks = document.querySelectorAll(
      ".page__delete-link-category"
    );
    // For each link of form.deleteCategoryLinks.
    for (let link of confirmDelete.deleteCategoryLinks) {
      // We add a listener and a handler on the click event.
      link.addEventListener("click", confirmDelete.handleDeleteCategoryLinks);
    }

    // DeliveryMode
    confirmDelete.deleteDeliveyModeLinks = document.querySelectorAll(
      ".page__delete-link-delivery-mode"
    );
    // For each link of form.deleteDeliveyModeLinks.
    for (let link of confirmDelete.deleteDeliveyModeLinks) {
      // We add a listener and a handler on the click event.
      link.addEventListener(
        "click",
        confirmDelete.handleDeleteDeliveryModeLinks
      );
    }
  },
  /**
   * Method that instructs the browser to display a dialog with an optional message specific to the concerned user, and to wait until the user either confirm or cancels the dialog.
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
   * Method that instructs the browser to display a dialog with an optional message specific to the concerned address, and to wait until the user either confirm or cancels the dialog.
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
   * Method that instructs the browser to display a dialog with an optional message specific to the concerned product, and to wait until the user either confirm or cancels the dialog.
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
   * Method that instructs the browser to display a dialog with an optional message specific to the concerned category, and to wait until the user either confirm or cancels the dialog.
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
   * Method that instructs the browser to display a dialog with an optional message specific to the concerned delivery mode, and to wait until the user either confirm or cancels the dialog.
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
