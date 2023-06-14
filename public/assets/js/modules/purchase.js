const purchase = {
  subtotalParagraph: null,
  subtotal: null,
  deliveryModePriceParagraph: null,
  deliveryModeAmountFree: null,
  deliveryModeByDefaultPrice: null,
  deliveryModeByDefaultAmount: null,
  totalParagraph: null,
  total: null,
  init: function () {
    console.log("Hello world, I'm purchase.js 🛒");

    // We get the paragraph where the data of the subtotal is gonna be display.
    purchase.subtotalParagraph = document.getElementById(
      "purchase-subtotal-paragraph"
    );
    if (purchase.subtotalParagraph) {
      // The value in cents of the subtotal is in a HTML dataset attribut whose name is data-purchasesubtotal.
      // We use the parseFloat() function to convert the string value to a floating point number.
      purchase.subtotal = parseFloat(
        purchase.subtotalParagraph.dataset.purchasesubtotal
      );
    }

    // We get the paragraph where the data of the delivery price is gonna be display.
    purchase.deliveryModePriceParagraph = document.getElementById(
      "purchase-delivery-mode-price-paragraph"
    );
    if (purchase.deliveryModePriceParagraph) {
      // The value in decimal of the PHP constante DeliveryMode::DELIVERY_PRICE_FREE is in a HTML dataset attribut whose name is data-deliveryamountfree.
      purchase.deliveryModeAmountFree =
        purchase.deliveryModePriceParagraph.dataset.deliveryamountfree;
      // The value in cents of the delivery mode price by default is in a HTML dataset attribut whose name is data-deliverymodebydefaultprice.
      // We use the parseFloat() function to convert the string value to a floating point number.
      purchase.deliveryModeByDefaultPrice = parseFloat(
        purchase.deliveryModePriceParagraph.dataset.deliverymodebydefaultprice
      );
      // The value in decimal of the delivery mode price by default is in a HTML dataset attribut whose name is data-deliverymodebydefaultamount.
      purchase.deliveryModeByDefaultAmount =
        purchase.deliveryModePriceParagraph.dataset.deliverymodebydefaultamount;
      // We use the innerText property of purchase.deliveryModePriceParagraph to display purchase.deliveryModeByDefaultAmount.
      purchase.deliveryModePriceParagraph.innerText = `${purchase.deliveryModeByDefaultAmount}`;
    }

    // We get the paragraph where the data of the total is gonna be display.
    purchase.totalParagraph = document.getElementById(
      "purchase-total-paragraph"
    );
    if (purchase.totalParagraph) {
      // The total is egual to the subtotal add tp the price by default of the delivey mode.
      purchase.total = purchase.subtotal + purchase.deliveryModeByDefaultPrice;
      // We use the innerText property of purchase.totalParagraph to display the data returned by tools.toAmount() that we call with purchase.total in argument.
      purchase.totalParagraph.innerText = `${tools.toAmount(purchase.total)}`;
    }
  },
  /**
   * Methot that get the clickedInput from the input event, display the delivery mode price realated to the clickedInput from the HTML dataset attribut, set and display in decimal the new value of purchase.total.
   * @param {Event} event
   * @return {void}
   */
  handleDeliveryModeInputs: function (event) {
    console.log("purchase.handleDeliveryModeInputs()");

    // We get the DOM element from which the event occured.
    let clickedInput = event.currentTarget;
    // We use the innerText property of purchase.deliveryModePriceParagraph to display the data of the HTML dataset attribute whose name is data-deliverymodeamount.
    purchase.deliveryModePriceParagraph.innerText = `${clickedInput.dataset.deliverymodeamount}`;

    // We use the parseFloat() function to convert the string value of the HTML dataset attribute whose name is data-deliverymodeprice to a integer.
    // purchase.total have for value purchase.subtotal add to the value returned the parseFloat() methot.
    purchase.total =
      purchase.subtotal + parseFloat(clickedInput.dataset.deliverymodeprice);
    // We use the innerText property of purchase.totalParagraph to display the data returned by tools.toAmount() that we call with purchase.total in argument.
    purchase.totalParagraph.innerText = `${tools.toAmount(purchase.total)}`;

    // We use the parseFloat() function to convert the string value of the HTML dataset attribute whose name is data-mincartamountforfreedelivery to a integer.
    // If the subtotal (the price total of the cart) is superior or equal this value.
    if (
      purchase.subtotal >=
      parseFloat(clickedInput.dataset.mincartamountforfreedelivery)
    ) {
      purchase.deliveryModePriceParagraph.innerText = `${purchase.deliveryModeAmountFree}`;
      // Since the delivery mode amount is purchase.deliveryModeAmountFree we don't add a delivery mode price to the total.
      purchase.total = purchase.subtotal;
      // We use the innerText property of purchase.totalParagraph to display the data returned by tools.toAmount() that we call with purchase.total in argument.
      purchase.totalParagraph.innerText = `${tools.toAmount(purchase.total)}`;
    }
  },
};
