$(document).ready(function (){
  ajax($('#office_select').val());
  $('#office_select').change(function (){
    ajax($(this).val());
  });

  $('.daily_search_btn').click(function (){
    const end_date = $('#report_datepicker_end').val();
    const start_date = $('#report_datepicker_start').val();
    if (end_date < start_date){
      alert('開始より前の日付が選択されています。')
      return false;
    }
  });
})


function ajax($office_id){
  //ajax処理スタート
  $.ajax({
    url: `/dailyReport/user/${$office_id}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(function (data){
        $('#user_select').empty();
        $.each(data, function (index, element) {
          $('#user_select').append(
              $("<option />")
                  .val(index)
                  .text(element)
          );
        });
        $('#user_select').val($('#user_select').data('option'));
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('通信が失敗しました。');
      });
}