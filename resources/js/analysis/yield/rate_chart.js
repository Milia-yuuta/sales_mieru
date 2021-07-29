export function config(data){
  return{
    type: 'scatter',
    data: {
      datasets: [{
        data: data,
        borderColor: '#DB6EA5',
        backgroundColor: '#fff',
        radius: 6,
        borderWidth: 2,
      }]
    },
    options: {
      tooltips: {
        callbacks: {
          label: function (tooltipItem, data) {
            var label = data.datasets[tooltipItem.datasetIndex].label || '';
            label += '媒介率 : ' + tooltipItem.yLabel  + '% 見込発生率 : ' + tooltipItem.xLabel + '%';
            return label;
          }
        }
      },
      scales: {
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: '見込発生率%',
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#2175B7',
          },
          categoryPercentage: .8, //棒グラフの太さ
          display: true,
          gridLines: {
            display: false,
          },
          ticks: {
            maxRotation: 0,
            minRotation: 0,
            min: 0,
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#000',
            padding: 15,
            beginAtZero: true,
            userCallback: function(label, index, labels) {
              if (Math.floor(label) === label) {
                return label + '%';;
              }
            }
          }
        }],
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: '媒介率%',
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#DB6EA5',
          },
          position: 'left',
          gridLines: {
            drawBorder: false,
            color: '#D0E0D8'
          },
          ticks: {
            min: 0,
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#000',
            beginAtZero: true,
            userCallback: function(label, index, labels) {
              if (Math.floor(label) === label) {
                return label + '%';
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
        datalabels: {
          anchor: 'end',
          align: 'end',
          offset: -30,
          color: '#DB6EA5',
          labels: {
            title: {
              font: {
                weight: 'bold',
              }
            },
            rotation: 10,
          }
        }
      },
    }
  }
};