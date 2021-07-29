const LOCAL_CACHE = new Map()

$(function () {
  fetchOptions(storeOptions(1), 1);
  fetchOptions(storeOptions(2), 2);
  fetchOptions(storeOptions(3), 3);

  //新規追客用のスクリプト
  $('#NewProspectActionLogBtn').click(function (){
    $('#prospect_action_log_datepicker').val(generateDate(new Date()));
    //URL切り替え
    $('#ProspectActionLogEditForm').attr('action', `${location.protocol}//${location.host}/prospectActionLog/store`);
    const prospect_id = $('#hiddenProspectId').val();
    const next_prospect_id = $('#hiddenProspectId').val();
    $('#ProspectActionLogProspect_id').val(prospect_id);
    $('#NextProspectActionLogProspect_id').val(next_prospect_id);
    const stage_id = $('#stage_id_css').text();
    const status_id = $('#status_id').text();
    $(`#ProspectActionLogStage option[value = ${stage_id}]`).prop('selected',true);
    switch (stage_id){
      case '1':
        $('#stageCss').attr('data-option','discrimination');
        break
      case '2':
        $('#stageCss').attr('data-option','latent');
        break
      case '3':
        $('#stageCss').attr('data-option','overt');
        break
      case '4':
        $('#stageCss').attr('data-option','mediation');
        break
    }
    // replaceStageOptions(LOCAL_CACHE.get(Number(stage_id)))
    $(`#ProspectActionLogStatus option[value = ${status_id}]`).prop('selected',true);
    console.log($('#ProspectActionLogStatus').val());

    //クリック時に追客行動データを初期化
    $('#TEL_home').prop('checked', false);
    $('#send_letter').prop('checked', false);
    $('#local_letter').prop('checked', false);
    $('#email').prop('checked', false);
    $('#visit').prop('checked', false);
    $('#pursuit_other').prop('checked', false);
    $('#send_assessment_report').prop('checked', false);
    $('#assessment_report_email').prop('checked', false);
    $('#web_negotiation').prop('checked', false);
    $('#assessment_negotiation').prop('checked', false);
    $('#re-negotiation').prop('checked', false);
    $('#visit_caretaker').prop('checked', false);
    $('#TEL_caretaker').prop('checked', false);
    $('#on-site_check').prop('checked', false);
    $('#research_other').prop('checked', false);
    $('#re_TEL').prop('checked', false);
    $('#re_email').prop('checked', false);
    $('#re_letter').prop('checked', false);
    $('#re_hp').prop('checked', false);
    $('#re_site').prop('checked', false);
    $('#re_other').prop('checked', false);
    $('#result').text("");

    //クリック時に次回アクションデータを初期化
    $('#prospect_datepicker').val();
    $('#next_TEL_home').prop('checked', false);
    $('#next_send_letter').prop('checked', false);
    $('#next_local_letter').prop('checked', false);
    $('#next_email').prop('checked', false);
    $('#next_visit').prop('checked', false);
    $('#next_pursuit_other').prop('checked', false);
    $('#next_send_assessment_report').prop('checked', false);
    $('#next_assessment_report_email').prop('checked', false);
    $('#next_web_negotiation').prop('checked', false);
    $('#next_assessment_negotiation').prop('checked', false);
    $('#next_re-negotiation').prop('checked', false);
    $('#next_visit_caretaker').prop('checked', false);
    $('#next_TEL_caretaker').prop('checked', false);
    $('#next_on-site_check').prop('checked', false);
    $('#next_research_other').prop('checked', false);
    $('#next_re_TEL').prop('checked', false);
    $('#next_re_email').prop('checked', false);
    $('#next_re_letter').prop('checked', false);
    $('#next_re_hp').prop('checked', false);
    $('#next_re_site').prop('checked', false);
    $('#next_re_other').prop('checked', false);
  })

  //追客編集用のスクリプト
  $('.ProspectActionLogEditBtn').on('click', function () {
    //URL切り替え
    $('#ProspectActionLogEditForm').attr('action', `${location.protocol}//${location.host}/prospectActionLog/update`);

    //ステージ取得->入替
    const ProspectStage =  $(this).parents('.prospect_list').find('#ProspectStage').val();
    const ProspectStatus = $(this).parents('.prospect_list').find('#ProspectStatus').val();
    $(`#ProspectActionLogStage option[value = ${ProspectStage}]`).prop('selected',true);
    switch (ProspectStage){
      case '1':
        $('#stageCss').attr('data-option','discrimination');
        break
      case '2':
        $('#stageCss').attr('data-option','latent');
        break
      case '3':
        $('#stageCss').attr('data-option','overt');
        break
      case '4':
        $('#stageCss').attr('data-option','mediation');
        break
    }
    replaceStageOptions(LOCAL_CACHE.get(Number(ProspectStage)));
    $(`#ProspectActionLogStatus option[value = ${ProspectStatus}]`).prop('selected',true);
    //クリック時に追客行動データを初期化
    $('#TEL_home').prop('checked', false);
    $('#send_letter').prop('checked', false);
    $('#local_letter').prop('checked', false);
    $('#email').prop('checked', false);
    $('#visit').prop('checked', false);
    $('#pursuit_other').prop('checked', false);
    $('#send_assessment_report').prop('checked', false);
    $('#assessment_report_email').prop('checked', false);
    $('#web_negotiation').prop('checked', false);
    $('#assessment_negotiation').prop('checked', false);
    $('#re-negotiation').prop('checked', false);
    $('#visit_caretaker').prop('checked', false);
    $('#TEL_caretaker').prop('checked', false);
    $('#on-site_check').prop('checked', false);
    $('#research_other').prop('checked', false);
    $('#re_TEL').prop('checked', false);
    $('#re_email').prop('checked', false);
    $('#re_letter').prop('checked', false);
    $('#re_hp').prop('checked', false);
    $('#re_site').prop('checked', false);
    $('#re_other').prop('checked', false);
    $('#result').text("");

    //クリック時に次回アクションデータを初期化
    $('#prospect_datepicker').val();
    $('#next_TEL_home').prop('checked', false);
    $('#next_send_letter').prop('checked', false);
    $('#next_local_letter').prop('checked', false);
    $('#next_email').prop('checked', false);
    $('#next_visit').prop('checked', false);
    $('#next_pursuit_other').prop('checked', false);
    $('#next_send_assessment_report').prop('checked', false);
    $('#next_assessment_report_email').prop('checked', false);
    $('#next_web_negotiation').prop('checked', false);
    $('#next_assessment_negotiation').prop('checked', false);
    $('#next_re-negotiation').prop('checked', false);
    $('#next_visit_caretaker').prop('checked', false);
    $('#next_TEL_caretaker').prop('checked', false);
    $('#next_on-site_check').prop('checked', false);
    $('#next_research_other').prop('checked', false);
    $('#next_re_TEL').prop('checked', false);
    $('#next_re_email').prop('checked', false);
    $('#next_re_letter').prop('checked', false);
    $('#next_re_hp').prop('checked', false);
    $('#next_re_site').prop('checked', false);
    $('#next_re_other').prop('checked', false);
    const ProspectId = $(this).parents('.prospect_list').find('#ProspectId').val();
    $('#ProspectActionLogProspect_id').val(ProspectId);
    $('#NextProspectActionLogProspect_id').val(ProspectId);

    const ProspectActionLogId = $(this).parents('.prospect_list').find('#ProspectActionLogId').val();
    const NextProspectActionLogId = $(this).parents('.prospect_list').find('#NextProspectActionLogId').val();
    $('#ProspectActionLog_id').val(ProspectActionLogId);
    $('#NextProspectActionLog_id').val(NextProspectActionLogId);


    //対象の追客行動からリストへデータを移行
    const ActionDate = $(this).parents('.vertical-list').find('.day').text()
    $('#prospect_action_log_datepicker').val(ActionDate);
    const arrayActionList = $(this).parents('.vertical-list').find('.action_list')
    $.each(arrayActionList, function(i, val) {
      switch ($(val).text()){
        case "見込TEL":
          $('#TEL_home').prop('checked', true);
          break;
        case "手紙送付":
          $('#send_letter').prop('checked', true);
          break;
        case "現地手紙":
          $('#local_letter').prop('checked', true);
          break;
        case "メール送信":
          $('#email').prop('checked', true);
          break;
        case "戸別訪問在宅":
          $('#visit').prop('checked', true);
          break;
        case "追客その他":
          $('#pursuit_other').prop('checked', true);
          break;
        case "査定書送付":
          $('#send_assessment_report').prop('checked', true);
          break;
        case "査定書メール":
          $('#assessment_report_email').prop('checked', true);
          break;
        case "web商談":
          $('#web_negotiation').prop('checked', true);
          break;
        case "査定・商談":
          $('#assessment_negotiation').prop('checked', true);
          break;
        case "再商談":
          $('#re-negotiation').prop('checked', true);
          break;
        case "管理人訪問":
          $('#visit_caretaker').prop('checked', true);
          break;
        case "管理人TEL":
          $('#TEL_caretaker').prop('checked', true);
          break;
        case "現地チェック":
          $('#on-site_check').prop('checked', true);
          break;
        case "調査その他":
          $('#research_other').prop('checked', true);
          break;
        case "お客様よりTEL":
          $('#re_TEL').prop('checked', true);
          break;
        case "お客様よりメール":
          $('#re_email').prop('checked', true);
          break;
        case "お客様より手紙・FAX":
          $('#re_letter').prop('checked', true);
          break;
        case "お客様より当社HP反響":
          $('#re_hp').prop('checked', true);
          break;
        case "お客様より一括査定サイト":
          $('#re_site').prop('checked', true);
          break;
        case "お客様よりその他":
          $('#re_other').prop('checked', true);
          break;
      }
      const result = $(this).parents('.vertical-list').find('.prospectActionLogResult').text()
      $('#result').text(result);
    });

    //対象の追客行動から次回アクションリストへデータを移行
    const nextActionDate = $(this).parents('.vertical-list').find('.next_action_date').text()
    $('#next_prospect_datepicker').val(nextActionDate);
    const arrayNextActionList = $(this).parents('.vertical-list').find('.next_action_list')
    $.each(arrayNextActionList, function(i, val) {
      switch ($(val).text()){
        case "見込TEL":
          $('#next_TEL_home').prop('checked', true);
          break;
        case "手紙送付":
          $('#next_send_letter').prop('checked', true);
          break;
        case "現地手紙":
          $('#next_local_letter').prop('checked', true);
          break;
        case "メール送信":
          $('#next_email').prop('checked', true);
          break;
        case "戸別訪問":
          $('#next_visit').prop('checked', true);
          break;
        case "追客その他":
          $('#next_pursuit_other').prop('checked', true);
          break;
        case "査定書送付":
          $('#next_send_assessment_report').prop('checked', true);
          break;
        case "査定書メール":
          $('#next_assessment_report_email').prop('checked', true);
          break;
        case "web商談":
          $('#next_web_negotiation').prop('checked', true);
          break;
        case "査定・商談":
          $('#next_assessment_negotiation').prop('checked', true);
          break;
        case "再商談":
          $('#next_re-negotiation').prop('checked', true);
          break;
        case "管理人訪問":
          $('#next_visit_caretaker').prop('checked', true);
          break;
        case "管理人TEL":
          $('#next_TEL_caretaker').prop('checked', true);
          break;
        case "現地チェック":
          $('#next_on-site_check').prop('checked', true);
          break;
        case "調査その他":
          $('#next_research_other').prop('checked', true);
          break;
      }
    });
  });
});
function fetchOptions(callback, ProspectStage){
  //ajax処理スタート
  $.ajax({
    url: `/ActionMaster/prospect/${ProspectStage}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(callback)
      //通信失敗した時の処理
      .fail(function () {
        console.log('通信が失敗しました。');
      });
}

function replaceStageOptions(data) {
  $('#ProspectActionLogStatus').empty();
  $.each(data, function (index, element) {
    $('#ProspectActionLogStatus').append(
        $("<option />")
            .val(index)
            .text(element)
    );
  });
}

function storeOptions(key){
  return function (value) {
    LOCAL_CACHE.set(key, value);
  }
}

function stageCss(stage_id){
  switch (stage_id){
    case '1':
      return 'discrimination';
    case '2':
      return 'latent';
    case '3':
      return 'overt';
    case '4':
      return 'mediation';
  }
}

function generateDate(date) {
  var y = date.getFullYear();
  var m = ('00' + (date.getMonth()+1)).slice(-2);
  var d = ('00' + date.getDate()).slice(-2);
  return (y + '-' + m + '-' + d);
}