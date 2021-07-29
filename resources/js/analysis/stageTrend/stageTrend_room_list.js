const LOCAL_CACHE = new Map()

$(document).ready(function () {
  fetchOptions(storeOptions('result'));

  $('.list_chart_stock .c-count').delay(700).queue(function(next){
    $(this).removeClass('start');
    next();
  });

  $(document).on('click', '.list_chart_stock .c-count', function(){
    let This = $(this),
        tag  = $('.p-stock_detail'),
        left = This.offset().left,
        right = $(window).width() - This.offset().left + 20,
        top  = This.offset().top;
    $('.p-stock_detail').removeAttr('style');
    $('.p-stock_detail').removeClass('open');
    if(left > right){
      tag.css('left',left+'px');
      tag.css('transform','translate(-90%, 10px)');
    }else{
      tag.css('right',right+'px');
      tag.css('transform','translate(110%, 10px)');
    }
    tag.css('top',top+'px');
    tag.addClass('open');

    const id = $(this).attr('id');
    const stage = $(this).data('stage');
    const dataName = $(this).data('name');

    if (LOCAL_CACHE.get('result') != null) {
      $('.loader').removeClass('loader');
      $('.list_room').empty();
      roomExpand(id, stage, dataName);
      return;
    }

    let timer = setInterval(() => {
      if (LOCAL_CACHE.get('result') != null) {
        $('.loader').removeClass('loader');
        $('.list_room').empty();
        roomExpand(id, stage, dataName);
        clearInterval(timer)
      }
    }, 1000)
  })

  $(document).click(function(event) {
    if($(event.target).closest('.list_chart_stock .c-count, .p-stock_detail').length) {}
    else{ $('.p-stock_detail').removeClass('open'); }
  });
});

function fetchOptions(callback){
  //ajax処理スタート
  $.ajax({
    headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
      'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
    url: '/analysis/stageTrend/roomList', //通信先アドレスで、このURLをあとでルートで設定します
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
        console.log('通信が失敗しました。');
      });
}

function storeOptions(key){
  return function (value) {
    LOCAL_CACHE.set(key, value);
  }
}

function propertyNameAjax(prospect_id){
  //ajax処理スタート
  $.ajax({
    url: `/analysis/stageTrend/roomList/show/${prospect_id}`,
    method: 'GET',
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(function (propertyRoom){
        const parent_class = $('.list_room').find(`#${propertyRoom['id']}`)
        parent_class.find('.loader').remove();
        parent_class.find('.ttl').text(propertyRoom['propertyName'])
        parent_class.find('.num').text(propertyRoom['roomName'])
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('propertyNameAjaxFalse');
      });
}


function roomExpand(id, stage, dataName){
  $.each(LOCAL_CACHE.get('result')[id][stage][dataName], function (index, propertyRoom){
    if(propertyRoom !== null) {
      $('.list_room').append(
          $(`
        <li>
          <a href="/prospect/${propertyRoom['id']}" target="_blank" id="${propertyRoom['id']}" class="list_room_li">
          <p class="loader" style="width: 10px; height: 10px;"></p>
            <p class="ttl"></p>
            <p class="num"></p>
          </a>
        </li>
        `)
      )
    }
  })
  $.each($('.list_room_li'), function (i, val){
    const prospect_id = $(val).attr('id');
    propertyNameAjax(prospect_id);
  });
}

