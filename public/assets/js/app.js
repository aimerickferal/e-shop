const app = {
  url: null,
  init: function () {
    console.log("Hello world, I'm app.js 👑");

    // The URL of the app.
    app.url = "http://localhost:8080/";

    // All the colors of the app are set in CSS variables.
    // We use getComputedStyle(document.documentElement).getPropertyValue() to get the value of the CSS variables.
    app.colors = {
      black: getComputedStyle(document.documentElement).getPropertyValue(
        "--black"
      ),
      white: getComputedStyle(document.documentElement).getPropertyValue(
        "--white"
      ),
      red: getComputedStyle(document.documentElement).getPropertyValue("--red"),
      green: getComputedStyle(document.documentElement).getPropertyValue(
        "--green"
      ),
      yellow: getComputedStyle(document.documentElement).getPropertyValue(
        "--yellow"
      ),
      blue: getComputedStyle(document.documentElement).getPropertyValue(
        "--blue"
      ),
      orange: getComputedStyle(document.documentElement).getPropertyValue(
        "--orange"
      ),
      argentinianBlue: getComputedStyle(
        document.documentElement
      ).getPropertyValue("--argentinian-blue"),
      thulianPink: getComputedStyle(document.documentElement).getPropertyValue(
        "--thulian-pink"
      ),
    };

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
