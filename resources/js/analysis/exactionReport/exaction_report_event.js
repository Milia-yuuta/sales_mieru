$(document).ready(function (){
  var ctx = document.getElementById("excavation_report_total_1").getContext("2d");
  window.myDoughnut = new Chart(ctx, config(analysisData.office));

  analysisData.graph.forEach(renderGraph)

  function renderGraph(user, index) {
    const {user_name} = user.person
    const context = document.getElementById(`excavation_report_${index + 1}`).getContext("2d")
    new Chart(context, config(user))
  }

  function config(data) {
    return {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [
            //area
            data.area.CaretakerVisitActiveCount, data.area.PersonalVisitActiveCount, data.area.PostCheckActiveCount,data.area.CheckTheBuildingActiveCount, data.area.PatrolLocalInformationActiveCount, data.area.DMActiveCount, data.area.FlyerActiveCount, data.area.LatterActiveCount, data.area.RandomActiveCount,
            //company
            data.company.CaretakerTelActiveCount, data.company.PersonalTelActiveCount, data.company.RandomTelActiveCount,data.company.RandomTelImplementationCount, data.company.LatterActiveCount, data.company.FlyerActiveCount, data.company.DMActiveCount, data.company.ReturnByMailActiveCount, data.company.RentalInformationActiveCount, data.company.RegistrationInformationActiveCount, data.company.BuildingConfirmationInformationActiveCount,
            //re
            data.re.hpActiveCount, data.re.siteActiveCount, data.re.otherSalesOfficeActiveCount, data.re.otherGroupsActiveCount,
            //pre
            data.pre.PreVisitActiveCount, data.pre.PreTelActiveCount, data.pre.PreSelfDiscoveryActiveCount,data.pre.PreResponseActiveCount, data.pre.PreOtherActiveCount,
            //other
            data.other.contractorInvolvementActiveCount, data.other.openRoomActiveCount, data.other.freeVisitActiveCount, data.other.otherActiveCount ,
          ],
          backgroundColor: [
            '#009A44',
              '#009A44',
              '#009A44',
              '#009A44',
              '#009A44',
              '#009A44',
              '#009A44',
              '#009A44',
              '#009A44',
            '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
              '#3B96DD',
            '#FB966E',
              '#FB966E',
              '#FB966E',
              '#FB966E',
            '#FCDB8B9E',
              '#FCDB8B9E',
              '#FCDB8B9E',
              '#FCDB8B9E',
              '#FCDB8B9E',
            '#F6C555',
            '#F6C555',
            '#F6C555',
            '#F6C555',
          ], labels: [
            '管理人訪問',
            '個別訪問',
            'ポストC',
            '一棟C',
            '巡回現地情報',
            'DM手まき',
            'チラシ手まき',
            '手紙封書手まき',
            'ランダム戸別',
            '管理人TEL',
            '個人TEL',
            'ランダムTEL実施数',
            'ランダムTEL在宅数',
            '手紙封書郵送',
            '売却チラシ',
            'DM郵送',
            '郵送物戻',
            '賃貸情報',
            '登記情報',
            '建築確認情報',
            '当社HP',
              '一括査定サイト',
              '他営業所紹介',
              '本社・グループ会社紹介',
            '前取訪問',
              '前取TEL',
              '前取自己発見',
              '前取反響',
              '前取その他',
            '業者関与',
            'オープンルーム',
            'フリー来社',
            'その他',
          ],
        }, {
          data: [data.area.areaTotal, data.company.companyTotal, data.re.reTotal, data.pre.preTotal, data.other.otherTotal],
          backgroundColor: [
            '#009A44',
            '#3B96DD',
            '#FB966E',
            '#FEF2CB',
            '#F6C555',
          ],
          labels: [
            'エリア発掘',
            '社内発掘',
            '反響',
            '前取関連',
            'その他',
          ],
        }]
      },
      options: {
        responsive: true,
        legend: {
          display: false,
        },
        plugins: {
          datalabels: { // 共通の設定はここ
            display: false
          }
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var index = tooltipItem.index;
              return dataset.labels[index] + ': ' + dataset.data[index];
            },
          },
        }
      }
    }
  };
});