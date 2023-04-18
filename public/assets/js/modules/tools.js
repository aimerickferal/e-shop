const tools = {
  init: function () {
    console.log("Hello world, I'm tools.js 🧰");
  },
  /**
   * Method that add the display-none CSS classes to one or several elements.
   * @param {HTMLElement} element
   * @return {void}
   */
  addDisplayNone: function (...elements) {
    // console.log("tools.addDisplayNone()");

    // For each element of elements.
    for (let element of elements) {
      // We use the classList API to add the display-none class to element.
      element.classList.add("display-none");
    }
  },
  /**
   * Method that remove the display-none CSS class from one or several elements to display it.
   * @param {Array} element
   * @return {void}
   */
  removeDisplayNone: function (...elements) {
    // console.log("tools.removeDisplayNone()");

    // For each element of elements.
    for (let element of elements) {
      // We use the classList API to remove the display-none class from element.
      element.classList.remove("display-none");
    }
  },
  /**
   * Method that toggle the display-none CSS class to one or several elements to display it.
   * @param {Array} element
   * @return {void}
   */
  toggleDisplayNone: function (...elements) {
    // console.log("tools.toggleDisplayNone()");

    // For each element of elements.
    for (let element of elements) {
      // We use the classList API to toggle the display-none class to element.
      element.classList.toggle("display-none");
    }
  },
  /**
   * Method that add a CSS class to one or several elements.
   * @param {String} className
   * @param {Array} elements
   * @return {void}
   */
  addClassToElements: function (className, ...elements) {
    // console.log("tools.addClassToElements()");

    // For each element of elements.
    for (let element of elements) {
      // We use the classList API to add className to element.
      element.classList.add(className);
    }
  },
  /**
   * Method that remove a CSS class from one or several elements.
   * @param {String} className
   * @param {Array} elements
   * @return {void}
   */
  removeClassFromElements: function (className, ...elements) {
    // console.log("tools.removeClassFromElements()");

    // For each element of elements.
    for (let element of elements) {
      // We use the classList API to remove className from element.
      element.classList.remove(className);
    }
  },
  /**
   * Method that toggle a CSS class to one or several elements.
   * @param {String} className
   * @param {Array} elements
   * @return {void}
   */
  toggleClassToElements: function (className, ...elements) {
    // console.log("tools.toggleClassToElements()");

    // For each element of elements.
    for (let element of elements) {
      // We use the classList API to toggle className to element.
      element.classList.toggle(className);
    }
  },
  /**
   * Method that add one or several CSS classes to one element.
   * @param {Array} element
   * @param {String} classNames
   * @return {void}
   */
  addClassesToElement: function (element, ...classNames) {
    // console.log("tools.addClassesToElement()");

    // For each className of classNames.
    for (let className of classNames) {
      // We use the classList API to add className to element.
      element.classList.add(className);
    }
  },
  /**
   * Method that remove one or several CSS classes from one element.
   * @param {Array} element
   * @param {String} classNames
   * @return {void}
   */
  removeClassesFromElement: function (element, ...classNames) {
    // console.log("tools.removeClassesFromElement()");

    // For each className of classNames.
    for (let className of classNames) {
      // We use the classList API to remove className from element.
      element.classList.remove(className);
      // console.log(className.length + " " + className);
    }
  },
  /**
   * Method that toggle one or several CSS classes to one element.
   * @param {Array} element
   * @param {String} classNames
   * @return {void}
   */
  toggleClassesToElement: function (element, ...classNames) {
    // console.log("tools.toggleClassesToElement()");

    // For each className of classNames.
    for (let className of classNames) {
      // We use the classList API to toggle className to element.
      element.classList.toggle(className);
    }
  },
  /**
   * Method that remove a disabled attribute from one or several inputs.
   * @param {Array} inputs
   * @return {void}
   */
  removeDisabledAttribute: function (...inputs) {
    // console.log("tools.removeDisabledAttribute()");

    // For each input of form.inputs.
    for (let input of inputs) {
      // We remove the disabled attribute.
      input.removeAttribute("disabled");
    }
  },
  /**
   * Method that set a disabled attribute to one or several inputs.
   * @param {Array} inputs
   * @return {void}
   */
  setDisabledAttribute: function (...inputs) {
    // console.log("tools.setDisabledAttribute()");

    // For each input of form.inputs.
    for (let input of inputs) {
      // We remove the disabled attribute.
      input.setAttribute("disabled", "");
    }
  },
  /**
   * Method that check one or several inputs.
   * @param {Array} inputs
   * @return {void}
   */
  checkInputs: function (...inputs) {
    // console.log("tools.checkInputs()");

    // For each input of inputs.
    for (let input of inputs) {
      // We check the input.
      input.checked = true;
    }
  },
  /**
   * Method that uncheck one or several inputs.
   * @param {Array} inputs
   * @return {void}
   */
  uncheckInputs: function (...inputs) {
    // console.log("tools.uncheckInputs()");

    // For each input of inputs.
    for (let input of inputs) {
      // We uncheck the input.
      input.checked = false;
    }
  },
  /**
   * Methot that set on a element a new color for the before property.
   * @param {HTMLSpanElement} element
   * @param {String} color
   * @return {void}
   */
  setColorToBeforeProperty: function (element, color) {
    // console.log("tools.setColorToBeforeProperty()");

    // We set the property of the CSS variable.
    element.style.setProperty("--before", color);
  },
  /**
   * Methot that remove one or several elements from the DOM.
   * @param {Array} elements
   * @return {void}
   */
  removeElementsFromDOM: function (...elements) {
    // console.log("tools.removeElementsFromDOM()");

    // For each element of elements.
    for (let element of elements) {
      // We use the JS method remove() to remove the element from the DOM.
      element.remove();
    }
  },
  /**
   * Method that from a integer which is a price in cents return string which is a amount with the symbol of the currency initialize in parameter.
   * @param {Number} centsPrice
   * @param {String} currencySymbol
   * @return {String}
   */
  toAmount: function (centsPrice, currencySymbol = "€") {
    // console.log("tools.toAmount()");

    // We convert the cents price to a decimal price.
    let decimalPrice = centsPrice / 100;

    // We use the toString methot to convert the integer in a string and the replace method to replace the comma by a dot.
    let amount = decimalPrice.toString().replace(".", ",");

    // We return the amount with the symbol of the currency.
    return amount + " " + currencySymbol;
  },
  /**
   * Method that return a formated date according to the chosen format.
   * @param {String} date
   * @return {String}
   */
  formatDateTime: function (date) {
    // console.log("tools.formatDateTime()");

    // console.log(date);
    // date is a string like for exemple. 2022-06-19T09:04:28+00:00

    // A string is like a array so we can extract some strings of it.
    // We extract the year.
    let year = date[0] + date[1] + date[2] + date[3];
    // We extract the mounth.
    let mounth = date[5] + date[6];
    // We extract the date.
    let day = date[8] + date[9];

    // We return the date with the format dd/mm/yyyy.
    return day + "/" + mounth + "/" + year;
  },
};
