const app = {
  url: null,
  init: function () {
    console.log("Hello world, I'm app.js 👑");

    // The URL of the app.
    app.url = "http://localhost:8080/";

    // We load the module tools.js.
    tools.init();

    // We load the module responsive.js.
    responsive.init();

    // We load the module nav.js.
    nav.init();

    // We load the module mode.js.
    mode.init();

    // We load the module form.js.
    form.init();

    // We load the module delete.js.
    confirmDelete.init();

    // We load the module font.js.
    font.init();

    // We load the module puchase.js.
    purchase.init();

    // We load the module chart.js.
    chart.init();

    // We load the module customerService.js.
    customerService.init();
  },
};

document.addEventListener("DOMContentLoaded", app.init);
