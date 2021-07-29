var LOCAL_CACHE = new Map()

$(document).ready(function (){
  var Calendar = require('tui-calendar'); /* CommonJS */
  require("tui-calendar/dist/tui-calendar.css");
  require("tui-date-picker/dist/tui-date-picker.css");
  require("tui-time-picker/dist/tui-time-picker.css");

  const themeConfig = {
    'week.timegridOneHour.height': '32px',
    'week.timegridHalfHour.height': '16px',
  };

  //カレンダー起動
  const cal = new Calendar(document.getElementById('calendar'), {
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
    isReadOnly: true,
    useCreationPopup: false,
    useDetailPopup: false,
  });

  //日付セット
  cal.setDate(PlanTimeList['date']);
  $('.tui-view-7').remove();
  $('.tui-full-calendar-dayname-layout').remove();
  //スケジュールをセット
  $.each(PlanTimeList['schedule'], function (index, value){
    cal.createSchedules([value]);
  })
  $('.tui-full-calendar-timegrid-container').css('overflow-y', 'hidden');
  setTimeout(function(){
    $('#calendar').css('height', '450px');
  },500);
});
