export function config({user, ActionCount, OccurrenceCount, MediationCount}) {
  return {
    type: 'bar',
    data: {
      labels: user,
      datasets: [

        {
          label: '行動量',
          borderWidth: 1,
          backgroundColor: '#009A44',
          borderColor: '#0D6F38',
          datalabels: {
            color: 'black',
            font: {
              weight: 'bold'
            },
            anchor: 'end', // データラベルの位置（'end' は上側）
            align: 'end',
            offset:-10,
            },
          data: ActionCount,
          // yAxisID: 'action'
        }, {
          label: '見込発生数',
          borderWidth: 1,
          backgroundColor: '#3B96DD',
          borderColor: '#2175B7',
          data: OccurrenceCount,
          datalabels: {
            color: 'black',
            font: {
              weight: 'bold'
            },
            anchor: 'end', // データラベルの位置（'end' は上側）
            align: 'end',
            offset:-10,
          },
          // yAxisID: 'occurrence-mediation'
        },
        {
          label: '媒介数',
          borderWidth: 1,
          backgroundColor: '#FE9CCE',
          borderColor: '#DB6EA5',
          data: MediationCount,
          datalabels: {
            color: 'black',
            font: {
              weight: 'bold'
            },
            anchor: 'end',// データラベルの位置（'end' は上側）
            align: 'end',
            offset:-10,
          },
          // yAxisID: 'occurrence-mediation'
        }
      ]
    },
    options: {
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 20,
          bottom: 0
        },
      },
      tooltips: {
        enabled: false
      },
      scales: {
        xAxes: [
          {
            categoryPercentage: 0.8, //棒グラフの太さ
            barPercentage: 1,
            display: true,
            gridLines: {
              display: false,
              offset: false,
              categoryPercentage: 1.0,
              barPercentage: 1.0,
            },
            ticks: {
              callback: label => [...label],
              fontStyle: 'bold',
              fontColor: '#000',
            },
          }]
        ,
        yAxes: [
          {
            // id: 'action',
            gridLines: {

              color: '#CFDCEA'
            },
            ticks: {
              fontStyle: 'bold',
              fontColor: '#000',
              min: 0,
              userCallback: function(label, index, labels) {
                if (Math.floor(label) === label) {
                  return label;
                }
              }
            },
            position: 'left',
            label: '行動量'
          },
          // {
          //   id: 'occurrence-mediation',
          //   gridLines: {
          //     drawBorder: false,
          //     color: '#CFDCEA'
          //   },
          //   ticks: {
          //     fontStyle: 'bold',
          //     fontColor: '#000',
          //     stepSize: 1,
          //     min: 0,
          //   },
          //   position: 'right',
          // },
        ]
      },
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false,
      },
      plugins: {
        datalabels: { // 共通の設定はここ
          display: true
        }
      },
    }
  }
}