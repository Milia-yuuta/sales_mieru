$(document).ready(function () {
  $('#period_submit').click(function () {
    const start_period = new Date($('#start_period').val());
    const end_period = new Date($('#end_period').val());
    if (start_period > end_period) {
      alert('日付が矛盾しています。')
      return false;
    }
  });
});