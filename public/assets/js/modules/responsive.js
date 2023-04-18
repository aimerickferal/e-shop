const responsive = {
  // Proprietes availables in the object.
  window320Px: null,
  window768Px: null,
  window992Px: null,
  // ======================= DOM ELEMENTS =======================
  header: null,
  bugerMenu: [],
  openingButton: null,
  closingButton: null,
  menuNavMobile: null,
  footer: null,
  page: null,
  init: function () {
    console.log("Hello world, I'm responsive.js 📱🖥️");

    // The range of screen sizes.
    responsive.window320Px = 320;
    responsive.window768Px = 768;
    responsive.window992Px = 992;

    // ======================= DOM ELEMENTS =======================

    responsive.header = document.querySelector(".header");
    responsive.bugerMenu = document.querySelectorAll(".burger-menu");
    // If the length of the DOM elements is superior to 0 that mean the elements are display on the current page.
    if (responsive.bugerMenu.length > 0) {
      // For each button of responsive.bugerMenu.
      for (let button of responsive.bugerMenu) {
        // We add a listener and a handler on the click event.
        button.addEventListener("click", responsive.handleSelectedNavButton);
      }
    }
    responsive.openingButton = document.getElementById("opening-button");
    responsive.closingButton = document.getElementById("closing-button");
    responsive.menuNavMobile = document.querySelector(".nav-mobile");
    responsive.footer = document.querySelector(".footer");
    responsive.page = document.querySelector(".page");

    // When the app is loaded we call responsive.applyResponsive() to add or remove some CSS classes to the elements.
    responsive.applyResponsive();
  },
  /**
   * Method that check if a user use a mobile or a desktop according to the window.innerWidth property.
   * @return {boolean}
   */
  isUserUseMobileDevice: function () {
    // console.log("responsive.response()");

    // We initialize the variable that will be returned.
    let response = null;

    // If the window size is higher or equal to 320px and inferior to 992px the user use a mobile.
    if (
      window.innerWidth >= responsive.window320Px &&
      window.innerWidth < responsive.window992Px
    ) {
      // We return true because the user use a mobile.
      response = true;
    }
    // Else if the window size is higher or equal to 992px.
    else if (window.innerWidth >= responsive.window992Px) {
      // We return false because the user don't use a mobile but a desktop.
      response = false;
    }

    // We return response;
    return response;
  },
  /**
   *  Method that show or hide some elements according to the window witdh.
   * @return {void}
   */
  applyResponsive: function () {
    // console.log("responsive.applyResponsive()");

    // If the DOM elements exist.
    if (responsive.bugerMenu && responsive.menuNavMobile) {
      // We call tools.removeClassesFromElement() to remove one or several classNames from the element.
      tools.removeClassesFromElement(responsive.closingButton, "burger-menu");
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(responsive.closingButton);
      // If the user use a mobile.
      if (responsive.isUserUseMobileDevice()) {
        // We call tools.addDisplayNone() to add the display-none class to one or several elements.
        tools.addDisplayNone(responsive.menuNavMobile);
      }
      // Else if the user don't use a mobile but a desktop.
      else if (!responsive.isUserUseMobileDevice()) {
        // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
        tools.removeDisplayNone(responsive.menuNavMobile);
      }
    }
  },
  /**
   * Method that get the DOM element on witch we click and call the right method according to the clicked element.
   * @param {Event} event
   * @return {void}
   */
  handleSelectedNavButton: function (event) {
    // console.log("responsive.handleSelectedNavButton()");

    // We get the DOM element form which the event occured.
    let selectedButton = event.currentTarget;

    // If selectedButton is strictly equal to responsive.openingButton.
    if (selectedButton === responsive.openingButton) {
      // We call tools.removeClassesFromElement() to remove one or several classNames from the element.
      tools.removeClassesFromElement(responsive.openingButton, "burger-menu");
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(responsive.openingButton);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(responsive.closingButton);
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(responsive.closingButton, "burger-menu");
      // We call tools.removeClassesFromElement() to remove one or several classNames from the element.
      tools.removeClassesFromElement(responsive.footer, "footer");
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(responsive.footer);

      // If the DOM element exist.
      if (responsive.menuNavMobile) {
        // We call tools.toggleClassToElements() in order to toggle a className to one or several elements.
        tools.toggleDisplayNone(responsive.menuNavMobile);

        // If the DOM element exist.
        if (responsive.page) {
          // We call tools.toggleClassToElements() in order to toggle a className to one or several elements.
          tools.toggleClassToElements("page", responsive.page);
          // We call tools.addDisplayNone() to add the display-none class to one or several elements.
          tools.addDisplayNone(responsive.page);
        }
      }
    }
    // Else if selectedButton is strictly equal to responsive.closingButton.
    else if (selectedButton === responsive.closingButton) {
      // We call tools.removeClassesFromElement() to remove one or several classNames from the element.
      tools.removeClassesFromElement(responsive.closingButton, "burger-menu");
      // We call tools.addDisplayNone() to add the display-none class to one or several elements.
      tools.addDisplayNone(responsive.closingButton);
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(responsive.openingButton);
      // We call tools.addClassesToElement() to add one or several classNames to the element.
      tools.addClassesToElement(responsive.openingButton, "burger-menu");
      // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
      tools.removeDisplayNone(responsive.footer);
      // We call tools.addClassToElements() to add className to the element.
      tools.addClassToElements("footer", responsive.footer);

      // If the DOM element exist.
      if (responsive.menuNavMobile) {
        // We call tools.toggleClassToElements() in order to toggle a className to one or several elements.
        tools.toggleDisplayNone(responsive.menuNavMobile);

        // If the DOM element exist.
        if (responsive.page) {
          // We call tools.toggleClassToElements() in order to toggle a className to one or several elements.
          tools.toggleClassToElements("page", responsive.page);
          // We call tools.removeDisplayNone() to remove the display-none class from one or several elements.
          tools.removeDisplayNone(responsive.page);
        }
      }
    }
  },
};
