$(document).ready(function (){
  const office_id = $('#top_office_id').val();
  ajax(office_id);

  $('#top_office_id').change(function (){
    ajax($(this).val());
  });
});

function ajax($office_id){
  //ajax処理スタート
  $.ajax({
    url: `/team/search/office/${$office_id}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(function (data){
        $('#top_user_id').empty();
        $.each(data, function (index, element) {
          $('#top_user_id').append(
              $("<option />")
                  .val(index)
                  .text(element)
          );
        });
        $('#top_user_id').val($('#top_user_id').data('option'));
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('通信が失敗しました。');
      });
}