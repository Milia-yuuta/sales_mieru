var LOCAL_CACHE = new Map()

$(document).ready(function (){
  var Calendar = require('tui-calendar'); /* CommonJS */
  require("tui-calendar/dist/tui-calendar.css");
  require("tui-date-picker/dist/tui-date-picker.css");
  require("tui-time-picker/dist/tui-time-picker.css");
  //フォーム用選択リスト
  ajax(storeOptions('actionList'));

  const themeConfig = {
    'week.timegridOneHour.height': '40px',
    'week.timegridHalfHour.height': '20px',
  };
  //カレンダー起動
  const cal = new Calendar(document.getElementById('calendar'), {
    defaultView: 'day', // daily view option
    taskView: false,
    scheduleView: true,
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
    isReadOnly: planCheck === 1 ? true : false,
    useCreationPopup: false,
    useDetailPopup: false,
  });

  cal.setDate(PlanTimeList['date']);

  //日付セット
  //スケジュールをセット
  $.each(PlanTimeList['schedule'], function (index, value){
    cal.createSchedules([value], false);
  })

  $('.tui-full-calendar-timegrid-container').css('overflow-y', 'hidden');


  cal.on({
    //スケジュールをクリックしたアクション
    'clickSchedule': function(e) {
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      const edit_start_time = e['schedule']['start']['_date'].toString().match(regex)[0];
      const edit_end_time = e['schedule']['end']['_date'].toString().match(regex)[0];
      $('#PlanPrimaryItem').val(e['schedule']['calendarId']);
      selectChange(e['schedule']['calendarId'].toString());
      $('#PlanTertiaryItem').val(e['schedule']['state'])
      $('#PlanStartTime').val(edit_start_time);
      $('#PlanEndTime').val(edit_end_time);
      $('#daily_report_action_log_id').val(e['schedule']['id'])
      $('#DailyReportPlanStoreForm').attr('action', `/dailyReport/PlanUpdate`);
      $('.plan_delete_submit').removeClass('display_none');
      if (planCheck === 0){
        modal_open();
      }
      submit_controller(e['schedule']['id']);
    },

    //新規クリック時のアクション
    'beforeCreateSchedule': function(e) {
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      let stop_check = false;
      const start_time =  e['start']['_date'].toString().match(regex)[0];
      const end_time = e['end']['_date'].toString().match(regex)[0];
      $('#PlanPrimaryItem').val('0');
      $('#PlanTertiaryItem').empty();
      $('#PlanStartTime').val(start_time);
      $('#PlanEndTime').val(end_time);
      $('#DailyReportPlanStoreForm').attr('action', `/dailyReport/PlanStore`);
      $('.plan_delete_submit').addClass('display_none');
      modal_open();
      $('.daily_submit').click(function (){return false;});
      $('.daily_submit').click(function (){
        $.each(PlanTimeList['schedule'], function (index, value){
          let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
          const start_time = Number(value['start'].match(regex)[0].replace(':', ''));
          const end_time = Number(value['end'].match(regex)[0].replace(':', ''));
          const form_start_time = Number($('#PlanStartTime').val().replace(':', ''));
          const form_end_time = Number($('#PlanEndTime').val().replace(':', ''));
          if ((start_time <= form_start_time && form_start_time < end_time) || (start_time < form_end_time && form_end_time <= end_time) || (form_start_time < start_time && end_time < form_end_time) || (form_start_time === start_time && end_time === form_end_time)){
            stop_check = true;
          }
        })
        if (stop_check === true){
          alert('同時間帯に既に登録済みです。');
          location.reload();
          return false;
        }
        if ($('#PlanPrimaryItem').val() === '0' || $('#PlanTertiaryItem').val() === '0'){
          alert('項目が未入力です。');
          return false;
        }
        $('.daily_submit').css('pointer-events','none');
        $('#DailyReportPlanStoreForm').submit();
      })
    },

    //ドラッグ更新
    'beforeUpdateSchedule': function(e) {
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      const dailyReportActionLogId = e['schedule']['id'];
      const change_start_time = e['start']['_date'].toString().match(regex)[0];
      const change_end_time = e['end']['_date'].toString().match(regex)[0];
      var stop_check = false;
      $.each(PlanTimeList['schedule'], function (index, value){
        const start_time = Number(value['start'].match(regex)[0].replace(':', ''));
        const end_time = Number(value['end'].match(regex)[0].replace(':', ''));
        const form_start_time = Number(change_start_time.replace(':', ''));
        const form_end_time = Number(change_end_time.replace(':', ''));
        if (dailyReportActionLogId === value['id']){
        }else if ((start_time <= form_start_time && form_start_time < end_time) || (start_time < form_end_time && form_end_time <= end_time) || (form_end_time < start_time && end_time <form_end_time )){
          stop_check = true;
        }
      })
      try {
        if (stop_check === true){
          throw new Error('終了します');
        }
        updateAjax(dailyReportActionLogId, change_start_time, change_end_time, cal)
        cal.updateSchedule(dailyReportActionLogId, e['schedule']['calendarId'], {
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
  $('.plan_delete_submit').click(function (){
    $('#DailyReportPlanStoreForm').attr('action', `${location.protocol}//${location.host}/dailyReport/PlanDelete`);
  });
});

function submit_controller(id){
  //フォームの監視
  $('.daily_submit').click(function (){
    let check = false;
    $.each(PlanTimeList['schedule'], function (index, value){
      let regex = /([01][0-9]|2[0-3]):[0-5][0-9]/;
      const start_time = Number(value['start'].match(regex)[0].replace(':', ''));
      const end_time = Number(value['end'].match(regex)[0].replace(':', ''));
      const form_start_time = Number($('#PlanStartTime').val().replace(':', ''));
      const form_end_time = Number($('#PlanEndTime').val().replace(':', ''));
      if (value['id'] === id){
      } else if ((start_time <= form_start_time && form_start_time < end_time) || (start_time < form_end_time && form_end_time <= end_time) || (form_start_time < start_time && end_time < form_end_time)){
        alert('同時間帯に既に登録済みです。');
        location.reload();
        check = true;
        throw new Error('終了します');
      }
    })
    if (check === true){
      return false;
    }
    if ($('#PlanPrimaryItem').val() === '0' || $('#PlanTertiaryItem').val() === '0'){
      alert('項目が未入力です。');
      return false;
    }
    $('.daily_submit').css('pointer-events','none');
  })
}

//クリック時にモーダルオープン
function modal_open(){
  const Tag = $('.plan_report_add');
  Tag.addClass('open');
  Tag.css('top',310+'px').css('left',580+'px');
  Tag.delay(400).queue(function(next){
    Tag.addClass('open');
    next();
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
        console.log('ajaxfalse');
      });
}

function updateAjax(dailyReportActionLogId, start_time, end_time, cal){
  $.ajax({
    headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
      'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
    url: '/dailyReport/ajax/PlanUpdate', //通信先アドレスで、このURLをあとでルートで設定します
    method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    data: { //サーバーに送信するデータ
      'daily_report_action_log_id': dailyReportActionLogId,
      'start_time': start_time,
      'end_time': end_time,
    },
  })
      //通信成功した時の処理
      .done(function (data) {
        console.log('ajaxTrue')
        planAjax(dailyReportId, cal);
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('try')
      });
}

function planAjax(dailyReportId, cal){
  //ajax処理スタート
  $.ajax({
    url: `/dailyReport/plan/${dailyReportId}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(function (data){
        PlanTimeList = data;
        cal.clear();
        cal.setDate(PlanTimeList['date']);
        $.each(PlanTimeList['schedule'], function (index, value){
          cal.createSchedules([value], false);
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

$('#PlanPrimaryItem').change(function (){
  const action_id = $(this).val();
  selectChange(action_id)
});

function selectChange(action_id){
  $('#PlanTertiaryItem').empty();
  switch (action_id){
    case '18':
      $.each(LOCAL_CACHE.get('actionList')['area'], function (index, value){
        $('#PlanTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '19':
      $.each(LOCAL_CACHE.get('actionList')['office'], function (index, value){
        $('#PlanTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '20':
      $.each(LOCAL_CACHE.get('actionList')['visit'], function (index, value){
        $('#PlanTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '21':
      $.each(LOCAL_CACHE.get('actionList')['meeting'], function (index, value){
        $('#PlanTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '22':
      $.each(LOCAL_CACHE.get('actionList')['agreement'], function (index, value){
        $('#PlanTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
    case '23':
      $.each(LOCAL_CACHE.get('actionList')['other'], function (index, value){
        $('#PlanTertiaryItem').append($('<option>').html(value).val(index));
      })
      break;
  }
}
