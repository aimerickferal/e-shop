const chart = {
  // Proprietes availables in the object.
  fontFamily: null,
  titleFontSize: null,
  legendFontSize: null,
  borderColor: null,
  datalabelsColor: null,
  labelsColor: null,
  titleColor: null,
  // ======================= DOM ELEMENTS =======================
  statisticsTitle: null,
  // User's roles
  pieCanvasUserRolesByNumber: null,
  pieChartUserRolesByNumber: {},
  pieCanvaUserRolesByProportion: null,
  pieChartUserRolesByProportion: {},
  // User's civility title
  pieCanvaUserCivilityTitleByNumber: null,
  pieChartUserGenderByNumber: {},
  pieCanvaUserCivilityTitleByProportion: null,
  pieChartUserGenderByProportion: {},
  init: function () {
    console.log("Hello world, I'm chart.js 📊");

    // All the colors of the app are set in CSS variables.
    // We use getComputedStyle(document.documentElement).getPropertyValue() to get the value of the CSS variables.
    chart.colors = {
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

    chart.fontFamily = "Roboto";
    chart.titleFontSize = 16;
    chart.legendFontSize = 14;
    chart.borderColor = chart.colors.white;
    chart.datalabelsColor = chart.colors.black;
    chart.labelsColor = chart.colors.black;
    chart.titleColor = chart.colors.black;

    // ======================= DOM ELEMENTS =======================

    chart.statisticsTitle = document.querySelector(".page__statistics-title");

    // User roles
    chart.pieCanvasUserRolesByNumber = document.getElementById(
      "pie-canvas-user-roles-by-number"
    );
    if (chart.pieCanvasUserRolesByNumber) {
      chart.createPieChartForUserRolesByNumber();
    }
    chart.pieCanvaUserRolesByProportion = document.getElementById(
      "pie-canvas-user-roles-by-proportion"
    );
    if (chart.pieCanvaUserRolesByProportion) {
      chart.createPieChartForUserRolesByProportion();
    }

    // User civility title
    chart.pieCanvaUserCivilityTitleByNumber = document.getElementById(
      "pie-canvas-user-civility-title-by-number"
    );
    if (chart.pieCanvaUserCivilityTitleByNumber) {
      chart.createPieChartforUserCivilityTitleByNumber();
    }
    chart.pieCanvaUserCivilityTitleByProportion = document.getElementById(
      "pie-canvas-user-civility-title-by-proportion"
    );
    if (chart.pieCanvaUserCivilityTitleByProportion) {
      chart.createPieChartForUserCivilitTitlerByProportion();
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
              backgroundColor: [chart.colors.green, chart.colors.red],
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
              backgroundColor: [chart.colors.green, chart.colors.red],
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
  createPieChartforUserCivilityTitleByNumber: function () {
    // console.log("chart.createPieChartforUserCivilityTitleByNumber()");

    // We create a pie chart with the user data that we get from te database.
    chart.pieChartUserGenderByNumber = new Chart(
      chart.pieCanvaUserCivilityTitleByNumber,
      {
        type: "pie",
        data: {
          labels: ["Hommes", "Femmes"],
          datasets: [
            {
              data: [
                chart.pieCanvaUserCivilityTitleByNumber.dataset.numberofmans,
                chart.pieCanvaUserCivilityTitleByNumber.dataset.numberofwomans,
              ],
              backgroundColor: [
                chart.colors.argentinianBlue,
                chart.colors.thulianPink,
              ],
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
  createPieChartForUserCivilitTitlerByProportion: function () {
    // console.log("chart.createPieChartForUserCivilitTitlerByProportion()");

    // We create a pie chart with the user data that we get from te database.
    chart.pieChartUserGenderByProportion = new Chart(
      chart.pieCanvaUserCivilityTitleByProportion,
      {
        type: "pie",
        data: {
          labels: ["Hommes", "Femmes"],
          datasets: [
            {
              data: [
                chart.pieCanvaUserCivilityTitleByProportion.dataset
                  .numberofmans,
                chart.pieCanvaUserCivilityTitleByProportion.dataset
                  .numberofwomans,
              ],
              backgroundColor: [
                chart.colors.argentinianBlue,
                chart.colors.thulianPink,
              ],
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
                      chart.pieCanvaUserCivilityTitleByProportion.dataset
                        .numberofusers
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
