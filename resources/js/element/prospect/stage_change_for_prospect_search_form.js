$(document).ready(function () {
  if ($('#status_search_form').val() === '0' && $('#stage_search_form').val() !== '0'){
    let stage = $('#stage_search_form').val();
    ajax(stage);
  }

  $(function () {
    let stage;
    $('#stage_search_form').on('change', function () {
      let $this = $(this);
      stage = $this.val();
      if (stage === '0'){
        $('#none_status_search_form').addClass('display_none')
        $("#status_search_form").prop("disabled", true);
        return false;
      }
      ajax(stage)
    });
  });

  function ajax(stage){
    //ajax処理スタート
    $.ajax({
      url: `/ActionMaster/prospect/${stage}`, //通信先アドレスで、このURLをあとでルートで設定します
      method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      dataType: 'json'
    })
        //通信成功した時の処理
        .done(function (data) {
          $('#status_search_form').empty();
          $('#status_search_form').append(
              $("<option />")
                  .val(0)
                  .text('ALL')
          );
          $.each(data, function (index, element) {
            $('#status_search_form').append(
                $("<option />")
                    .val(index)
                    .text(element)
            );
          });
          $('#none_status_search_form').removeClass('display_none')
          $("#status_search_form").prop("disabled", false);
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('サーチフォームの通信失敗');
        });
  }
});