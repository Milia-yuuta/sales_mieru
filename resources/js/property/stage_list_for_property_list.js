$(document).ready(function (){
  $('.c-count').click(function () {
    switch ($(this).data('stage')){
      case 'discrimination':
        var stage_action_master_id = 1;
        break;
      case 'latent':
        var stage_action_master_id = 2;
        break;
      case 'overt':
        var stage_action_master_id = 3;
        break;
    }

    const property_id = $(this).data('review-id');
    ajax(property_id, stage_action_master_id)
    //ajax処理スタート
  })
});

function ajax(property_id, stage_action_master_id){
  $.ajax({
    headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
      'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
    url: '/property/stage/search', //通信先アドレスで、このURLをあとでルートで設定します
    method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    data: { //サーバーに送信するデータ
      'property_id': property_id,
      'stage_action_master_id' : stage_action_master_id,
    },
  })
      //通信成功した時の処理
      .done(function (data) {
        $('.list_room').empty();
        $.each(data, function (index, prospect){
          $('.list_room').append(`
            <li>
          <a href="/prospect/${prospect['prospect_id']}" target="_blank">
            <p class="ttl">${prospect['property_name']}</p>
            <p class="num">${prospect['room_name']}</p>
          </a>
        </li>
            `)
        });
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('通信が失敗しました。')
      });
}