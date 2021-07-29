const LOCAL_CACHE = new Map()

$(document).ready(function (){
  ajax(storeOptions('rooms'));

  // const roomList = analysisData.footerGraphRoomList;
  $('.c-count').click(function (){
    const stage = $(this).data('stage');
    const id = $(this).attr('id')

    if (LOCAL_CACHE.get('rooms') != null) {
      $('.loader').removeClass('loader');
      $('.list_room').empty();
      roomExpand(stage, id);
      return;
    }

    let timer = setInterval(() => {
      if (LOCAL_CACHE.get('rooms') != null) {
        $('.loader').removeClass('loader');
        $('.list_room').empty();
        roomExpand(stage, id);
        clearInterval(timer)
      }
    }, 1000)
  })
});

function ajax(callback) {

  //ajax処理スタート
  $.ajax({
    headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
      'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
    url: '/analysis/pursuitReport/roomList', //通信先アドレスで、このURLをあとでルートで設定します
    method: 'post', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    data: { //サーバーに送信するデータ
      'start_period': $('#start_period').val(),
      'end_period': $('#end_period').val(),
      'office_master_id': $('#office_master_id').val(),
    },
  })
      //通信成功した時の処理
      .done(callback)
      //通信失敗した時の処理
      .fail(function () {
        console.log('ajaxFalse');
      });
}


function storeOptions(key) {
  return function (value) {
    LOCAL_CACHE.set(key, value);
  }
}

function roomExpand(stage, id){
  $('.list_room').empty();
  $.each(LOCAL_CACHE.get('rooms')[id][stage], function (index, property){
    $('.list_room').append(`
            <li>
          <a href="/prospect/${property['id']}" target="_blank">
            <p class="ttl">${property['PropertyName']}</p>
            <p class="num">${property['PropertyRoomName']}</p>
          </a>
        </li>
            `)
  });
}