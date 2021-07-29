$(document).ready(function () {
  var ctx = document.getElementById("monthly_bar").getContext("2d");
  new Chart(ctx, config(officeReport))
  function config(data){
    return {
      type: 'bar',
          data: {
      labels: data.month,
          datasets: [
        {
          data: data.countProspect,
          backgroundColor: '#45B567',
          label: '見込発生数'
        },
        {
          data: data.countStageUp,
          backgroundColor: '#49A2E3',
          label: 'ステージUP数'
        },
        {
          data: data.countVisit,
          backgroundColor: '#F5BE56',
          label: '査定・訪問数等'
        },
        {
          data: data.countMediation,
          backgroundColor: '#EA7878',
          label: '媒介数'
        }
      ]
    },
      options: {
        responsive: true,
            scales: {
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            stacked: true,
            ticks: {
              fontSize: 14,
              fontColor: "#444",
              fontStyle: "bold",
            },
            barPercentage: 0.7,
          }],
              yAxes: [{
            gridLines: {
              drawBorder: false
            },
            stacked: true,
            ticks: {
              fontSize: 14,
              fontColor: "#444",
              fontStyle: "bold",
            }
          }]
        },
        legend: {
          position: 'bottom',
              labels: {
            boxWidth: 12,
                fontSize: 12,
                fontColor: "#444",
                fontStyle: "bold",
          }
        },
        plugins: {
          datalabels: { // 共通の設定はここ
            display: false
          }
        }
      }
    }
  }
});