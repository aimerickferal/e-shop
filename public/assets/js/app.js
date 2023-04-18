const app = {
  url: null,
  init: function () {
    console.log("Hello world, I'm app.js 👑");

    // The URL of the app.
    app.url = "http://localhost:8080/";

    // We load the modules used in the app.
    tools.init();
    responsive.init();
    nav.init();
    form.init();
    confirmDelete.init();
    purchase.init();
    chart.init();
    customerService.init();
  },
};

document.addEventListener("DOMContentLoaded", app.init);
