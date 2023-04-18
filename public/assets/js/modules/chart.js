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
    chart.borderColor = form.colors.white;
    chart.datalabelsColor = form.colors.black;
    chart.labelsColor = form.colors.black;
    chart.titleColor = form.colors.black;

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
              backgroundColor: [form.colors.green, form.colors.red],
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
              backgroundColor: [form.colors.green, form.colors.red],
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
