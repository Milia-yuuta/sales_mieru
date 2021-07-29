$(function () {
  let medium;
  $('#TopGeneratingMedium').on('change', function () {
    let $this = $(this);
    medium = $this.val();
    //ajax処理スタート
    ajax(medium)
  });

  //発生媒体が一括査定サイトの場合は発生サイトを表示する
  $('#GeneratingMedium').change(function () {
    generatingMediumCheck();
  })

  //見込編集用
  $('.prospect_edit').click(function (){
    editAjax(primary_generating_medium_master_id)

  })
});

function ajax(medium){
  $.ajax({
    url: `/ActionMaster/GenerateMedium/${medium}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType:'json'
  })
      //通信成功した時の処理
      .done(function (data) {
        $('#GeneratingMedium').empty();
        $.each(data,function(index, element){
          $('#GeneratingMedium').append(
              $("<option />")
                  .val(index)
                  .text(element)
          );
        });
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('必須項目です、選択し直して下さい。');
      });
}

function editAjax(medium){
  $.ajax({
    url: `/ActionMaster/GenerateMedium/${medium}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType:'json'
  })
      //通信成功した時の処理
      .done(function (data) {
        $('#GeneratingMedium').empty();
        $.each(data,function(index, element){
          $('#GeneratingMedium').append(
              $("<option />")
                  .val(index)
                  .text(element)
          );
        });
        $('#GeneratingMedium').val(generating_medium_master_id);
        $('#TopGeneratingMedium').val(primary_generating_medium_master_id);
        generatingMediumCheck();
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('必須項目です、選択し直して下さい。');
      });
}

function topGeneratingMediumCheck(){
  if ($('#TopGeneratingMedium').val() !== '45'){
    $('.prospect_site_li').addClass('display_none');
    $('#source_media_site').prop('disabled', true);
  }
}

function generatingMediumCheck(){
  if ($('#GeneratingMedium').val() === '68'){
    $('.prospect_site_li').removeClass('display_none');
    $('#source_media_site').prop('disabled', false);
  }else{
    $('.prospect_site_li').addClass('display_none');
    $('#source_media_site').prop('disabled', true);
  }
}