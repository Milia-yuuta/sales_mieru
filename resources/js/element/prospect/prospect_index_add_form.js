const LOCAL_CACHE = new Map()

$(function () {
  fetchOptions(storeOptions(1), 1);
  fetchOptions(storeOptions(2), 2);
  fetchOptions(storeOptions(3), 3);

  $('.ProspectActionLogBtn').click(function (e) {
    e.stopPropagation()
    $('#assessment_negotiation').prop('checked', false)
    $('#re_TEL').prop('checked', false)
    $('#re_email').prop('checked', false)
    $('#re_letter').prop('checked', false)
    $('#re_hp').prop('checked', false)
    $('#re_site').prop('checked', false)
    $('#re_other').prop('checked', false)
    //id取得->入替
    const ProspectId = $(this).parents('.prospect_list').find('#ProspectId').val();
    $('#ProspectActionLogProspect_id').val(ProspectId);
    $('#NextProspectActionLogProspect_id').val(ProspectId);
    //ステージ取得->入替
    const ProspectStage = $(this).parents('.prospect_list').find('#ProspectStage').val();
    $(`#ProspectActionLogStage option[value = ${ProspectStage}]`).prop('selected', true) ;
    $('#stageCss').attr('data-option', stageCss(ProspectStage));

    replaceStageOptions(LOCAL_CACHE.get(Number(ProspectStage)))
    const ProspectStatus = $(this).parents('.prospect_list').find('#ProspectStatusId').val();
    $(`#ProspectActionLogStatus option[value = ${ProspectStatus}]`).prop('selected', true);
  })
});

function fetchOptions(callback, ProspectStage){
  //ajax処理スタート
  $.ajax({
    url: `/ActionMaster/prospect/${ProspectStage}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(callback)
      //通信失敗した時の処理
      .fail(function () {
        console.log('通信が失敗しました。');
      });
}

function replaceStageOptions(data) {
  $('#ProspectActionLogStatus').empty();
  $.each(data, function (index, element) {
    $('#ProspectActionLogStatus').append(
        $("<option />")
            .val(index)
            .text(element)
    );
  });
}

function storeOptions(key){
  return function (value) {
    LOCAL_CACHE.set(key, value);
  }
}

function stageCss(stage_id){
  switch (stage_id){
    case '1':
      return 'discrimination';
    case '2':
      return 'latent';
    case '3':
      return 'overt';
    case '4':
      return 'mediation';
  }
}