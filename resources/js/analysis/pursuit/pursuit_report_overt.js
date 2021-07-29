$(document).ready(function () {
  var ctx = document.getElementById('pursuit_stock_overt').getContext("2d");
  ctx.canvas.width = 400;
  new Chart(ctx, config(analysisData));

  function config(analysisData){
    return {
      type: 'bar',
          data: {
      labels: analysisData.graph.overt.user_name,
          datasets: [{
        label: '月初ストック数',
        borderWidth:1,
        backgroundColor: '#FEFEFE',
        borderColor: '#F1A372',
        data: analysisData.graph.overt.StartMonthStockCount,
      },
        {
          label: '月内新規発生数',
          borderWidth:1,
          backgroundColor: '#F1A372',
          borderColor: '#F1A372',
          data: analysisData.graph.overt.ToMonthNewCount,
        }]
    },
      options: {
        scales: {
          xAxes: [{
            stacked: true, //積み上げ棒グラフにする設定
            categoryPercentage:0.8, //棒グラフの太さ
            display: true,
            gridLines: {
              display: false
            },
            ticks: {
              fontStyle: 'bold',
              fontColor: '#000',
              callback:  label => [...label],
              fontSize: 10,
            }
          }],
              yAxes: [{
            gridLines: {
              drawBorder: false,
              color: '#F0E4DC'
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