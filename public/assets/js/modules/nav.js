const nav = {
  links: [],
  init: function () {
    console.log("Hello world, I'm nav.js 🗺");

    nav.links = document.querySelectorAll(".nav__link");

    // We set a index to 0 wich will be inferior to the length off the nav.links and we increment the index in order to switch to the next nav.links.
    for (let index = 0; index < nav.links.length; index++) {
      // If the current nav.links is strictly equal to the current URL.
      if (nav.links[index].href === location.href) {
        tools.addClassToElements("active", nav.links[index]);
      }
    }
  },
};
