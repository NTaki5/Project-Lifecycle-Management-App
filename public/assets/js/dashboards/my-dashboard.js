document.addEventListener("DOMContentLoaded", function () {
    // -----------------------------------------------------------------------
  // Total Projects
  // -----------------------------------------------------------------------
  if(document.querySelector("#total-projects")){
    
    var options_line = {
      series: [
        {
          name: "Java",
          data: [10, 4, 3, 5, 9, 2, 6, 9, 12],
        },
        {
          name: "Angular",
          data: [15, 2, 5, 2, 7, 6, 9, 1, 10],
        },
      ],
      chart: {
        height: '500px',
        type: "line",
        fontFamily: "inherit",
        zoom: {
          enabled: false,
        },
        offsetX: -10,
        toolbar: {
          show: false,
        },
      },
      dataLabels: {
        enabled: false,
      },
      colors: ["var(--bs-primary)", "var(--bs-secondary)"],
      stroke: {
        curve: "straight",
      },
      grid: {
        row: {
          colors: ["transparent"], // takes an array which will be repeated on columns
          opacity: 0.5,
        },
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0,
        },
        borderColor: "transparent",
      },
      xaxis: {
        categories: [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
        ],
        labels: {
          style: {
            colors: "#a1aab2",
          },
        },
      },
      yaxis: {
        labels: {
          style: {
            colors: "#a1aab2",
          },
        },
      },
      tooltip: {
        theme: "dark",
      },
    };
  
    var chart_line_basic = new ApexCharts(
      document.querySelector("#total-projects"),
      options_line
    );
    chart_line_basic.render();

}
});
