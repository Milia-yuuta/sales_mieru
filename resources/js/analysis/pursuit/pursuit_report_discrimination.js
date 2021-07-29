$(document).ready(function () {
  var ctx = document.getElementById('pursuit_stock_discrimination').getContext("2d");
  ctx.canvas.width = 600;
  new Chart(ctx, config(analysisData));

  function config(analysisData){
    return {
      type: 'bar',
          data: {
      labels: analysisData.graph.discrimination.user_name,
          datasets: [{
        label: '月初ストック数',
        borderWidth:1,
        backgroundColor: '#FEFEFE',
        borderColor: '#3B96DD',
        data: analysisData.graph.discrimination.StartMonthStockCount,
      },
        {
          label: '月内新規発生数',
          borderWidth:1,
          backgroundColor: '#3B96DD',
          borderColor: '#3B96DD',
          data: analysisData.graph.discrimination.ToMonthNewCount,
        }]
    },
      options: {
        scales: {
          xAxes: [{
            stacked: true, //積み上げ棒グラフにする設定
            categoryPercentage: 0.8, //棒グラフの太さ
            display: true,
            gridLines: {
              display: false,
            },
            ticks: {
              callback:  label => [...label],
              fontStyle: 'bold',
              fontColor: '#000',
              fontSize: 10,
            }
          }],
              yAxes: [{
            gridLines: {
              drawBorder: false,
              color: '#CFDCEA'
            },
            stacked: true,
            ticks: {
              fontStyle: 'bold',
              fontColor: '#000',
              min: 0,
              userCallback: function(label, index, labels) {
                if (Math.floor(label) === label) {
                  return label;
                }
              }
            }
          }]
        },
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        plugins: {
          datalabels: { // 共通の設定はここ
            display: false
          }
        },
      }
    }
  }
});