var LOCAL_CACHE = new Map()

$(document).ready(function (){
  var Calendar = require('tui-calendar'); /* CommonJS */
  require("tui-calendar/dist/tui-calendar.css");
  require("tui-date-picker/dist/tui-date-picker.css");
  require("tui-time-picker/dist/tui-time-picker.css");

  //フォーム用選択リスト
  ajax(storeOptions('result'));

  const themeConfig = {
    'week.timegridOneHour.height': '40px',
    'week.timegridHalfHour.height': '20px',
  };

  //カレンダー起動
  const result = new Calendar(document.getElementById('resultCalendar'), {
    defaultView: 'day', // daily view option
    taskView: false,
    template: {
      timegridDisplayPrimaryTime: function (time) {
        const hour = time.hour
          return `${String(hour).padStart(2, '0')}:00`;
      },
    },
    week: {
      hourStart: 8,
      hourEnd: 22,
    },
    theme: themeConfig,
    isReadOnly: resultCheck === 1 ? true : false,
    useCreationPopup: false,
    useDetailPopup: false,
  });

  //日付セット
  result.setDate(resultTimeList['date']);
  $('.tui-full-calendar-dayname-layout').remove();

  //スケジュールをセット
  $.each(resultTimeList['schedule'], function (index, value){
    result.createSchedules([value]);
  })

  $('.tui-full-calendar-timegrid-container').css('overflow-y', 'hidden');

  result.on({
    //スケジュールをクリックしたアクション
    'clickSchedule': function(e) {
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      const edit_start_time = e['schedule']['start']['_date'].toString().match(regex)[0];
      const edit_end_time = e['schedule']['end']['_date'].toString().match(regex)[0];
      $('#ResultPrimaryItem').val(e['schedule']['calendarId']);
      selectChange(e['schedule']['calendarId'].toString());
      $('#ResultTertiaryItem').val(e['schedule']['state'])
      $('#resultStartTime').val(edit_start_time);
      $('#resultEndTime').val(edit_end_time);
      $('#result_daily_report_action_log_id').val(e['schedule']['id'])
      $('#DailyReportResultStoreForm').attr('action', `/dailyReport/ResultUpdate`);
      $('.result_delete_submit').removeClass('display_none');
      if (resultCheck === 0){
        result_modal_open()
      }
      result_submit_controller(e['schedule']['id']);
    },

    //新規クリック時のアクション
    'beforeCreateSchedule': function(e) {
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      let stop_check = false;
      const start_time =  e['start']['_date'].toString().match(regex)[0];
      const end_time = e['end']['_date'].toString().match(regex)[0];
      $('#ResultPrimaryItem').val('0');
      $('#ResultTertiaryItem').empty();
      $('#resultStartTime').val(start_time);
      $('#resultEndTime').val(end_time);
      $('.result_delete_submit').addClass('display_none');
      $('#DailyReportResultStoreForm').attr('action', `/dailyReport/ResultStore`);
      result_modal_open();
      $('.result_submit').click(function (){
        $.each(resultTimeList['schedule'], function (index, value){
          let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
          const start_time = Number(value['start'].match(regex)[0].replace(':', ''));
          const end_time = Number(value['end'].match(regex)[0].replace(':', ''));
          const form_start_time = Number($('#resultStartTime').val().replace(':', ''));
          const form_end_time = Number($('#resultEndTime').val().replace(':', ''));
          if ((start_time <= form_start_time && form_start_time < end_time) || (start_time < form_end_time && form_end_time <= end_time) || (form_start_time < start_time && end_time < form_end_time) || (form_start_time === start_time && end_time === form_end_time)){
            stop_check = true;
          }
        })
        if (stop_check === true){
          alert('同時間帯に既に登録済みです。');
          location.reload();
          return false;
        }
        if ($('#ResultPrimaryItem').val() === '0' || $('#ResultTertiaryItem').val() === '0'){
          alert('項目が未入力です。');
          return false;
        }
        $('.result_submit').css('pointer-events','none');
      })
    },

    //ドラッグ更新
    'beforeUpdateSchedule': function(e) {
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      const dailyReportActionLogId = e['schedule']['id'];
      const change_start_time = e['start']['_date'].toString().match(regex)[0];
      const change_end_time = e['end']['_date'].toString().match(regex)[0];
      let stop_check = false;
      $.each(resultTimeList['schedule'], function (index, value){
        const start_time = Number(value['start'].match(regex)[0].replace(':', ''));
        const end_time = Number(value['end'].match(regex)[0].replace(':', ''));
        const form_start_time = Number(change_start_time.replace(':', ''));
        const form_end_time = Number(change_end_time.replace(':', ''));
        if (dailyReportActionLogId === value['id']){
        }else if ((start_time <= form_start_time && form_start_time < end_time) || (start_time < form_end_time && form_end_time <= end_time)){
          stop_check = true;
        }
      })
      try {
        if (stop_check === true){
          throw new Error('終了します');
        }
        resultUpdateAjax(dailyReportActionLogId, change_start_time, change_end_time, result)
        result.updateSchedule(dailyReportActionLogId, e['schedule']['calendarId'], {
          start: e['start']['_date'],
          end: e['end']['_date'],
          category: 'time',
        })
      }catch (e) {
        alert('同時間帯に既に登録済みです。');
        location.reload();
      }
    },
  })

  //delete
  $('.result_delete_submit').click(function (){
    $('#DailyReportResultStoreForm').attr('action', `${location.protocol}//${location.host}/dailyReport/ResultDelete`);
  });
});

function result_submit_controller(id){
  //フォームの監視
  let check = false;
  $('.result_submit').click(function (){
    $.each(resultTimeList['schedule'], function (index, value){
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      const start_time = Number(value['start'].match(regex)[0].replace(':', ''));
      const end_time = Number(value['end'].match(regex)[0].replace(':', ''));
      const form_start_time = Number($('#resultStartTime').val().replace(':', ''));
      const form_end_time = Number($('#resultEndTime').val().replace(':', ''));
      if (value['id'] === id){
      }else if ((start_time <= form_start_time && form_start_time < end_time) || (start_time < form_end_time && form_end_time <= end_time) || (form_start_time < start_time && end_time < form_end_time)){
        check = true;
      }
    })
    if (check === true){
      alert('同時間帯に既に登録済みです。');
      location.reload();
      return false;
    }
    if ($('#ResultPrimaryItem').val() === '0' || $('#ResultTertiaryItem').val() === '0'){
      alert('項目が未入力です。');
      return false;
    }
    $('.result_submit').css('pointer-events','none');
  })
}

//クリック時にモーダルオープン
function result_modal_open(){
  const Tag = $('.result_report_add');
  Tag.addClass('open');
  Tag.css('top',310+'px').css('left',750+'px');
  Tag.delay(400).queue(function(next){
    Tag.addClass('open');
    next();
  });
}

function resultUpdateAjax(dailyReportActionLogId, start_time, end_time, result){
  $.ajax({
    headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
      'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
    url: '/dailyReport/ajax/resultUpdate', //通信先アドレスで、このURLをあとでルートで設定します
    method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    data: { //サーバーに送信するデータ
      'result_daily_report_action_log_id': dailyReportActionLogId,
      'start_time': start_time,
      'end_time': end_time,
    },
  })
      //通信成功した時の処理
      .done(function (data) {
        console.log('updateCheck');
        resultAjax(dailyReportId, result);
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('try')
      });
}

function ajax(callback) {
  //ajax処理スタート
  $.ajax({
    url: `/ActionMaster/dailyReportAction`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(callback)
      //通信失敗した時の処理
      .fail(function () {
        console.log('false');
      });
}

function resultAjax(dailyReportId, result){
  //ajax処理スタート
  $.ajax({
    url: `/dailyReport/result/${dailyReportId}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(function (data){
        resultTimeList = data;
        result.clear();
        result.setDate(resultTimeList['date']);
        $.each(resultTimeList['schedule'], function (index, value){
          result.createSchedules([value], false);
        })
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('ajaxFalse');
      });
}

function storeOptions(key){
  return function (value){
    LOCAL_CACHE.set(key, value);
  }
}

$('#ResultPrimaryItem').change(function (){
  console.log('check_2');
  const action_id = $(this).val();
  selectChange(action_id)
});

function selectChange(action_id){
  $('#ResultTertiaryItem').empty();
  switch (action_id){
    case '18':
      $.each(LOCAL_CACHE.get('result')['area'], function (index, value){
        $('#ResultTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '19':
      $.each(LOCAL_CACHE.get('result')['office'], function (index, value){
        $('#ResultTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '20':
      $.each(LOCAL_CACHE.get('result')['visit'], function (index, value){
        $('#ResultTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '21':
      $.each(LOCAL_CACHE.get('result')['meeting'], function (index, value){
        $('#ResultTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '22':
      $.each(LOCAL_CACHE.get('result')['agreement'], function (index, value){
        $('#ResultTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '23':
      $.each(LOCAL_CACHE.get('result')['other'], function (index, value){
        $('#ResultTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
  }
}
