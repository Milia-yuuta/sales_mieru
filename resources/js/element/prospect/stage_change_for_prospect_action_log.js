$(function () {
  let stage;
  $('#ProspectActionLogStage').on('change', function () {
    let $this = $(this);
    stage = $this.val();
    console.log('check2')
    $.ajax({
      url: `/ActionMaster/prospect/${stage}`, //通信先アドレスで、このURLをあとでルートで設定します
      method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      dataType:'json'
    })
        //通信成功した時の処理
        .done(function (data) {
          console.log('check');
          $('#ProspectActionLogStatus').empty();
          $.each(data,function(index, element){
            $('#ProspectActionLogStatus').append(
                $("<option />")
                    .val(index)
                    .text(element)
            );
          });
        })
        //通信失敗した時の処理
        .fail(function () {
          alert('必須項目です、選択して下さい。');
        });
  });

  $('.ProspectActionLogEditBtn').click(function () {
    let $this = $('#ProspectActionLogStage');
    const ProspectStatus =  $(this).parents('.prospect_list').find('#ProspectStatus').val();
    stage = $this.val();
    console.log('check3')
    $.ajax({
      url: `/ActionMaster/prospect/${stage}`, //通信先アドレスで、このURLをあとでルートで設定します
      method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      dataType:'json'
    })
        //通信成功した時の処理
        .done(function (data) {
          $('#ProspectActionLogStatus').empty();
          $.each(data,function(index, element){
            $('#ProspectActionLogStatus').append(
                $("<option />")
                    .val(index)
                    .text(element)
            );
          });
          $(`#ProspectActionLogStatus option[value = ${ProspectStatus}]`).prop('selected',true);
        })
        //通信失敗した時の処理
        .fail(function () {
          alert('必須項目です、選択して下さい。');
        });
  });

  $('#NewProspectActionLogBtn').click(function () {
    console.log('check55')
    let $this = $('#ProspectActionLogStage');
    stage = $this.val();
    $.ajax({
      url: `/ActionMaster/prospect/${stage}`, //通信先アドレスで、このURLをあとでルートで設定します
      method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      dataType:'json'
    })
        //通信成功した時の処理
        .done(function (data) {
          console.log('check');
          $('#ProspectActionLogStatus').empty();
          $.each(data,function(index, element){
            $('#ProspectActionLogStatus').append(
                $("<option />")
                    .val(index)
                    .text(element)
            );
          });
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('必須項目です、選択して下さい。');
        });
  });
});