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
    if (responsive.bugerMenu.length > 0) {
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

    return response;
  },
  /**
   *  Method that show or hide some elements according to the window witdh.
   * @return {void}
   */
  applyResponsive: function () {
    // console.log("responsive.applyResponsive()");

    if (responsive.bugerMenu && responsive.menuNavMobile) {
      tools.removeClassesFromElement(responsive.closingButton, "burger-menu");
      tools.addDisplayNone(responsive.closingButton);
      if (responsive.isUserUseMobileDevice()) {
        tools.addDisplayNone(responsive.menuNavMobile);
      } else if (!responsive.isUserUseMobileDevice()) {
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

    // Accoding to clicekButton we display or hide several elements.

    // If the user open the mobile nav.
    if (selectedButton === responsive.openingButton) {
      tools.removeClassesFromElement(responsive.openingButton, "burger-menu");
      tools.addDisplayNone(responsive.openingButton);
      tools.removeDisplayNone(responsive.closingButton);
      tools.addClassesToElement(responsive.closingButton, "burger-menu");
      tools.removeClassesFromElement(responsive.footer, "footer");
      tools.addDisplayNone(responsive.footer);

      if (responsive.menuNavMobile) {
        tools.toggleDisplayNone(responsive.menuNavMobile);

        if (responsive.page) {
          tools.toggleClassToElements("page", responsive.page);
          tools.addDisplayNone(responsive.page);
        }
      }
      // Else if the user close the mobile nav.
    } else if (selectedButton === responsive.closingButton) {
      tools.removeClassesFromElement(responsive.closingButton, "burger-menu");
      tools.addDisplayNone(responsive.closingButton);
      tools.removeDisplayNone(responsive.openingButton);
      tools.addClassesToElement(responsive.openingButton, "burger-menu");
      tools.removeDisplayNone(responsive.footer);
      tools.addClassToElements("footer", responsive.footer);

      if (responsive.menuNavMobile) {
        tools.toggleDisplayNone(responsive.menuNavMobile);

        if (responsive.page) {
          tools.toggleClassToElements("page", responsive.page);
          tools.removeDisplayNone(responsive.page);
        }
      }
    }
  },
};
