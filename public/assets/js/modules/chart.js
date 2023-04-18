const chart = {
  // Proprietes availables in the object.
  statisticsTitle: null,
  fontFamily: null,
  titleFontSize: null,
  legendFontSize: null,
  borderColor: null,
  datalabelsColor: null,
  labelsColor: null,
  titleColor: null,
  // ======================= DOM ELEMENTS =======================
  // User roles
  pieCanvasUserRolesByNumber: null,
  pieChartUserRolesByNumber: {},
  pieCanvaUserRolesByProportion: null,
  pieChartUserRolesByProportion: {},
  // User gender
  pieCanvaUserGenderByNumber: null,
  pieChartUserGenderByNumber: {},
  pieCanvaUserGenderByProportion: null,
  pieChartUserGenderByProportion: {},
  init: function () {
    console.log("Hello world, I'm chart.js 📊");

    chart.fontFamily = "Roboto";
    chart.titleFontSize = 16;
    chart.legendFontSize = 14;

    // If mode.backgroundColor is strictly equal to "dark".
    if (mode.backgroundColor === "dark") {
      //  We set to chart.borderColor the value of font.colors.black.
      chart.borderColor = font.colors.black;
      //  We set to chart.datalabelsColor the value of font.colors.white.
      chart.labelsColor = font.colors.white;
      //  We set to chart.datalabelsColor the value of font.colors.white.
      chart.datalabelsColor = font.colors.white;
      //  We set to chart.titleColor the value of font.colors.white.
      chart.titleColor = font.colors.white;

      // If the font item in localStorage is strictly equal to "knick".
      if (font.color === "knick") {
        //  We set to chart.titleColor the value of font.colors.blue.
        chart.borderColor = font.colors.blue;
      }
      // If the font item in localStorage is strictly equal to "lakers".
      else if (font.color === "lakers") {
        //  We set to chart.titleColor the value of font.colors.purple.
        chart.borderColor = font.colors.purple;
      }
      // If the font item in localStorage is strictly equal to "mario".
      else if (font.color === "mario") {
        //  We set to chart.titleColor the value of font.colors.red.
        chart.borderColor = font.colors.red;
      }
      // If the font item in localStorage is strictly equal to "jamaica".
      else if (font.color === "jamaica") {
        //  We set to chart.titleColor the value of font.colors.slimyGreen.
        chart.borderColor = font.colors.slimyGreen;
      }
      // If the font item in localStorage is strictly equal to "golden-state-warriors".
      else if (font.color === "golden-state-warriors") {
        //  We set to chart.titleColor the value of font.colors.yellow.
        chart.borderColor = font.colors.yellow;
      }
      // If the font item in localStorage is strictly equal to "flash".
      else if (font.color === "flash") {
        //  We set to chart.titleColor the value of font.colors.red.
        chart.borderColor = font.colors.red;
      }
      // If the font item in localStorage is strictly equal to "forest".
      else if (font.color === "forest") {
        //  We set to chart.titleColor the value of font.colors.sepia.
        chart.borderColor = font.colors.sepia;
      }
    }
    // Else if mode.backgroundColor is strictly equal to "light".
    else if (mode.backgroundColor === "light") {
      //  We set to chart.borderColor the value of font.colors.white.
      chart.borderColor = font.colors.white;
      //  We set to chart.datalabelsColor the value of font.colors.black.
      chart.labelsColor = font.colors.black;
      //  We set to chart.datalabelsColor the value of font.colors.black.
      chart.datalabelsColor = font.colors.black;
      //  We set to  chart.titleColor the value of font.colors.black.
      chart.titleColor = font.colors.black;
    }

    // ======================= DOM ELEMENTS =======================

    chart.statisticsTitle = document.querySelector(".page__statistics-title");

    // User roles
    chart.pieCanvasUserRolesByNumber = document.getElementById(
      "pie-canvas-user-roles-by-number"
    );
    // If the DOM element exist.
    if (chart.pieCanvasUserRolesByNumber) {
      // We call chart.createPieChartForUserRolesByNumber() to create the user role pie chart.
      chart.createPieChartForUserRolesByNumber();
    }
    chart.pieCanvaUserRolesByProportion = document.getElementById(
      "pie-canvas-user-roles-by-proportion"
    );
    // If the DOM element exist.
    if (chart.pieCanvaUserRolesByProportion) {
      // We call chart.createPieChartForUserRolesByProportion() to create the user role pie chart.
      chart.createPieChartForUserRolesByProportion();
    }

    // User gender
    chart.pieCanvaUserGenderByNumber = document.getElementById(
      "pie-canvas-user-gender-by-number"
    );
    // If the DOM element exist.
    if (chart.pieCanvaUserGenderByNumber) {
      // We call chart.createPieChartForUserRolesByNumber() to create the user role pie chart.
      chart.createPieChartforUserGenderByNumber();
    }
    chart.pieCanvaUserGenderByProportion = document.getElementById(
      "pie-canvas-user-gender-by-proportion"
    );
    // If the DOM element exist.
    if (chart.pieCanvaUserGenderByProportion) {
      // We call chart.createPieChartForUserGenderByProportion() to create the user role pie chart.
      chart.createPieChartForUserGenderByProportion();
    }
  },
  /**
   * Method that create a pie chart to show the number of users by roles.
   * @return {void}
   */
  createPieChartForUserRolesByNumber: function () {
    // console.log("chart.createPieChartForUserRolesByNumber()");

    // We create a pie chart with the user data that we get from te database.
    chart.pieChartUserRolesByNumber = new Chart(
      chart.pieCanvasUserRolesByNumber,
      {
        type: "pie",
        data: {
          labels: ["Utilisateurs", "Administrateurs"],
          datasets: [
            {
              data: [
                chart.pieCanvasUserRolesByNumber.dataset.users,
                chart.pieCanvasUserRolesByNumber.dataset.admins,
              ],
              backgroundColor: [font.colors.green, font.colors.red],
              borderColor: chart.borderColor,
              hoverOffset: 8,
            },
          ],
        },
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            tooltip: {
              enabled: false,
            },
            datalabels: {
              color: chart.datalabelsColor,
              formatter: function (value, context) {
                // // By default ChartJS display the data in the chart.
                // return context.chart.data.datasets[0].data[context.dataIndex];
                // // Display the each labels in the chart.
                // return context.chart.data.labels[context.dataIndex];
              },
            },
            title: {
              display: true,
              text: "Nombre d'Utilisateurs et d'Administrateurs",
              color: chart.titleColor,
              position: "bottom",
              font: {
                family: chart.fontFamily,
                weight: "normal",
                size: chart.titleFontSize,
              },
            },
            legend: {
              position: "bottom",
              labels: {
                color: chart.labelsColor,
                font: {
                  family: chart.fontFamily,
                  weight: "normal",
                  size: chart.legendFontSize,
                },
              },
            },
          },
        },
      }
    );
  },
  /**
   * Method that create a pie chart to show the proportion of users by roles.
   * @return {void}
   */
  createPieChartForUserRolesByProportion: function () {
    // console.log("chart.createPieChartForUserRolesByProportion()");

    // We create a pie chart with the user data that we get from te database.
    chart.pieChartUserRolesByProportion = new Chart(
      chart.pieCanvaUserRolesByProportion,
      {
        type: "pie",
        data: {
          labels: ["Utilisateurs", "Administrateurs"],
          datasets: [
            {
              data: [
                chart.pieCanvaUserRolesByProportion.dataset.users,
                chart.pieCanvaUserRolesByProportion.dataset.admins,
              ],
              backgroundColor: [font.colors.green, font.colors.red],
              borderColor: chart.borderColor,
              hoverOffset: 8,
            },
          ],
        },
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            tooltip: {
              enabled: false,
            },
            datalabels: {
              color: chart.datalabelsColor,
              formatter: function (value, context) {
                return (
                  Math.round(
                    (value * 100) /
                      chart.pieCanvaUserRolesByProportion.dataset.numberofusers
                  ) + "%"
                );
              },
            },
            title: {
              display: true,
              text: "Proportion d'Utilisateurs et d'Administrateurs",
              color: chart.titleColor,
              position: "bottom",
              font: {
                family: chart.fontFamily,
                weight: "normal",
                size: chart.titleFontSize,
              },
            },
            legend: {
              position: "bottom",
              labels: {
                color: chart.labelsColor,
                font: {
                  family: chart.fontFamily,
                  weight: "normal",
                  size: chart.legendFontSize,
                },
              },
            },
          },
        },
      }
    );
  },
  /**
   * Method that create a pie chart to show the number of users by gender.
   * @return {void}
   */
  createPieChartforUserGenderByNumber: function () {
    // console.log("chart.createPieChartforUserGenderByNumber()");

    // We create a pie chart with the user data that we get from te database.
    chart.pieChartUserGenderByNumber = new Chart(
      chart.pieCanvaUserGenderByNumber,
      {
        type: "pie",
        data: {
          labels: ["Hommes", "Femmes"],
          datasets: [
            {
              data: [
                chart.pieCanvaUserGenderByNumber.dataset.numberofmans,
                chart.pieCanvaUserGenderByNumber.dataset.numberofwomans,
              ],
              //   backgroundColor: ["#66b5fa", "#ff00ff"],
              backgroundColor: ["#66b5fa", "#D96DA0"],
              borderColor: chart.borderColor,
              hoverOffset: 8,
            },
          ],
        },
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            tooltip: {
              enabled: false,
            },
            datalabels: {
              color: chart.datalabelsColor,
            },
            title: {
              display: true,
              text: "Nombre d'Hommes et de Femmes",
              color: chart.titleColor,
              position: "bottom",
              font: {
                family: chart.fontFamily,
                weight: "normal",
                size: chart.titleFontSize,
              },
            },
            legend: {
              position: "bottom",
              labels: {
                color: chart.labelsColor,
                font: {
                  family: chart.fontFamily,
                  weight: "normal",
                  size: chart.legendFontSize,
                },
              },
            },
          },
        },
      }
    );
  },
  /**
   * Method that create a pie chart to show the proportion of users by gender.
   * @return {void}
   */
  createPieChartForUserGenderByProportion: function () {
    // console.log("chart.createPieChartForUserGenderByProportion()");

    // We create a pie chart with the user data that we get from te database.
    chart.pieChartUserGenderByProportion = new Chart(
      chart.pieCanvaUserGenderByProportion,
      {
        type: "pie",
        data: {
          labels: ["Hommes", "Femmes"],
          datasets: [
            {
              data: [
                chart.pieCanvaUserGenderByProportion.dataset.numberofmans,
                chart.pieCanvaUserGenderByProportion.dataset.numberofwomans,
              ],
              //   backgroundColor: ["#66b5fa", "#ff00ff"],
              backgroundColor: ["#66b5fa", "#D96DA0"],
              borderColor: chart.borderColor,
              hoverOffset: 8,
            },
          ],
        },
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            tooltip: {
              enabled: false,
            },
            datalabels: {
              color: chart.datalabelsColor,
              formatter: function (value, context) {
                return (
                  Math.round(
                    (value * 100) /
                      chart.pieCanvaUserGenderByProportion.dataset.numberofusers
                  ) + "%"
                );
              },
            },
            title: {
              display: true,
              text: "Proportion d'Hommes et de Femmes",
              color: chart.titleColor,
              position: "bottom",
              font: {
                family: chart.fontFamily,
                weight: "normal",
                size: chart.titleFontSize,
              },
            },
            legend: {
              position: "bottom",
              labels: {
                color: chart.labelsColor,
                font: {
                  family: chart.fontFamily,
                  weight: "normal",
                  size: chart.legendFontSize,
                },
              },
            },
          },
        },
      }
    );
  },
};
