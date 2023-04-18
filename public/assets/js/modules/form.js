const form = {
  // Proprietes availables in the object.
  colors: {},
  numberOfErrors: null,
  // Address's regex
  regexMatchTenNumericCharacters: null,
  regexMatchStartBy06Or07: null,
  regexMatchFiveNumericCharacters: null,
  // User's regex
  regexMatchEmail: null,
  regexMatchAtLeastHeightCharacters: null,
  regexMatchAtLeastOneLowercase: null,
  regexMatchAtLeastOneUppercase: null,
  regexMatchAtLeastOneNumericCharacter: null,
  regexMatchAtLeastOneSpecialCharacter: null,
  // Category's regex
  //! START. regex not used
  regexMatchAlphabeticalCharactersWithOrWithoutDiacriticalMarks: null,
  regexMatchAccentedAlphabeticalCharacters: null,
  regexMatchAlphabeticalCharacters: null,
  regexMatchAlphabeticalCharactersAndSpace: null,
  regexMatchAlphabeticalCharactersWithHyphen: null,
  //! END. regex not used
  // Product's regex
  regexMatchNumber: null,
  // Purchase's regex
  regexMatchAtLeastTweleCharacters: null,
  // ======================= DOM ELEMENTS =======================
  // User's forms
  signUpForm: null,
  loginForm: null,
  userProfileForm: null,
  adminCreateUserForm: null,
  adminUpdateUserForm: null,
  searchUserForm: null,
  requestPasswordForm: null,
  resetPasswordForm: null,
  // Category's forms
  adminCreateCategoryForm: null,
  adminUpdateCategoryForm: null,
  searchCategoryForm: null,
  // Product's forms
  adminCreateProductForm: null,
  adminUpdateProductForm: null,
  searchProductForm: null,
  // Address's forms
  userCreateAddressForm: null,
  userUpdateAddressForm: null,
  adminCreateAddressForm: null,
  adminUpdateAddressForm: null,
  searchAddressForm: null,
  // Purchase's forms
  adminCreatePurchaseForm: null,
  adminUpdatePurchaseForm: null,
  searchPurchaseForm: null,
  purchaseForm: null,
  // Delivery mode's forms
  adminCreateDeliveryModeForm: null,
  adminUpdateDeliveryModeForm: null,
  searchDeliveryModeForm: null,
  // Contact's form
  contactForm: null,
  // Upload's field
  uploadField: null,
  // Purchase's fields
  purchaseBillingAddressField: null,
  purchaseDeliveryAddressField: null,
  purchaseDeliveryModeField: null,
  purchaseCheckoutMethodField: null,
  purchaseTermsOfSaleField: null,
  // Inputs
  inputs: [],
  // User's inputs
  userEmailInput: null,
  userPasswordInput: null,
  userCivilityTitleInputs: [],
  userCivilityTitleManInput: null,
  userCivilityTitleWomanInput: null,
  userCivilityTitleProfileInputs: [],
  userGenderManLabel: null,
  userGenderWomanLabel: null,
  userFirstNameInput: null,
  userLastNameInput: null,
  userPictureInput: null,
  userRolesInputs: [],
  userTermsOfUseInput: null,
  // Category's inputs
  categoryNameInput: null,
  // Product's inputs
  productNameInput: null,
  productPictureInput: null,
  productPriceInput: null,
  productDescriptionInput: null,
  productAvailabilityInputs: [],
  productAvailableInputs: [],
  productUnavailableInputs: [],
  productCategoryInputs: [],
  // Address's inputs
  addressStreetNumberInput: null,
  addressStreetNameInput: null,
  addressZipCodeInput: null,
  addressCityInput: null,
  addressCountryInput: null,
  // Purchase's inputs
  purchaseProductsInputs: [],
  purchaseReferenceInput: null,
  purchaseStatusInputs: [],
  purchaseStatusPaidInputs: [],
  purchaseStatusInProgressInputs: [],
  purchaseStatusSendInputs: [],
  purchaseStatusDeliverInputs: [],
  purchaseStatusAnnulInputs: [],
  purchaseBillingAddressInputs: [],
  purchaseDeliveryAddressInputs: [],
  purchaseDeliveryModeInputs: [],
  purchaseCheckoutMethodInputs: [],
  purchaseBillInput: null,
  termsOfSaleInput: null,
  purchasePendingCheckoutInput: null,
  // Delivery mode's inputs
  deliveryModeNameInput: null,
  deliveryModePictureInput: null,
  deliveryModePriceInput: null,
  deliveryModeMinCartAmountForFreeDelivery: null,
  deliveryModeDescriptionInput: null,
  // Contact's inputs
  contactSubjectInputs: [],
  phoneNumberInput: null,
  contactMessageInput: null,
  contactFileInput: null,
  // Error messages contact
  errorMessageContactFileMimeType: null,
  errorMessageContactFileSize: null,
  // User's error messages
  errorMessageGeneralTermsOfUseNotChecked: null,
  errorMessageUserEmailEmpty: null,
  errorMessageUserEmailValidity: null,
  errorMessageUserPasswordEmpty: null,
  errorMessageUserPasswordLength: null,
  errorMessageUserPasswordLowercase: null,
  errorMessageUserPasswordUppercase: null,
  errorMessageUserPasswordNumber: null,
  errorMessageUserPasswordSpecialCharacter: null,
  errorMessageUserFirstNameEmpty: null,
  errorMessageUserLastNameEmpty: null,
  errorMessageUserPictureMimeType: null,
  errorMessageUserPictureSize: null,
  errorMessageUserGenderNotChecked: null,
  // Category's error messages
  errorMessageCategoryNameEmpty: null,
  errorMessageCategoryNameValidity: null,
  // Product's error messages
  errorMessageProductNameEmpty: null,
  errorMessageProductPictureMimeType: null,
  errorMessageProductPictureSize: null,
  errorMessageProductPriceEmpty: null,
  errorMessageProductPriceValidity: null,
  errorMessageProductDescriptionEmpty: null,
  errorMessageProductAvailabilityNotChecked: null,
  errorMessageCategoryProductNotChecked: null,
  // Address's error messages
  errorMessageAddressStreetNumberEmpty: null,
  errorMessageAddressStreetNumberValidity: null,
  errorMessageAddressStreetNameEmpty: null,
  errorMessageAddressStreetNameValidity: null,
  errorMessageAddressZipCodeEmpty: null,
  errorMessageAddressZipCodeValidity: null,
  errorMessageAddressCityEmpty: null,
  errorMessageAddressCityValidity: null,
  errorMessageAddressCountryEmpty: null,
  errorMessageAddressCountryValidity: null,
  // Purchase's error messages
  errorMessagePurchaseProductsNotChecked: null,
  errorMessagePurchaseReferenceEmpty: null,
  errorMessagePurchaseReferenceLength: null,
  errorMessagePurchaseStatusNotChecked: null,
  errorMessagePurchaseBillingAddressNotChecked: null,
  errorMessagePurchaseDeliveryAddressNotChecked: null,
  errorMessagePurchasePaymentMethodNotChecked: null,
  errorMessagePurchaseBillMimeType: null,
  errorMessagePurchaseBillSize: null,
  errorMessagePurchaseDeliveryModeNotChecked: null,
  errorMessageGeneralTermsOfSaleNotChecked: null,
  // Delivery Mode's error messages
  errorMessageDeliveryModeNameEmpty: null,
  errorMessageDeliveryModeNameValidity: null,
  errorMessageDeliveryModePictureMimeType: null,
  errorMessageDeliveryModePictureSize: null,
  errorMessageDeliveryModePriceEmpty: null,
  errorMessageDeliveryModePriceValidity: null,
  errorMessageDeliveryModeDescriptionEmpty: null,
  errorMessageDeliveryModeMinCartAmountForFreeDeliveryEmpty: null,
  errorMessageDeliveryModeMinCartAmountForFreeDeliveryValidity: null,
  // Contact's error messages
  errorMessageContactSubjectNotChecked: null,
  errorMessagePhoneNumberEmpty: null,
  errorMessagePhoneNumberValidity: null,
  errorContactMessageEmpty: null,
  // Buttons
  submitButtons: [],
  // User's buttons
  signUpButton: null,
  loginButton: null,
  modifyMyUserProfileButton: null,
  updateMyUserProfileButton: null,
  searchUserButton: null,
  adminCreateUserButton: null,
  adminUpdateUserButton: null,
  requestPasswordButton: null,
  resetPasswordButton: null,
  // Category's buttons
  adminCreateCategoryButton: null,
  adminUpdateCategoryButton: null,
  searchCategoryButton: null,
  // Product's buttons
  adminCreateProductButton: null,
  adminUpdateProductButton: null,
  searchProductButton: null,
  // Address's buttons
  userCreateAddressButton: null,
  userUpdateAdressButton: null,
  adminCreateAddressButton: null,
  adminUpdateAddressButton: null,
  searchAddressButton: null,
  // Purchase's buttons
  adminCreatePurchaseButton: null,
  adminUpdatePurchaseButton: null,
  searchPurchaseButton: null,
  purchaseConfirmAddressesButton: null,
  purchaseConfirmDeliveryModeButton: null,
  purchaseConfirmButton: null,
  // Delivery mode's buttons
  adminCreateDeliveryModeButton: null,
  adminUpdateDeliveryModeButton: null,
  searchDeliveryModeButton: null,
  // Contact's buttons
  contactButton: null,
  // User's links
  deleteMyUserPictureLink: null,
  // deleteMyUserAccountLink: null,
  // Address's links
  createAddressLink: null,
  addNewAddressLink: null,
  // Purchase's steps
  purchaseSteps: [],
  // Step #1 : address
  addressStep: null,
  addressStepIconChecked: null,
  // Step #2 : delivery mode
  deliveryModeStep: null,
  deliveryModeStepIconChecked: null,
  // Step #3. payment method
  paymentMethodStep: null,
  paypalButtonContainer: null,
  paypalButton: null,
  init: function () {
    console.log("Hello world, I'm form.js 📝");

    // All the colors of the app set in the CSS.
    // We use getComputedStyle(document.documentElement).getPropertyValue() to get the value of our CSS variables.
    form.colors = {
      // We set the green color to the outline of the input in case of absence of error.
      green: getComputedStyle(document.documentElement).getPropertyValue(
        "--green"
      ),
      // We set the red color to the outline of the input in case of error.
      red: getComputedStyle(document.documentElement).getPropertyValue("--red"),
    };

    // We initialize a counter for the number errors.
    form.numberOfErrors = 0;

    // Regex

    // The $ means. ????
    // The +$ means. ????
    // The *$ means. match, from beginning to end, any character that appears zero or more times. Basically, that means. match everything from start to end of the string.

    // User's regex

    // Regex that match only type of e-mail value.
    form.regexMatchEmail = /^(.+)@(\S+)$/;
    // Regex that match only value that contain at least 8 characters.
    form.regexMatchAtLeastHeightCharacters = /(?=.{8,})/;
    // Regex that match only value that contain at least 1 lowercase alphabetical character.
    form.regexMatchAtLeastOneLowercase = /(?=.*[a-z])/;
    // Regex that match only value that contain at least 1 uppercase alphabetical character.
    form.regexMatchAtLeastOneUppercase = /(?=.*[A-Z])/;
    // Regex that match only value that contain at least 1 numeric character.
    form.regexMatchAtLeastOneNumericCharacter = /(?=.*[0-9])/;
    // Regex that match only value that contain at least 1 one special character, but we are escaping reserved RegEx characters to avoid conflict.
    form.regexMatchAtLeastOneSpecialCharacter = /(?=.*[!@#$%^&*])/;

    // Address's regex

    // Regex that match only value that contain at least 1 lowercase alphabetical character.
    // Regex that match only value that contain 10 numeric characters.
    form.regexMatchTenNumericCharacters = /^\d{10}$/;
    // Regex that match only value that start with the numeric value 06 or 07.
    form.regexMatchStartBy06Or07 = /^((06)|(07))[0-9]{8}$/;
    //! START : regex not used
    // Regex that match only alphabetical characters with or without diacritical marks.
    regexMatchAlphabeticalCharactersWithOrWithoutDiacriticalMarks =
      /^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/;
    // Regex that match only value that contain alphabetical characters.
    form.regexMatchAlphabeticalCharacters = /^[A-Za-z]+$/;
    // Regex that match only value that contain alphabetical characters and space.
    form.regexMatchAlphabeticalCharactersAndSpace = /^[a-zA-Z\s]*$/;
    // Regex that match only value that contain alphabetical characters and hyphen.
    form.regexMatchAlphabeticalCharactersWithHyphen = /^[A-Za-z-]+$/;
    // Regex that match alphabetical characters in uppercase and lowercase with accentend characters for uppercase and lowercase.
    form.regexMatchAccentedAlphabeticalCharacters = /[A-Za-zÀ-Ÿa-ÿ]/;
    //! EN : regex not used
    // The regex accepting only value that contain a digit number.
    form.regexMatchNumber = /\d+/;
    // Regex that match only value who contain 5 numeric characters.
    form.regexMatchFiveNumericCharacters = /^\d{5}$/;

    // Purchase's regex
    // Regex that match only value that contain at least 12 characters.
    form.regexMatchAtLeastTweleCharacters = /(?=.{12,})/;

    // ======================= DOM ELEMENTS =======================

    // User's forms
    form.signUpForm = document.getElementById("sign-up-form");
    form.loginForm = document.getElementById("login-form");
    form.userProfileForm = document.getElementById("user-profile-form");
    form.adminCreateUserForm = document.getElementById(
      "admin-create-user-form"
    );
    form.adminUpdateUserForm = document.getElementById(
      "admin-update-user-form"
    );
    form.searchUserForm = document.getElementById("search-user-form");
    form.requestPasswordForm = document.getElementById("request-password-form");
    form.resetPasswordForm = document.getElementById("reset-password-form");

    // Category's forms
    form.adminCreateCategoryForm = document.getElementById(
      "admin-create-category-form"
    );
    form.adminUpdateCategoryForm = document.getElementById(
      "admin-update-category-form"
    );
    form.searchCategoryForm = document.getElementById("search-category-form");

    // Product froms
    form.adminCreateProductForm = document.getElementById(
      "admin-create-product-form"
    );
    form.adminUpdateProductForm = document.getElementById(
      "admin-update-product-form"
    );
    form.searchProductForm = document.getElementById("search-product-form");

    // Address's forms
    form.userCreateAddressForm = document.getElementById(
      "user-create-address-form"
    );
    form.userUpdateAddressForm = document.getElementById(
      "user-update-address-form"
    );
    form.adminCreateAddressForm = document.getElementById(
      "admin-create-address-form"
    );
    form.adminUpdateAddressForm = document.getElementById(
      "admin-update-address-form"
    );
    form.searchAddressForm = document.getElementById("search-address-form");

    // Purchase's forms
    form.adminCreatePurchaseForm = document.getElementById(
      "admin-create-purchase-form"
    );
    form.adminUpdatePurchaseForm = document.getElementById(
      "admin-update-purchase-form"
    );
    form.searchPurchaseForm = document.getElementById("search-purchase-form");
    form.purchaseForm = document.getElementById("purchase-form");

    // Delivery mode's forms
    form.adminCreateDeliveryModeForm = document.getElementById(
      "admin-create-delivery-mode-form"
    );
    form.adminUpdateDeliveryModeForm = document.getElementById(
      "admin-update-delivery-mode-form"
    );
    form.searchDeliveryModeForm = document.getElementById(
      "search-delivery-mode-form"
    );

    // Contact's form
    form.contactForm = document.getElementById("contact-form");

    // Upload's field
    form.uploadField = document.querySelector(".form-field-upload");

    // Purchase's fields
    form.purchaseBillingAddressField = document.querySelector(
      ".form-field-purchase-billing-address"
    );
    form.purchaseDeliveryAddressField = document.querySelector(
      ".form-field-purchase-delivery-address"
    );
    form.purchaseDeliveryModeField = document.querySelector(
      ".form-field-purchase-delivery-mode"
    );
    form.purchaseCheckoutMethodField = document.querySelector(
      ".form-field-purchase-checkout-method"
    );
    form.purchaseTermsOfSaleField = document.querySelector(
      ".form-field-purchase-terms-of-sale"
    );

    // Inputs
    form.inputs = Array.from(document.querySelectorAll(".form-field__input"));
    // Foreach input of form.inputs.
    for (let input of form.inputs) {
      // We add a listener and a handler on the click event.
      input.addEventListener("click", form.handleAddInputFocusWithin);
      // We add a listener and a handler on the blur event.
      input.addEventListener("blur", form.handleRemoveInputsFocusWithin);
    }

    // User's inputs

    form.userEmailInput = document.querySelector(
      ".form-field__user-e-mail-input"
    );
    form.userPasswordInput = document.querySelector(
      ".form-field__user-password-input"
    );
    form.userCivilityTitleInputs = document.querySelectorAll(
      ".form-field__user-civility-title-input"
    );
    form.userCivilityTitleManInput = document.querySelector(
      ".form-field__user-civility-title-man-input"
    );
    // If the DOM element exist.
    if (form.userCivilityTitleManInput) {
      // We get the label related to form.userCivilityTitleManInput.
      form.userGenderManLabel =
        form.userCivilityTitleManInput.nextElementSibling;
    }
    form.userCivilityTitleWomanInput = document.querySelector(
      ".form-field__user-civility-title-woman-input"
    );
    // If the DOM element exist.
    if (form.userCivilityTitleWomanInput) {
      // We get the label related to form.userCivilityTitleWomanInput.
      form.userGenderWomanLabel =
        form.userCivilityTitleWomanInput.nextElementSibling;
    }
    // All the inputs type of radio related to the user civility title on the profile page.
    form.userCivilityTitleProfileInputs = document.querySelectorAll(
      ".form-field__user-civility-title-profile-input"
    );
    // For each input of form.userCivilityTitleProfileInputs.
    for (let input of form.userCivilityTitleProfileInputs) {
      // We get the label related to the input.
      let label = input.nextElementSibling;
      // We call form.displayNoneInputNotChecked with the elements in argument.
      form.displayNoneInputNotChecked(input, label);
    }
    form.userFirstNameInput = document.querySelector(
      ".form-field__user-first-name-input"
    );
    form.userLastNameInput = document.querySelector(
      ".form-field__user-last-name-input"
    );
    form.userPictureInput = document.querySelector(
      ".form-field__user-picture-input"
    );
    form.userRolesInputs = document.querySelectorAll(
      ".form-field__user-roles-input"
    );
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (form.userRolesInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(form.userRolesInputs);
    }
    form.userTermsOfUseInput = document.querySelector(
      ".form-field__terms-of-use-input"
    );
    // If the DOM element exist.
    if (form.userTermsOfUseInput) {
      // We get the label related to form.userTermsOfUseInput.
      label = form.userTermsOfUseInput.nextElementSibling;
      label.setAttribute("for", "user-terms-of-use-input");
    }

    // Category's inputs
    form.categoryNameInput = document.querySelector(
      ".form-field__category-name-input"
    );

    // Product's inputs
    form.productNameInput = document.querySelector(
      ".form-field__product-name-input"
    );
    form.productPictureInput = document.querySelector(
      ".form-field__product-picture-input"
    );
    form.productPriceInput = document.querySelector(
      ".form-field__product-price-input"
    );
    form.productDescriptionInput = document.querySelector(
      ".form-field__product-description-input"
    );
    form.productAvailabilityInputs = document.querySelectorAll(
      ".form-field__product-availability-input"
    );
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (form.productAvailabilityInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(
        form.productAvailabilityInputs
      );
    }
    // For each input of form.productAvailabilityInputs.
    for (let input of form.productAvailabilityInputs) {
      // We get the label related to form.productAvailabilityInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(label, "availability");
    }
    form.productAvailableInputs = document.querySelectorAll(
      ".form-field__product-availability-available-input"
    );
    // For each input of form.productAvailableInputs.
    for (let input of form.productAvailableInputs) {
      // We get the label related to form.productAvailableInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(
        label,
        "available",
        "availability__avialable_color_green"
      );
    }
    form.productUnavailableInputs = document.querySelectorAll(
      ".form-field__product-availability-unavailable-input"
    );
    // For each input of form.productUnavailableInputs.
    for (let input of form.productUnavailableInputs) {
      // We get the label related to form.productUnavailableInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(
        label,
        "unavailable",
        "availability__unavailable_color_red"
      );
    }
    form.productCategoryInputs = document.querySelectorAll(
      ".form-field__product-category-input"
    );
    // If the DOM elements exist.
    if (form.productCategoryInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(
        form.productCategoryInputs
      );
    }

    // Address's inputs
    form.addressStreetNumberInput = document.querySelector(
      ".form-field__address-street-number-input"
    );
    form.addressStreetNameInput = document.querySelector(
      ".form-field__address-street-name-input"
    );
    form.addressZipCodeInput = document.querySelector(
      ".form-field__address-zip-code-input"
    );
    form.addressCityInput = document.querySelector(
      ".form-field__address-city-input"
    );
    form.addressCountryInput = document.querySelector(
      ".form-field__address-country-input"
    );

    // Purchase's inputs
    form.purchaseReferenceInput = document.querySelector(
      ".form-field__purchase-reference-input"
    );
    form.purchaseStatusInputs = document.querySelectorAll(
      ".form-field__purchase-status-input"
    );
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (form.purchaseStatusInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(form.purchaseStatusInputs);
    }
    // For each input of form.purchaseStatusInputs.
    for (let input of form.purchaseStatusInputs) {
      // We get the label related to form.purchaseStatusInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(label, "status");
    }
    form.purchaseStatusPaidInputs = document.querySelectorAll(
      ".form-field__purchase-status-paid-input"
    );
    // For each input of form.purchaseStatusPaidInputs.
    for (let input of form.purchaseStatusPaidInputs) {
      // We get the label related to form.purchaseStatusPaidInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(
        label,
        "status__paid",
        "status__paid_color_green"
      );
    }
    form.purchaseStatusInProgressInputs = document.querySelectorAll(
      ".form-field__purchase-status-in-progress-input"
    );
    // For each input of form.purchaseStatusInProgressInputs.
    for (let input of form.purchaseStatusInProgressInputs) {
      // We get the label related to form purchaseStatusInProgressInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(
        label,
        "status__in-progress",
        "status__in-progress_color_orange"
      );
    }
    form.purchaseStatusSendInputs = document.querySelectorAll(
      ".form-field__purchase-status-send-input"
    );
    // For each input of form.purchaseStatusSendInputs.
    for (let input of form.purchaseStatusSendInputs) {
      //  We get the label related to form.purchaseStatusSendInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(
        label,
        "status__send",
        "status__send_color_purple"
      );
    }
    form.purchaseStatusDeliverInputs = document.querySelectorAll(
      ".form-field__purchase-status-deliver-input"
    );
    // For each input of form.purchaseStatusDeliverInputs.
    for (let input of form.purchaseStatusDeliverInputs) {
      // We get the label related to form.purchaseStatusDeliverInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(
        label,
        "status__deliver",
        "status__deliver_color_slimy-green"
      );
    }
    form.purchaseStatusAnnulInputs = document.querySelectorAll(
      ".form-field__purchase-status-annul-input"
    );
    // For each input of form.purchaseStatusAnnulInputs.
    for (let input of form.purchaseStatusAnnulInputs) {
      // We get the label related to form.purchaseStatusAnnulInputs.
      label = input.nextElementSibling;
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(
        label,
        "status__annul",
        "status__annul_color_red"
      );
    }
    form.purchaseBillingAddressInputs = document.querySelectorAll(
      ".form-field__purchase-billing-address-input"
    );
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (form.purchaseBillingAddressInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(
        form.purchaseBillingAddressInputs
      );
    }
    form.purchaseDeliveryAddressInputs = document.querySelectorAll(
      ".form-field__purchase-delivery-address-input"
    );
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (form.purchaseDeliveryAddressInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(
        form.purchaseDeliveryAddressInputs
      );
    }
    form.purchaseDeliveryModeInputs = document.querySelectorAll(
      ".form-field__purchase-delivery-mode-input"
    );
    // For each input of form.purchaseDeliveryModeInputs.
    for (let input of form.purchaseDeliveryModeInputs) {
      // We add a listener and a handler on the click event on each of the input.
      input.addEventListener("input", purchase.handleDeliveryModeInputs);
    }
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (form.purchaseDeliveryModeInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(
        form.purchaseDeliveryModeInputs
      );
      // We call form.createImgTagForDeliveryModePicture() to create a HTML img tag before each delivery mode field label.
      form.createImgTagForDeliveryModePicture();
    }
    form.purchaseCheckoutMethodInputs = document.querySelectorAll(
      ".form-field__purchase-checkout-method-input"
    );
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (form.purchaseCheckoutMethodInputs.length > 0) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(
        form.purchaseCheckoutMethodInputs
      );
      // We call form.createImgTagForPaymentMethodPicture() to create a HTML img tag before each payment method field label.
      form.createImgTagForPaymentMethodPicture();
    }
    form.purchaseBillInput = document.querySelector(
      ".form-field__purchase-bill-input"
    );
    form.termsOfSaleInput = document.querySelector(
      ".form-field__terms-of-sale-input"
    );
    // If the DOM element exist.
    if (form.termsOfSaleInput) {
      // We get the label related to form.userTermsOfUseInput.
      label = form.termsOfSaleInput.nextElementSibling;
      label.setAttribute("for", "purchase-terms-of-sale-input");
    }
    form.purchasePendingCheckoutInput = document.querySelector(
      ".form-field__pending-checkout-input"
    );
    // If the DOM element exist.
    if (form.purchasePendingCheckoutInput) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(
        form.purchasePendingCheckoutInput.nextElementSibling
      );
    }

    // Delivery mode's Inputs
    form.deliveryModeNameInput = document.querySelector(
      ".form-field__delivery-mode-name-input"
    );
    form.deliveryModePictureInput = document.querySelectorAll(
      ".form-field__delivery-mode-picture-input"
    );
    form.deliveryModePriceInput = document.querySelector(
      ".form-field__delivery-mode-price-input"
    );
    form.deliveryModeMinCartAmountForFreeDelivery = document.querySelector(
      ".form-field__delivery-mode-min-cart-amount-for-free-delivery-input"
    );
    form.deliveryModeDescriptionInput = document.querySelector(
      ".form-field__delivery-mode-description-input"
    );

    // Contact's inputs
    form.contactSubjectInputs = document.querySelectorAll(
      ".form-field__contact-subject-input"
    );
    // If the DOM elements exist.
    if (form.contactSubjectInputs) {
      // We call the form.createDivForEachInputAndLabelOfCheckField() to create a div with a form-field class for each pair of input and label.
      form.createDivForEachInputAndLabelOfCheckField(form.contactSubjectInputs);
    }
    form.phoneNumberInput = document.querySelector(
      ".form-field__phone-number-input"
    );
    form.contactMessageInput = document.querySelector(
      ".form-field__contact-message-input"
    );
    form.contactFileInput = document.querySelector(
      ".form-field__contact-file-input"
    );

    // User's error messages
    form.errorMessageGeneralTermsOfUseNotChecked = document.querySelector(
      ".error-message-terms-of-use-not-checked"
    );
    form.errorMessageUserEmailEmpty = document.querySelector(
      ".error-message-user-email-empty"
    );
    form.errorMessageUserEmailValidity = document.querySelector(
      ".error-message-user-email-validity"
    );
    form.errorMessageUserPasswordEmpty = document.querySelector(
      ".error-message-user-password-empty"
    );
    form.errorMessageUserPasswordLength = document.querySelector(
      ".error-message-user-password-length"
    );
    form.errorMessageUserPasswordLowercase = document.querySelector(
      ".error-message-user-password-lowercase"
    );
    form.errorMessageUserPasswordUppercase = document.querySelector(
      ".error-message-user-password-uppercase"
    );
    form.errorMessageUserPasswordNumber = document.querySelector(
      ".error-message-user-password-number"
    );
    form.errorMessageUserPasswordSpecialCharacter = document.querySelector(
      ".error-message-user-password-special-character"
    );
    form.errorMessageUserFirstNameEmpty = document.querySelector(
      ".error-message-user-first-name-empty"
    );
    form.errorMessageUserLastNameEmpty = document.querySelector(
      ".error-message-user-last-name-empty"
    );
    form.errorMessageUserGenderNotChecked = document.querySelector(
      ".error-message-user-gender-not-checked"
    );
    form.errorMessageUserPictureMimeType = document.querySelector(
      ".error-message-user-picture-mime-type"
    );
    form.errorMessageUserPictureSize = document.querySelector(
      ".error-message-user-picture-size"
    );

    // Category's error messages
    form.errorMessageCategoryNameEmpty = document.querySelector(
      ".error-message-category-name-empty"
    );
    form.errorMessageCategoryNameValidity = document.querySelector(
      ".error-message-category-name-validity"
    );

    // Product's error messages
    form.errorMessageProductNameEmpty = document.querySelector(
      ".error-message-product-name-empty"
    );
    form.errorMessageProductPictureMimeType = document.querySelector(
      ".error-message-product-picture-mime-type"
    );
    form.errorMessageProductPictureSize = document.querySelector(
      ".error-message-product-picture-size"
    );
    form.errorMessageProductPriceEmpty = document.querySelector(
      ".error-message-product-price-empty"
    );
    form.errorMessageProductPriceValidity = document.querySelector(
      ".error-message-product-price-validity"
    );
    form.errorMessageProductDescriptionEmpty = document.querySelector(
      ".error-message-product-description-empty"
    );
    form.errorMessageProductAvailabilityNotChecked = document.querySelector(
      ".error-message-product-availability-not-checked"
    );
    form.errorMessageCategoryProductNotChecked = document.querySelector(
      ".error-message-category-product-not-checked"
    );

    // Address's error messages
    form.errorMessageAddressStreetNumberEmpty = document.querySelector(
      ".error-message-empty-street-number"
    );
    form.errorMessageAddressStreetNumberValidity = document.querySelector(
      ".error-message-validity-street-number"
    );
    form.errorMessageAddressStreetNameEmpty = document.querySelector(
      ".error-message-empty-street-name"
    );
    form.errorMessageAddressStreetNameValidity = document.querySelector(
      ".error-message-validity-street-name"
    );
    form.errorMessageAddressZipCodeEmpty = document.querySelector(
      ".error-message-empty-zip-code"
    );
    form.errorMessageAddressZipCodeValidity = document.querySelector(
      ".error-message-validity-zip-code"
    );
    form.errorMessageAddressCityEmpty = document.querySelector(
      ".error-message-empty-city"
    );
    form.errorMessageAddressCityValidity = document.querySelector(
      ".error-message-validity-city"
    );
    form.errorMessageAddressCountryEmpty = document.querySelector(
      ".error-message-empty-country"
    );
    form.errorMessageAddressCountryValidity = document.querySelector(
      ".error-message-validity-country"
    );

    // Purchase's error messages
    form.errorMessagePurchaseProductsNotChecked = document.querySelector(
      ".error-message-purchase-products-not-checked"
    );
    form.errorMessagePurchaseReferenceEmpty = document.querySelector(
      ".error-message-purchase-reference-empty"
    );
    form.errorMessagePurchaseReferenceLength = document.querySelector(
      ".error-message-purchase-reference-length"
    );
    form.errorMessagePurchaseStatusNotChecked = document.querySelector(
      ".error-message-purchase-status-not-checked"
    );
    form.errorMessagePurchaseBillingAddressNotChecked = document.querySelector(
      ".error-message-purchase-billing-address-not-checked"
    );
    form.errorMessagePurchaseDeliveryAddressNotChecked = document.querySelector(
      ".error-message-purchase-delivery-address-not-checked"
    );
    form.errorMessagePurchaseDeliveryModeNotChecked = document.querySelector(
      ".error-message-purchase-delivery-mode-not-checked"
    );
    form.errorMessagePurchasePaymentMethodNotChecked = document.querySelector(
      ".error-message-purchase-payment-method-not-checked"
    );
    form.errorMessagePurchaseBillMimeType = document.querySelector(
      ".error-message-purchase-bill-mime-type"
    );
    form.errorMessagePurchaseBillSize = document.querySelector(
      ".error-message-purchase-bill-size"
    );
    form.errorMessageGeneralTermsOfSaleNotChecked = document.querySelector(
      ".error-message-terms-of-sale-not-checked"
    );

    // Delivery Mode's error messages
    form.errorMessageDeliveryModeNameEmpty = document.querySelector(
      ".error-message-delivery-mode-name-empty"
    );
    form.errorMessageDeliveryModeNameValidity = document.querySelector(
      ".error-message-delivery-mode-name-validity"
    );
    form.errorMessageDeliveryModePictureMimeType = document.querySelector(
      ".error-message-delivery-mode-picture-mime-type"
    );
    form.errorMessageDeliveryModePictureSize = document.querySelector(
      ".error-message-delivery-mode-picture-size"
    );
    form.errorMessageDeliveryModePriceEmpty = document.querySelector(
      ".error-message-delivery-mode-price-empty"
    );
    form.errorMessageDeliveryModePriceValidity = document.querySelector(
      ".error-message-delivery-mode-price-validity"
    );
    form.errorMessageDeliveryModeDescriptionEmpty = document.querySelector(
      ".error-message-delivery-mode-description-empty"
    );
    form.errorMessageDeliveryModeMinCartAmountForFreeDeliveryEmpty =
      document.querySelector(
        ".error-message-delivery-mode-min-cart-amount-for-free-delivery-empty"
      );
    form.errorMessageDeliveryModeMinCartAmountForFreeDeliveryValidity =
      document.querySelector(
        ".error-message-delivery-mode-min-cart-amount-for-free-delivery-validity"
      );

    // Contact's error messages
    form.errorMessageContactSubjectNotChecked = document.querySelector(
      ".error-message-contact-subject-not-checked"
    );
    form.errorMessagePhoneNumberEmpty = document.querySelector(
      ".error-message-empty-phone-number"
    );
    form.errorMessagePhoneNumberValidity = document.querySelector(
      ".error-message-validity-phone-number"
    );
    form.errorContactMessageEmpty = document.querySelector(
      ".error-message-contact-message-empty"
    );
    form.errorMessageContactFileMimeType = document.querySelector(
      ".error-message-contact-file-mime-type"
    );
    form.errorMessageContactFileSize = document.querySelector(
      ".error-message-contact-file-size"
    );

    // Buttons
    form.submitButtons = document.querySelectorAll(".page__submit-button");
    // If the DOM elements exist.
    if (form.submitButtons) {
      // For each submitButton of form.submitButtons.
      for (let submitButton of form.submitButtons) {
        // We add a listener and a handler on the click event.
        submitButton.addEventListener("click", form.handleFormSubmit);
      }
    }

    // Each button

    // User's buttons
    form.signUpButton = document.getElementById("sign-up-button");
    form.loginButton = document.getElementById("login-button");
    form.modifyMyUserProfileButton = document.getElementById(
      "modify-my-user-profile-button"
    );
    // If the DOM element exist.
    if (form.modifyMyUserProfileButton) {
      // We add a listener and a handler on the click event.
      form.modifyMyUserProfileButton.addEventListener(
        "click",
        form.handleUserProfileUpdate
      );
    }
    form.updateMyUserProfileButton = document.getElementById(
      "update-my-user-profile-button"
    );
    form.searchUserButton = document.getElementById("search-user-button");
    form.adminCreateUserButton = document.getElementById(
      "admin-create-user-button"
    );
    form.adminUpdateUserButton = document.getElementById(
      "admin-update-user-button"
    );
    form.requestPasswordButton = document.getElementById(
      "request-password-button"
    );
    form.resetPasswordButton = document.getElementById("reset-password-button");

    // Category's buttons
    form.adminCreateCategoryButton = document.getElementById(
      "admin-create-category-button"
    );
    form.adminUpdateCategoryButton = document.getElementById(
      "admin-update-category-button"
    );
    form.searchCategoryButton = document.getElementById(
      "search-category-button"
    );

    // Product's buttons
    form.adminCreateProductButton = document.getElementById(
      "admin-create-product-button"
    );
    form.adminUpdateProductButton = document.getElementById(
      "admin-update-product-button"
    );
    form.searchProductButton = document.getElementById("search-product-button");

    // Address's buttons
    form.userCreateAddressButton = document.getElementById(
      "user-create-address-button"
    );
    form.userUpdateAdressButton = document.getElementById(
      "user-update-address-button"
    );
    form.adminCreateAddressButton = document.getElementById(
      "admin-create-address-button"
    );
    form.adminUpdateAddressButton = document.getElementById(
      "admin-update-address-button"
    );
    form.searchAddressButton = document.getElementById("search-address-button");

    // Purchase's buttons
    form.adminCreatePurchaseButton = document.getElementById(
      "admin-create-purchase-button"
    );
    form.adminUpdatePurchaseButton = document.getElementById(
      "admin-update-purchase-button"
    );
    form.searchPurchaseButton = document.getElementById(
      "search-purchase-button"
    );
    form.purchaseConfirmAddressesButton = document.getElementById(
      "purchase-confirm-address-button"
    );
    form.purchaseConfirmDeliveryModeButton = document.getElementById(
      "purchase-confirm-delivery-mode-button"
    );
    form.purchaseConfirmButton = document.getElementById(
      "purchase-confirm-button"
    );

    // DeliveryMode buttons
    form.adminCreateDeliveryModeButton = document.getElementById(
      "admin-create-delivery-mode-button"
    );
    form.adminUpdateDeliveryModeButton = document.getElementById(
      "admin-update-delivery-mode-button"
    );
    form.searchDeliveryModeButton = document.getElementById(
      "search-delivery-mode-button"
    );

    // Contact's buttons
    form.contactButton = document.getElementById("contact-button");

    // Links

    // User's links
    form.deleteMyUserPictureLink = document.getElementById(
      "delete-my-user-picture-link"
    );
    // form.deleteMyUserAccountLink = document.getElementById(
    //   "delete-my-user-account-link"
    // );

    // Address's links
    form.createAddressLink = document.getElementById("create-address-link");
    form.addNewAddressLink = document.getElementById("add-new-address-link");

    // Purchase's steps
    form.purchaseSteps = document.querySelectorAll(".page__purchase-step");
    // For each step of form.purchaseSteps.
    for (let step of form.purchaseSteps) {
      // We add a listener and a handler on the click event.
      step.addEventListener("click", form.handlePurchaseSteps);
    }

    // Step #1 : address
    form.addressStep = document.getElementById("addresses-step");

    form.addressStepIconChecked = document.getElementById(
      "icon-checked-addresses-step"
    );

    // Step #2 : delivery mode
    form.deliveryModeStep = document.getElementById("delivery-mode-step");
    form.deliveryModeStepIconChecked = document.getElementById(
      "icon-checked-delivery-mode-step"
    );

    // Step #3. payment method
    form.paymentMethodStep = document.getElementById("payment-method-step");
    form.paypalButtonContainer = document.getElementById(
      "paypal-button-container"
    );
    // console.log(form.paypalButtonContainer);

    form.paypalButton = document.querySelector(".paypal-button");
    // console.log(form.paypalButton);
  },
  /**
   * Method that switch the color of the outline around the inputs.
   * @param {HTMLInputElement} input
   * @param {Sring} outlineColor
   * @return {void}
   */
  switchInputOutlineColor: function (input, outlineColor) {
    console.log("form.switchInputOutlineColor()");

    // We set the property of the CSS variable.
    input.style.setProperty("--outline", "0.1em solid " + outlineColor);
    // input.style.setProperty("--outline", "0.1em solid " + outlineColor);
  },
  /**
   * Method that switch the color of the input outline on the focus-within according to the value of mode.backgroundColor.
   * @param {Event} event
   * @return {void}
   */
  handleAddInputFocusWithin: function (event) {
    console.log("form.handleAddInputFocusWithin()");

    // We get the DOM element form which the event occured.
    const clickedInput = event.currentTarget;

    // We initialaze a index.
    let index = 0;
    // The index is the index of the clickedInput.
    index = form.inputs.indexOf(clickedInput);

    // If the mode item in localStorage is strictly equal to "dark".
    if (mode.backgroundColor === "dark") {
      // For each input of form.inputs.
      for (let input of form.inputs) {
        // If the the clickedInput is strictly equal to input.
        if (clickedInput === input) {
          // We call form.switchInputOutlineColor() to switch the outline color of the input.
          form.switchInputOutlineColor(clickedInput, mode.colors.white);
        }
      }
    }
    // Else if the mode item in localStorage is strictly equal to "light".
    else if (mode.backgroundColor === "light") {
      // For each input of form.inputs.
      for (let input of form.inputs) {
        // If the clickedInput is strictly equal to input.
        if (clickedInput === input) {
          // We call form.switchInputOutlineColor() to switch the outline color of the input.
          form.switchInputOutlineColor(clickedInput, mode.colors.black);
        }
      }
    }
  },
  /**
   * Method that remove the outline property on the inputs when they has lost focus.
   * @param {Event} event
   * @return {void}
   */
  handleRemoveInputsFocusWithin: function (event) {
    console.log("form.handleRemoveInputsFocusWithin()");

    // For each input of form.inputs.
    for (let input of form.inputs) {
      // We remove the outline.
      input.style.removeProperty("--outline");
    }
  },
  /**
   * Method that stop the form submit and according to the clicked button call the methods to check the input's value.
   * @param {Event} event
   * @return {void}
   */
  handleFormSubmit: function (event) {
    console.log("form.handleFormSubmit()");

    // We get the DOM element form which the event occured.
    const clickedButton = event.currentTarget;
    console.log(clickedButton);

    // We stop the form submit.
    event.preventDefault();
    console.log("STOP 🛑👮🏼‍♂️ Security check 🔐");

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.signUpButton ||
      clickedButton === form.loginButton ||
      clickedButton === form.updateMyUserProfileButton ||
      clickedButton === form.contactButton ||
      clickedButton === form.adminCreateUserButton ||
      clickedButton === form.adminUpdateUserButton ||
      clickedButton === form.requestPasswordButton
    ) {
      // We call form.checkIfEmail() to check if the input it not empty and valid.
      form.checkIfEmail(
        form.userEmailInput,
        form.errorMessageUserEmailEmpty,
        form.errorMessageUserEmailValidity
      );
    }

    // If clickedButton is strictly equal to form.searchUserButton.
    if (clickedButton === form.searchUserButton) {
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.userLastNameInput,
        form.errorMessageUserLastNameEmpty
      );
      // We call form.submitFormIfNoError() with form.searchUserForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.searchUserForm);
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.signUpButton ||
      clickedButton === form.loginButton ||
      clickedButton === form.adminCreateUserButton ||
      clickedButton === form.resetPasswordButton
    ) {
      // We call form.checkIfPassword() to check if the input it not empty and valid.
      form.checkIfPassword(
        form.userPasswordInput,
        form.errorMessageUserPasswordEmpty,
        form.errorMessageUserPasswordLength,
        form.errorMessageUserPasswordLowercase,
        form.errorMessageUserPasswordUppercase,
        form.errorMessageUserPasswordNumber,
        form.errorMessageUserPasswordSpecialCharacter
      );
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.signUpButton ||
      clickedButton === form.updateMyUserProfileButton ||
      clickedButton === form.contactButton ||
      clickedButton === form.adminCreateUserButton ||
      clickedButton === form.adminUpdateUserButton ||
      clickedButton === form.userCreateAddressButton ||
      clickedButton === form.userUpdateAdressButton ||
      clickedButton === form.adminCreateAddressButton ||
      clickedButton === form.adminUpdateAddressButton
    ) {
      // We call form.checkIfInputContainValue()to check if the input it not empty.
      form.checkIfInputContainValue(
        form.userFirstNameInput,
        form.errorMessageUserFirstNameEmpty
      );
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.userLastNameInput,
        form.errorMessageUserLastNameEmpty
      );
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.signUpButton ||
      clickedButton === form.adminCreateUserButton
    ) {
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.userCivilityTitleInputs,
        form.errorMessageUserGenderNotChecked
      );
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.adminCreateUserButton ||
      clickedButton === form.adminUpdateUserButton ||
      clickedButton === form.updateMyUserProfileButton
    ) {
      // If form.userPictureInput contain a value.
      if (form.userPictureInput.value) {
        // We call form.checkUploadedFileMimeType() to check the mime type of the uploded file.
        form.checkUploadedFileMimeType(
          form.userPictureInput,
          form.errorMessageUserPictureMimeType,
          form.errorMessageUserPictureSize
        );
      }
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.contactButton ||
      clickedButton === form.userCreateAddressButton ||
      clickedButton === form.userUpdateAdressButton ||
      clickedButton == form.adminCreateAddressButton ||
      clickedButton === form.adminUpdateAddressButton
    ) {
      // We call form.checkIfPhoneNumber() to check if the input it not empty and valid.
      form.checkIfPhoneNumber(
        form.phoneNumberInput,
        form.errorMessagePhoneNumberEmpty,
        form.errorMessagePhoneNumberValidity
      );
    }

    // If clickedButton is strictly equal to form.signUpButton.
    if (clickedButton === form.signUpButton) {
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.userTermsOfUseInput,
        form.errorMessageGeneralTermsOfUseNotChecked
      );
      // We call form.submitFormIfNoError() with form.signUpForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.signUpForm);
    }

    // If clickedButton is strictly equal to form.loginButton.
    if (clickedButton === form.loginButton) {
      // We call form.submitFormIfNoError() with form.loginForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.loginForm);
    }

    // If clickedButton is strictly equal to form.updateMyUserProfileButton.
    if (clickedButton === form.updateMyUserProfileButton) {
      // We call form.submitFormIfNoError() with form.userProfileForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.userProfileForm);
    }

    // If clickedButton is strictly equal to form.contactButton.
    if (clickedButton === form.contactButton) {
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.contactSubjectInputs,
        form.errorMessageContactSubjectNotChecked
      );
      // We call form.checkIfInputContainValue() to check if form.contactMessageInput is not empty.
      form.checkIfInputContainValue(
        form.contactMessageInput,
        form.errorContactMessageEmpty
      );
      // If form.contactFileInput contain a value.
      if (form.contactFileInput.value) {
        // We call form.checkUploadedFileMimeType() to check the mime type of the uploded file.
        form.checkUploadedFileMimeType(
          form.contactFileInput,
          form.errorMessageContactFileMimeType,
          form.errorMessageContactFileSize
        );
      }
      // We call form.submitFormIfNoError() with form.userProfileForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.contactForm);
    }

    // If clickedButton is strictly equal to form.adminCreateUserForm.
    if (clickedButton === form.adminCreateUserButton) {
      // We call form.submitFormIfNoError() with form.adminCreateUserForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminCreateUserForm);
    }

    // If clickedButton is strictly equal to form.adminUpdateUserButton.
    if (clickedButton == form.adminUpdateUserButton) {
      // We call form.submitFormIfNoError() with form.adminUpdateUserForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminUpdateUserForm);
    }

    // If clickedButton is strictly equal to form.requestPasswordButton.
    if (clickedButton == form.requestPasswordButton) {
      // We call form.submitFormIfNoError() with form.requestPasswordForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.requestPasswordForm);
    }

    // If clickedButton is strictly equal to form.resetPasswordButton.
    if (clickedButton === form.resetPasswordButton) {
      // We call form.submitFormIfNoError() with form.resetPasswordForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.resetPasswordForm);
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.adminCreateCategoryButton ||
      clickedButton === form.adminUpdateCategoryButton ||
      clickedButton === form.searchCategoryButton
    ) {
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.categoryNameInput,
        form.errorMessageCategoryNameEmpty
      );
    }

    // If clickedButton is strictly equal to form.adminCreateCategoryButton.
    if (clickedButton === form.adminCreateCategoryButton) {
      // We call form.submitFormIfNoError() with form.adminCreateCategoryForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminCreateCategoryForm);
    }

    // If clickedButton is strictly equal to form.adminUpdateCategoryButton.
    if (clickedButton === form.adminUpdateCategoryButton) {
      // We call form.submitFormIfNoError() with form.searchCategoryForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminUpdateCategoryForm);
    }

    // If clickedButton is strictly equal to form.searchCategoryButton.
    if (clickedButton === form.searchCategoryButton) {
      // We call form.submitFormIfNoError() with form.searchCategoryForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.searchCategoryForm);
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.adminCreateProductButton ||
      clickedButton === form.adminUpdateProductButton ||
      clickedButton === form.searchProductButton
    ) {
      // We call form.checkIfInputContainValue() to check if the input it not empty and valid.
      form.checkIfInputContainValue(
        form.productNameInput,
        form.errorMessageProductNameEmpty
      );
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.adminCreateProductButton ||
      clickedButton === form.adminUpdateProductButton
    ) {
      // If form.productPictureInput contain a value.
      if (form.productPictureInput.value) {
        // We call form.checkUploadedFileMimeType() to check the mime type of the uploded file.
        form.checkUploadedFileMimeType(
          form.productPictureInput,
          form.errorMessageProductPictureMimeType,
          form.errorMessageProductPictureSize
        );
      }
      // We call form.checkIfNumber() to check if the input it not empty and valid.
      form.checkIfNumber(
        form.productPriceInput,
        form.errorMessageProductPriceEmpty,
        form.errorMessageProductPriceValidity
      );
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.productDescriptionInput,
        form.errorMessageProductDescriptionEmpty
      );
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.productAvailabilityInputs,
        form.errorMessageProductAvailabilityNotChecked
      );
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.productCategoryInputs,
        form.errorMessageCategoryProductNotChecked
      );
    }

    // If clickedButton is strictly equal to form.adminCreateProductButton.
    if (clickedButton === form.adminCreateProductButton) {
      // We call form.submitFormIfNoError() with form.adminCreateProductForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminCreateProductForm);
    }

    // If clickedButton is strictly equal to form.adminUpdateProductButton.
    if (clickedButton === form.adminUpdateProductButton) {
      // We call form.submitFormIfNoError() with form.adminUpdateProductForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminUpdateProductForm);
    }

    // If clickedButton is strictly equal to form.searchProductButton.
    if (clickedButton === form.searchProductButton) {
      // We call form.submitFormIfNoError() with form.searchProductForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.searchProductForm);
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.userCreateAddressButton ||
      clickedButton === form.userUpdateAdressButton ||
      clickedButton === form.adminCreateAddressButton ||
      clickedButton === form.adminUpdateAddressButton ||
      clickedButton === form.searchAddressButton
    ) {
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.addressCityInput,
        form.errorMessageAddressCityEmpty
      );
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.userCreateAddressButton ||
      clickedButton === form.userUpdateAdressButton ||
      clickedButton === form.adminCreateAddressButton ||
      clickedButton === form.adminUpdateAddressButton
    ) {
      // We call form.checkIfStreetNumber() to check if the input it not empty and valid.
      form.checkIfStreetNumber(
        form.addressStreetNumberInput,
        form.errorMessageAddressStreetNumberEmpty,
        form.errorMessageAddressStreetNumberValidity
      );
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.addressStreetNameInput,
        form.errorMessageAddressStreetNameEmpty
      );
      // We call form.checkIfZipCode() to check if the input it not empty and valid.
      form.checkIfZipCode(
        form.addressZipCodeInput,
        form.errorMessageAddressZipCodeEmpty,
        form.errorMessageAddressZipCodeValidity
      );
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.addressCityInput,
        form.errorMessageAddressCityEmpty
      );
      // We call form.checkIfInputContainValue()to check if the input it not empty.
      form.checkIfInputContainValue(
        form.addressCountryInput,
        form.errorMessageAddressCountryEmpty
      );
    }

    // If clickedButton is strictly equal to form.userCreateAddressButton.
    if (clickedButton === form.userCreateAddressButton) {
      // We call form.submitFormIfNoError() with form.userCreateAddressForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.userCreateAddressForm);
    }

    // If clickedButton is strictly equal to form.updateAddressOnPurchaseButton.
    if (clickedButton === form.userUpdateAdressButton) {
      // We call form.submitFormIfNoError() with form.userUpdateAddressForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.userUpdateAddressForm);
    }

    // If clickedButton is strictly equal to form.adminCreateAddressButton.
    if (clickedButton === form.adminCreateAddressButton) {
      // We call form.submitFormIfNoError() with form.adminCreateAddressForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminCreateAddressForm);
    }

    // If clickedButton is strictly equal to form.adminUpdateAddressButton.
    if (clickedButton === form.adminUpdateAddressButton) {
      // We call form.submitFormIfNoError() with form.adminUpdateAddressForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminUpdateAddressForm);
    }

    // If clickedButton is strictly equal to form.searchAddressButton.
    if (clickedButton === form.searchAddressButton) {
      // We call form.submitFormIfNoError() with form.searchAddressForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.searchAddressForm);
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.adminCreatePurchaseButton ||
      clickedButton === form.adminUpdatePurchaseButton
    ) {
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.purchaseStatusInputs,
        form.errorMessagePurchaseStatusNotChecked
      );
    }

    // If clickedButton is strictly equal to form.adminCreatePurchaseButton.
    if (clickedButton === form.adminCreatePurchaseButton) {
      // We call form.checkIfInputIsChecked() to check if fthe input is checked.
      form.checkIfInputIsChecked(
        form.purchaseBillingAddressInputs,
        form.errorMessagePurchaseBillingAddressNotChecked
      );
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.purchaseDeliveryAddressInputs,
        form.errorMessagePurchaseDeliveryAddressNotChecked
      );
      // We call form.checkIfInputIsChecked() to check if the input is checked.
      form.checkIfInputIsChecked(
        form.purchaseDeliveryModeInputs,
        form.errorMessagePurchaseDeliveryModeNotChecked
      );
      // We call form.checkUploadedFileMimeType() to check the mime type of the uploded file.
      form.checkUploadedFileMimeType(
        form.purchaseBillInput,
        form.errorMessagePurchaseBillMimeType,
        form.errorMessagePurchaseBillSize
      );
      // We call form.submitFormIfNoError() with form.adminUpdaadminCreatePurchaseFormtePurchaseForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminCreatePurchaseForm);
    }

    // If clickedButton is strictly equal to form.adminUpdatePurchaseButton.
    if (clickedButton === form.adminUpdatePurchaseButton) {
      // If form.purchaseBillInput contain a value.
      if (form.purchaseBillInput.value) {
        // We call form.checkUploadedFileMimeType() to check the mime type of the uploded file.
        form.checkUploadedFileMimeType(
          form.purchaseBillInput,
          form.errorMessagePurchaseBillMimeType,
          form.errorMessagePurchaseBillSize
        );
      }
      // We call form.submitFormIfNoError() with form.adminUpdatePurchaseForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminUpdatePurchaseForm);
    }

    // If clickedButton is strictly equal to form.searchPurchaseButton.
    if (clickedButton === form.searchPurchaseButton) {
      // We call form.checkIfPurchaseReference() to check if the input it not empty and valid.
      form.checkIfPurchaseReference(
        form.purchaseReferenceInput,
        form.errorMessagePurchaseReferenceEmpty,
        form.errorMessagePurchaseReferenceLength
      );

      // We call form.submitFormIfNoError() with form.searchPurchaseForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.searchPurchaseForm);
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.adminCreateDeliveryModeButton ||
      clickedButton === form.adminUpdateDeliveryModeButton ||
      clickedButton === form.searchDeliveryModeButton
    ) {
      // We call form.checkIfInputContainValue() to check if the input it not empty.
      form.checkIfInputContainValue(
        form.deliveryModeNameInput,
        form.errorMessageDeliveryModeNameEmpty
      );
    }

    // If clickedButton is strictly equal to at least one of the compared buttons.
    if (
      clickedButton === form.adminCreateDeliveryModeButton ||
      clickedButton === form.adminUpdateDeliveryModeButton
    ) {
      // If form.deliveryModePictureInput contain a value.
      if (form.deliveryModePictureInput.value) {
        // We call form.checkUploadedFileMimeType() to check the mime type of the uploded file.
        form.checkUploadedFileMimeType(
          form.deliveryModePictureInput,
          form.errorMessageDeliveryModePictureMimeType,
          form.errorMessageDeliveryModePictureSize
        );
      }
      // We call form.checkIfNumber() to check if the input it not empty and valid.
      form.checkIfNumber(
        form.deliveryModePriceInput,
        form.errorMessageDeliveryModePriceEmpty,
        form.errorMessageDeliveryModePriceValidity
      );
      // We call form.checkIfNumber()to check if the input it not empty and valid.
      form.checkIfNumber(
        form.deliveryModeMinCartAmountForFreeDelivery,
        form.errorMessageDeliveryModeMinCartAmountForFreeDeliveryEmpty,
        form.errorMessageDeliveryModeMinCartAmountForFreeDeliveryValidity
      );
      // We call form.checkIfInputContainValue() to check if the input is not empty.
      form.checkIfInputContainValue(
        form.deliveryModeDescriptionInput,
        form.errorMessageDeliveryModeDescriptionEmpty
      );
    }

    // If clickedButton is strictly equal to form.adminCreateDeliveryModeButton.
    if (clickedButton === form.adminCreateDeliveryModeButton) {
      // We call form.submitFormIfNoError() with form.adminCreateDeliveryModeForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminCreateDeliveryModeForm);
    }

    // If clickedButton is strictly equal to form.adminUpdateDeliveryModeButton.
    if (clickedButton === form.adminUpdateDeliveryModeButton) {
      // We call form.submitFormIfNoError() with form.adminUpdateDeliveryModeForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.adminUpdateDeliveryModeForm);
    }

    if (clickedButton === form.searchDeliveryModeButton) {
      // If clickedButton is strictly equal to form.searchDeliveryModeButton.
      // We call form.submitFormIfNoError() with form.searchDeliveryModeForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.searchDeliveryModeForm);
    }
  },
  /**
   * Method that check if a input contain a value type of e-mail and and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageValidity
   * @return {void}
   */
  checkIfEmail: function (
    input,
    errorContactMessageEmpty,
    errorMessageValidity
  ) {
    console.log("form.checkIfEmail()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input contain a e-mail.
      if (form.regexMatchEmail.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageValidity);
      }
      // Else input is not valid.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageValidity);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if a input contain a value type of password and call the methods that display the related error messages.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageValidity
   * @param {HTMLParagraphElement} errorMessageLength
   * @param {HTMLParagraphElement} errorMessageLowercase
   * @param {HTMLParagraphElement} errorMessageUppercase
   * @param {HTMLParagraphElement} errorMessageNumber
   * @param {HTMLParagraphElement} errorMessageSpecialCharacter
   * @return {void}
   */
  checkIfPassword: function (
    input,
    errorContactMessageEmpty,
    errorMessageLength,
    errorMessageLowercase,
    errorMessageUppercase,
    errorMessageNumber,
    errorMessageSpecialCharacter
  ) {
    // console.log("form.checkIfPassword()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input contain at leat 8 characters.
      if (form.regexMatchAtLeastHeightCharacters.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageLength);
      }
      // Else input is empty.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageLength);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }

      // If input contain at leat 1 lowercase alphabetical character.
      if (form.regexMatchAtLeastOneLowercase.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageLowercase);
      }
      // Else input doesn't contain at least 1 lowercase alphabetical character.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageLowercase);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }

      // If input contain at leat 1 uppercase alphabetical character.
      if (form.regexMatchAtLeastOneUppercase.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageUppercase);
      }
      // Else the value of the password input doesn't contain at least 1 uppercase alphabetical character.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageUppercase);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }

      // If input contain at leat 1 numeric character.
      if (form.regexMatchAtLeastOneNumericCharacter.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageNumber);
      }
      // Else the value of the password input doesn't contain at least 1 numeric character.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageNumber);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }

      // If input contain at leat 1 special character.
      if (form.regexMatchAtLeastOneSpecialCharacter.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageSpecialCharacter);
      }
      // Else the value of the password input doesn't contain at least 1 special character.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageSpecialCharacter);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if a input contain a value and call the methods that display the related outline color and error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @return {void}
   */
  checkIfInputContainValue: function (input, errorContactMessageEmpty) {
    console.log("form.checkIfInputContainValue()");

    // If input contain a value.
    if (input.value) {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.green);
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if a input is checked and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorMessageNotChecked
   * @return {void}
   */
  checkIfInputIsChecked: function (input, errorMessageNotChecked) {
    console.log("form.checkIfInputIsChecked()");

    // We initialize a checked input's counter.
    let numberOfCheckedInput = 0;

    // If the number of input is superior to 1.
    if (input.length > 1) {
      console.log(input.length);
      console.log(input);
      console.log(Array.from(input));
      // We count the number of checked input.
      for (let index = 0; index < input.length; index++) {
        // If a input is checked.
        if (input[index].checked) {
          // We add one to the counter.
          numberOfCheckedInput++;
          console.log(numberOfCheckedInput);
          console.log(input[index].value);
        }
      }

      // If the number of checked input is superior to 0.
      if (numberOfCheckedInput > 0) {
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageNotChecked);
      }
      // Else the number of checked input is egual to 0.
      else {
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements..
        tools.removeDisplayNone(errorMessageNotChecked);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else the number of input is 1.
    else {
      // We can have one input which is a NodeList and when one input is a NodeList it as key 0 which is the input.
      // If we have have a input[0] (so a NodeList) and if the input[0] nodeTye is strictly equal to Node.ELEMENT_NODE.
      if (input[0] && input[0].nodeType === Node.ELEMENT_NODE) {
        // If the input is checked.
        if (input[0].checked) {
          //We call tools.addDisplayNone() to add the display-none class to one or several elements.
          tools.addDisplayNone(errorMessageNotChecked);
        }
        // Else the input is not checked.
        else {
          // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
          tools.removeDisplayNone(errorMessageNotChecked);
          // We add 1 to form.numberOfErrors.
          form.numberOfErrors++;
        }
      }
      // Else the input input[0] doesn't exist so its nodeType is not identical to Node.ELEMENT_NODE beause is doesn't exist.
      else {
        // If the input is checked or if the first input of the NodeList of input is checked.
        if (input.checked) {
          // We call tools.addDisplayNone() to add the display-none class to one or several elements.
          tools.addDisplayNone(errorMessageNotChecked);
        }
        // Else the input is not checked.
        else {
          // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
          tools.removeDisplayNone(errorMessageNotChecked);
          // We add 1 to form.numberOfErrors.
          form.numberOfErrors++;
        }
      }
    }
  },
  /**
   * Method that check if a uploaded file fit the authorized file mime type and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorMessageFileMimeType
   * @param {HTMLParagraphElement} errorMessageFileSize
   * @return {void}
   */
  checkUploadedFileMimeType: function (
    input,
    errorMessageFileMimeType,
    errorMessageFileSize
  ) {    
    console.log("form.checkUploadedFileMimeType()");

    console.log(input.files);

    // We put in a array the mime types we authorize.
    const authorizedMimeTypes = [
      "application/pdf",
      "image/png",
      "image/jpeg",
      "image/svg+xml",
    ];

    // We initialize a variable to confirm when a authorizedMimeTypes is authorized.
    let isAuthorized = null;

    // We count the number of uploaded file.
    for (let index = 0; index < input.files.length; index++) {
      // For each authorizedMimeType of authorizedMimeTypes.
      for (let authorizedMimeType of authorizedMimeTypes) {
        // If the mine type of the file is strictly equal to authorizedMimeType.
        if (input.files[index].type === authorizedMimeType) {
          console.log(input.files[index].type);
          console.log("File mime type accepted ✅");
          // We confirm that a authorizedMimeTypes is authorized.
          isAuthorized = true;
          // We call form.switchInputOutlineColor() to switch the input outline color.
          form.switchInputOutlineColor(input, form.colors.green);
          // We call tools.addDisplayNone() to add the display-none class to one or several elements.
          tools.addDisplayNone(errorMessageFileMimeType);
          // We call form.checkUploadedFileSize() to check the size of the uploded file.
          form.checkUploadedFileSize(input, errorMessageFileSize);
          // We leave form.checkUploadedFileMimeType().
          return;
        }
      }
    }

    // If none of the authorizedMimeTypes has been authorized.
    if (!isAuthorized) {
      console.log(input.files[index].type);
      console.log("File mime type denied ❌");
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorMessageFileSize);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if a uploaded file fit the required file size and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorMessageFileSize
   * @return {void}
   */
  checkUploadedFileSize: function (input, errorMessageFileSize) {
    console.log("form.checkUploadedFileSize()");

    // We initialize a constant that will contain the autorized file size.
    const authorizedFileSize = 300000;

    // We count the number of uploaded file.
    for (let index = 0; index < input.files.length; index++) {
      // If the size of the file is upper than 300 000 bytes we refuse the file.
      if (input.files[index].size > authorizedFileSize) {
        console.log(input.files[index].size);
        console.log("File size denied ❌");
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageFileSize);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
      // Else the size of the file is lower than 300 000 bytes so we accept the file.
      else {
        console.log(input.files[index].size);
        console.log("File size accepted ✅");
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageFileSize);
      }
    }
  },
  /**
   * Method that check if a input contain a value type of french phone number and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageValidity
   * @return {void}
   */
  checkIfPhoneNumber: function (
    input,
    errorContactMessageEmpty,
    errorMessageValidity
  ) {
    console.log("form.checkIfPhoneNumber()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input contain 10 numeric characters.
      if (form.regexMatchTenNumericCharacters.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageValidity);
      }
      // Else input is not valid.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageValidity);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }

      // If input start with the numeric value 06 or 07.
      if (form.regexMatchStartBy06Or07.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageValidity);
      }
      // Else input is not valid.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageValidity);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if a input contain a value type of number and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageValidity
   * @return {void}
   */
  checkIfAlphabeticalCharacters: function (
    input,
    errorContactMessageEmpty,
    errorMessageValidity
  ) {
    console.log("form.checkIfAlphabeticalCharacters()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input value contain a number it's invalid.
      if (form.regexMatchNumber.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageValidity);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
      // Else input is valid because it's a alphabetical character.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageValidity);
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if a input contain a value type of number and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageValidity
   * @return {void}
   */
  checkIfNumber: function (
    input,
    errorContactMessageEmpty,
    errorMessageValidity
  ) {
    console.log("form.checkIfNumber()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input is valid.
      if (form.regexMatchNumber.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageValidity);
      }
      // Else input is not valid.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageValidity);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if a input contain a value with at least 1 numeric character and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageValidity
   * @return {void}
   */
  checkIfStreetNumber: function (
    input,
    errorContactMessageEmpty,
    errorMessageValidity
  ) {
    console.log("form.checkIfStreetNumber()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input is valid.
      if (form.regexMatchAtLeastOneNumericCharacter.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageValidity);
      }
      // Else input is not valid.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageValidity);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that check if input contain a value type french zip code and call the methods that display the related error message.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageValidity
   * @return {void}
   */
  checkIfZipCode: function (
    input,
    errorContactMessageEmpty,
    errorMessageValidity
  ) {
    console.log("form.checkIfZipCode()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input is valid.
      if (form.regexMatchFiveNumericCharacters.test(input.value)) {
        // We call form.switchInputBorderColor() to switch the input's outline in green.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageValidity);
      }
      // Else input is not valid.
      else {
        // We call form.switchInputBorderColor() to switch the input's outline in red.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageValidity);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputBorderColor() to switch the input's outline in red.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   *  Method that check if a input contain a value type of reference and call the methods that display the related error messages.
   * @param {HTMLInputElement} input
   * @param {HTMLParagraphElement} errorContactMessageEmpty
   * @param {HTMLParagraphElement} errorMessageLength
   */
  checkIfPurchaseReference: function (
    input,
    errorContactMessageEmpty,
    errorMessageLength
  ) {
    console.log("form.checkIfPurchaseReference()");

    // If input is not empty.
    if (input.value) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(errorContactMessageEmpty);

      // If input contain at leat 12 characters.
      if (form.regexMatchAtLeastTweleCharacters.test(input.value)) {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.green);
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(errorMessageLength);
      }
      // Else input is empty.
      else {
        // We call form.switchInputOutlineColor() to switch the input outline color.
        form.switchInputOutlineColor(input, form.colors.red);
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(errorMessageLength);
        // We add 1 to form.numberOfErrors.
        form.numberOfErrors++;
      }
    }
    // Else input is empty.
    else {
      // We call form.switchInputOutlineColor() to switch the input outline color.
      form.switchInputOutlineColor(input, form.colors.red);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(errorContactMessageEmpty);
      // We add 1 to form.numberOfErrors.
      form.numberOfErrors++;
    }
  },
  /**
   * Method that, after a click on a modify button, allow the user to acces the form's fields to modify is data.
   * @param {Event} event
   * @return {void}
   */
  handleUserProfileUpdate: function (event) {
    console.log("form.handleUserProfileUpdate()");

    // We get the DOM element form which the event occured.
    const clickedButton = event.currentTarget;

    // If clickedButton is strictly equal to form.modifyMyUserProfileButton.
    if (clickedButton === form.modifyMyUserProfileButton) {
      // We call form.removeDisabledAttribute() to remove the disabled attribute from the elements.
      form.removeDisabledAttribute(form.inputs);
      // We call form.removeDisabledAttribute() to remove the disabled attribute from the elements.
      form.removeDisabledAttribute(form.userCivilityTitleInputs);
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(form.modifyMyUserProfileButton);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(
        form.uploadField,
        form.deleteMyUserPictureLink,
        form.updateMyUserProfileButton,
        // form.deleteMyUserAccountLink,
        form.userCivilityTitleManInput,
        form.userGenderManLabel,
        form.userCivilityTitleWomanInput,
        form.userGenderWomanLabel
      );
    }
    // Else if clickedButton is strictly equal to form.updateUserProfileButton.
    else if (clickedButton === form.updateMyUserProfileButton) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(
        form.modifyMyUserProfileButton,
        form.deleteMyUserPictureLink
        // form.deleteMyUserAccountLink
      );
    }
  },
  /**
   * Method that display only the inputs that are checked.
   * @param {HTMLInputElement} input
   * @param {HTMLLabelElement} label
   * @return {void}
   */
  displayNoneInputNotChecked: function (input, label) {
    console.log("form.displayNoneInputNotChecked()");

    // If the input is not checked.
    if (!input.checked) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(input, label);
    }
    // Else the input is checked.
    else {
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(input, label);
    }
  },
  /**
   * Method that handle the layout of the purchase steps during the purchase process.
   * @param {Event} event
   * @return {void}
   */
  handlePurchaseSteps: function (event) {
    console.log("form.handlePurchaseSteps()");

    // We get the DOM element form which the event occured.
    const clickedElement = event.currentTarget;

    // If clickedElement is strictly equal to one of the compared elements.
    if (
      clickedElement === form.purchaseConfirmAddressesButton ||
      clickedElement === form.addressStep
    ) {
      // We call form.handleAddressesStep() with the value of clickedElement.
      form.handleAddressesStep(clickedElement);
    }
    // Else if clickedElement is strictly equal to one of the compared elements.
    else if (
      clickedElement === form.purchaseConfirmDeliveryModeButton ||
      clickedElement === form.deliveryModeStep
    ) {
      // We call form.handleDeliveryModeStep() with the value of clickedElement.
      form.handleDeliveryModeStep(clickedElement);
    }
    // Else if clickedElement is strictly equal to one of the compared elements.
    else if (
      clickedElement === form.purchaseConfirmButton ||
      clickedElement === form.paymentMethodStep
    ) {
      // We call form.handleCheckoutMethodSteps() with the value of clickedElement.
      form.handleCheckoutMethodSteps(clickedElement);
    }
  },
  /**
   * Method that handle the layout of the addresses step.
   * @param {HTMLElement} clickedElement
   * @return {void}
   */
  handleAddressesStep: function (clickedElement) {
    console.log("form.handleAddressesStep()");

    // If clickedElement is strictly equal to form.purchaseConfirmAddressesButton.
    if (clickedElement === form.purchaseConfirmAddressesButton) {
      // We call form.checkIfInputIsChecked() to check if form.purchaseBillingAddressInputs is checked.
      form.checkIfInputIsChecked(
        form.purchaseBillingAddressInputs,
        form.errorMessagePurchaseBillingAddressNotChecked
      );
      // We call form.checkIfInputIsChecked() to check if form.purchaseDeliveryAddressInputs is checked.
      form.checkIfInputIsChecked(
        form.purchaseDeliveryAddressInputs,
        form.errorMessagePurchaseDeliveryAddressNotChecked
      );
      // If form.numberOfErrors is supperior to 0.
      if (form.numberOfErrors > 0) {
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(
          form.addressStepIconChecked,
          form.purchaseDeliveryModeField,
          form.purchaseConfirmDeliveryModeButton
        );
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(
          form.purchaseBillingAddressField,
          form.purchaseDeliveryAddressField,
          form.purchaseConfirmAddressesButton,
          form.addNewAddressLink
        );
        // We call tools.addClassToElements() to add className to one or several elements.
        tools.addClassToElements(
          "page__title-purchase-step_color_spanish-grey",
          form.deliveryModeStep,
          form.paymentMethodStep
        );
        // We reset form.numberOfErrors for the next submit control.
        form.numberOfErrors = 0;
      }
      // Else we don't count any error.
      else {
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(
          form.addressStepIconChecked,
          form.purchaseDeliveryModeField,
          form.purchaseConfirmDeliveryModeButton
        );
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(
          form.addNewAddressLink,
          form.purchaseBillingAddressField,
          form.purchaseDeliveryAddressField,
          form.purchaseConfirmAddressesButton
        );
        // We call tools.removeClassesFromElement() to remove several classNames from the element.
        tools.removeClassesFromElement(
          form.deliveryModeStep,
          "page__title-purchase-step_color_spanish-grey"
        );
      }
    }
    // Else if clickedElement is strictly equal to form.addressStep.
    else if (clickedElement === form.addressStep) {
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(
        form.addressStepIconChecked,
        form.deliveryModeStepIconChecked,
        form.purchaseDeliveryModeField,
        form.purchaseConfirmDeliveryModeButton,
        form.purchaseCheckoutMethodField,
        form.purchaseTermsOfSaleField,
        form.purchaseConfirmButton
      );
      // We call toold.removeDisplayNone() to remove the display-none class from the elements.
      tools.removeDisplayNone(
        form.addNewAddressLink,
        form.purchaseConfirmAddressesButton,
        form.purchaseBillingAddressField,
        form.purchaseDeliveryAddressField
      );
      // We call tools.addClassToElements() to add className to one or several elements.
      tools.addClassToElements(
        "page__title-purchase-step_color_spanish-grey",
        form.deliveryModeStep,
        form.paymentMethodStep
      );
    }
  },
  /**
   * Method that handle the layout of the delivery mode step.
   * @param {HTMLElement} clickedElement
   * @return {void}
   */
  handleDeliveryModeStep: function (clickedElement) {
    console.log("form.handleDeliveryModeStep()");

    // If clickedElement is strictly equal to form.purchaseConfirmDeliveryModeButton.
    if (clickedElement === form.purchaseConfirmDeliveryModeButton) {
      // We call form.checkIfInputIsChecked() to check if form.purchaseAddressesInputs is checked.
      form.checkIfInputIsChecked(
        form.purchaseDeliveryModeInputs,
        form.errorMessagePurchaseDeliveryModeNotChecked
      );
      // If form.numberOfErrors is supperior to 0.
      if (form.numberOfErrors > 0) {
        // We reset form.numberOfErrors for the next submit control.
        form.numberOfErrors = 0;
      }
      // Else we don't count any error.
      else {
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(
          form.deliveryModeStepIconChecked,
          form.purchaseCheckoutMethodField,
          form.purchaseTermsOfSaleField,
          form.purchaseConfirmButton
          // form.paypalButtonContainer
        );
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(
          form.purchaseDeliveryModeField,
          form.purchaseConfirmDeliveryModeButton
        );
        // We call tools.removeClassesFromElement() to remove several classNames from the element.
        tools.removeClassesFromElement(
          form.paymentMethodStep,
          "page__title-purchase-step_color_spanish-grey"
        );
        // form.displayDeliveryModePriceAndTotal();
      }
    }
    // Else if clickedElement is strictly equal to form.deliveryModeStep.
    else if (clickedElement === form.deliveryModeStep) {
      // If form.addressStepIconChecked contains the display-none class.
      if (form.addressStepIconChecked.classList.contains("display-none")) {
        // We leave form.handleDeliveryModeStep() beause form.purchaseAddressesInputs is not checked.
        return;
      }
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(
        form.deliveryModeStepIconChecked,
        form.purchaseCheckoutMethodField,
        form.purchaseTermsOfSaleField,
        form.purchaseConfirmButton,
        form.purchaseBillingAddressField,
        form.purchaseDeliveryAddressField,
        form.purchaseConfirmAddressesButton
      );
      // We call toold.removeDisplayNone() to remove the display-none class from the elements.
      tools.removeDisplayNone(
        form.purchaseConfirmDeliveryModeButton,
        form.purchaseDeliveryModeField
      );
      // We call tools.addClassToElements() to add className to one or several elements.
      tools.addClassToElements(
        "page__title-purchase-step_color_spanish-grey",
        form.paymentMethodStep
      );
    }
  },
  /**
   * Method that handle the layout of the payment method step.
   * @param {HTMLElement} clickedElement
   * @return {void}
   */
  handleCheckoutMethodSteps: function (clickedElement) {
    console.log("form.handleCheckoutMethodSteps()");

    // If clickedElement is strictly equal to form.purchaseConfirmButton.
    if (clickedElement === form.purchaseConfirmButton) {
      // We call form.checkIfInputIsChecked() to check if form.purchaseAddressesInputs is checked.
      form.checkIfInputIsChecked(
        form.purchaseCheckoutMethodInputs,
        form.errorMessagePurchasePaymentMethodNotChecked
      );
      // We call form.checkIfInputIsChecked() to check if form.termsOfSaleInput is checked.
      form.checkIfInputIsChecked(
        form.termsOfSaleInput,
        form.errorMessageGeneralTermsOfSaleNotChecked
      );
      // We count the number of checked form.purchaseCheckoutMethodInputs.
      for (
        let index = 0;
        index < form.purchaseCheckoutMethodInputs.length;
        index++
      ) {
        // If one of the form.purchaseCheckoutMethodInputs is checked.
        if (form.purchaseCheckoutMethodInputs[index].checked) {
          console.log(form.purchaseCheckoutMethodInputs[index]);

          //! START. Stripe checkout.
          let stripeInput = document.querySelector(".form-field__stripe-input");
          let paypalInput = document.querySelector(".form-field__paypal-input");

          if (
            form.purchaseCheckoutMethodInputs[index].value ===
            stripeInput.dataset.value
          ) {
            console.log(
              stripeInput.dataset.value + " ✅. init Stripe checkout 💳"
            );
          }
          //! END. Stripe checkout

          // TODO #3 START. Make Paypal checkout.
          // The value of the PHP constante Purchase::CHECKOUT_METHOD_PAYPAL in is a HTML dataset attribut whose name is data-value.
          // If the value of the input is identical to the value of this attribut.
          if (
            form.purchaseCheckoutMethodInputs[index].value ===
            paypalInput.dataset.value
          ) {
            // We simulate a click on the Paypal button to init the payment with the Paypal method.
            console.log(paypalInput.dataset.value + ". start Paypal checkout");
            // form.paypalButton.click();
            // return;
          }
          // TODO #3 END. Paypal checkout
        }
      }

      // We call form.submitFormIfNoError() with form.loginForm in argument to check if the form contain some errors and submit him if not.
      form.submitFormIfNoError(form.purchaseForm);
    }
    // Else if clickedElement is strictly equal to form.paymentMethodStep.
    else if (clickedElement === form.paymentMethodStep) {
      // If form.addressStepIconChecked or form.deliveryModeStepIconChecked contain the display-none class.
      if (
        form.addressStepIconChecked.classList.contains("display-none") ||
        form.deliveryModeStepIconChecked.classList.contains("display-none")
      ) {
        // We leave form.handleCheckoutMethodSteps() beause form.purchaseDeliveryModeInputs is not checked.
        return;
      }
    }
  },
  /**
   * Methot that create multiplie HTML elements <div> with the form-check class name before each given inputs and put inside each new element the following pair of input and label.
   * @param {NodeList} inputs
   * @return {void}
   */
  createDivForEachInputAndLabelOfCheckField: function (inputs) {
    console.log("form.createDivForEachInputAndLabelOfCheckField()");

    // We create a empty array for the choice fields.
    let checkFields = [];

    // For each input of inputs.
    for (let input of inputs) {
      // We create a HTML element <div>.
      let field = document.createElement("div");
      // We set a class and a class name to the <div>.
      field.setAttribute("class", "form-check");
      // We insert the <div> before the input.
      input.insertAdjacentElement("beforebegin", field);
      // We push each field to checkFields.
      checkFields.push(field);
    }

    // For each field of checkFields.
    for (let field of checkFields) {
      // We get each input which are the nextElementSibling of each field.
      let input = field.nextElementSibling;
      // We get each label which are the nextElementSibling each field.
      let label = input.nextElementSibling;
      // We add each input in each field.
      field.appendChild(input);
      // We add each label in each field.
      field.appendChild(label);
    }
  },
  /**
   * Methot that create multiplie HTML elements <img> before each label content in the delivery mode field and call form.displayDeliveryModePicture() to display the picture of each created <img>.
   * @return {void}
   */
  createImgTagForDeliveryModePicture: function () {
    console.log("form.createImgTagForDeliveryModePicture()");

    // We get the div in which all the delivery modes fields are store.
    const deliveryModeField =
      document.getElementById("purchase_deliveryMode") ??
      document.getElementById("admin_purchase_deliveryMode");

    // We get the labels content in deliveryModeField.
    const labels = deliveryModeField.getElementsByTagName("label");

    // For each label of labels.
    for (let label of labels) {
      // We create a HTML element <img>.
      let img = document.createElement("img");
      // We set a className to the <img>.
      img.setAttribute("class", "page__delivery-mode-picture");
      // We insert the <img> before the label.
      label.insertAdjacentElement("beforebegin", img);
    }

    // We call form.displayDeliveryModePicture() to display before each delivery mode label the picture related to the delivery mode.
    form.displayDeliveryModePicture();
  },
  /**
   * Methot that display in each delivery mode label the picture related to the delivery mode.
   * @return {void}
   */
  displayDeliveryModePicture: function () {
    console.log("form.displayDeliveryModePictures()");

    // The database value of the picture is in a HTML dataset attribut whose name is data-pictures.
    // We use the JSON.parse() method to convert the string value to a object.
    let deliveryModePictures = JSON.parse(
      form.purchaseDeliveryModeField.dataset.pictures
    );

    // We get all the images by their class name.
    const imgs = document.querySelectorAll(".page__delivery-mode-picture");

    // We initialize a counter which will be the index of each deliveryModePictures.
    let index = 0;

    // For each img of imgs.
    for (let img of imgs) {
      // We set a src attribute with a path to the folder where we backup the picture of each delievery mode and we dynamically add the name of the picture to the path.
      img.setAttribute(
        "src",
        "/" +
          form.purchaseDeliveryModeField.dataset.folderpath +
          "/" +
          deliveryModePictures[index]
      );
      // We incremente our counter to switch to the next delivery mode pictures.
      index++;
    }
  },
  /**
   * Methot that create multiplie HTML elements <img> before each label content in the payment method field and call form.displayPaymentMethodPicture() to display the picture of each created <img> .
   * @return {void}
   */
  createImgTagForPaymentMethodPicture: function () {
    console.log("form.createImgTagForPaymentMethodPicture()");

    // We get the div in which all the payment methodes fields are store.
    const purchaseConfirmPayementMethod = document.getElementById(
      "purchase_checkoutMethod"
    );

    // We get the labels content in purchaseConfirmPayementMethod.
    const labels = purchaseConfirmPayementMethod.getElementsByTagName("label");

    // We create a empty array for the img tags.
    let imgs = [];

    // We create a 3 HTML elements <img>.
    let firstImg = document.createElement("img");
    let secondImg = document.createElement("img");
    let thirdImg = document.createElement("img");
    let fourthImg = document.createElement("img");

    // We set a common and a specific className to each images.
    firstImg.setAttribute(
      "class",
      "page__logo-checkout-method page__logo-american-express"
    );
    secondImg.setAttribute("class", "page__logo-checkout-method page__logo-cb");
    thirdImg.setAttribute(
      "class",
      "page__logo-checkout-method page__logo-mastercard"
    );
    fourthImg.setAttribute(
      "class",
      "page__logo-checkout-method page__logo-visa"
    );

    // We push each img to imgs.
    imgs.push(firstImg, secondImg, thirdImg, fourthImg);

    // For each img of imgs.
    for (let img of imgs) {
      // We insert the <img> after the label.
      labels[0].insertAdjacentElement("afterend", img);
    }

    // We create a fourth img tag for the second field which is the Paypal payment method.
    let fifthImg = document.createElement("img");

    // We set a className to the imgTag.
    fifthImg.setAttribute(
      "class",
      "page__logo-checkout-method page__logo-paypal"
    );

    // We insert fifthImg after the second label.
    labels[1].insertAdjacentElement("afterend", fifthImg);

    // We call form.displayPaymentMethodPicture() to display after each payment method label the picture related to the payment method.
    form.displayPaymentMethodPicture();
  },
  /**
   * Methot that display in each payment method label the picture related to the payment method.
   * @return {void}
   */
  displayPaymentMethodPicture: function () {
    console.log("form.displayPaymentMethodPicture()");

    // We get all the images by their class name.
    const imgs = document.querySelectorAll(".page__logo-checkout-method");

    // The path of the folder where the images of the logos are located.
    const folderPath = "/assets/images/logos/";

    // We set a src attribute with a path to the folder where we backup the pictures of each payment method. We the change the name of the picture we want to dislay according to the input.
    imgs[0].setAttribute("src", folderPath + "visa.svg");
    imgs[1].setAttribute("src", folderPath + "mastercard.svg");
    imgs[2].setAttribute("src", folderPath + "cb.svg");
    imgs[3].setAttribute("src", folderPath + "american-express.png");
    imgs[4].setAttribute("src", folderPath + "paypal.svg");
  },
  /**
   * Method that remove the disabled attribute from the inputs.
   * @param {NodeList} inputs
   * @return {void}
   */
  removeDisabledAttribute: function (inputs) {
    console.log("form.removeDisabledAttribute()");

    // For each input of inputs.
    for (let input of inputs) {
      // We remove the disabled attribute.
      input.removeAttribute("disabled");
    }
  },
  /**
   * Method that check if a form contain some errors and submit him if not.
   * @param {HTMLFormElement} formToSubmit
   * @return {void}
   */
  submitFormIfNoError: function (formToSubmit) {
    console.log("form.submitFormIfNoError()");

    console.log(formToSubmit);

    // If form.numberOfErrors is supperior to 0.
    if (form.numberOfErrors > 0) {
      console.log("Form not submitted ❌");
      console.log("Number of error. " + form.numberOfErrors);
      // We reset form.numberOfErrors for the next submit control.
      form.numberOfErrors = 0;
      // We leave submitFormIfNoError().
      return;
    }
    // Else we don't count any error.
    else {
      // We submit the formToSubmit.
      formToSubmit.submit();
    }
  },
};
