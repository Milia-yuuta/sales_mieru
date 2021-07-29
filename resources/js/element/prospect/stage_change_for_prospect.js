$(function () {
  let stage;
  $('#stage_action_master_id').on('change', function () {
    let $this = $(this);
    stage = $this.val();
    console.log('check1')
    //ajax処理スタート
    $.ajax({
      url: `/ActionMaster/prospect/${stage}`, //通信先アドレスで、このURLをあとでルートで設定します
      method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      dataType:'json'
    })
        //通信成功した時の処理
        .done(function (data) {
          $('#status_action_master_id').empty();
          $.each(data,function(index, element){
            $('#status_action_master_id').append(
                $("<option />")
                    .val(index)
                    .text(element)
            );
          });
        })
        //通信失敗した時の処理
        .fail(function () {
          alert('必須項目です、選択し直して下さい。');
        });
  });
});