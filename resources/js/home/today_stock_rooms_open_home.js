const LOCAL_CACHE = new Map()

$(document).ready(function () {
  ajax(storeOptions('rooms'));
  $('.unit').click(function (){
  })


  $('.list_chart_stock .c-count').delay(700).queue(function(next){
    $(this).removeClass('start');
    next();
  });

  $(document).on('click', '.c-count', function(){
    let This = $(this),
        Tag  = $('.p-stock_detail'),
        Left = This.offset().left,
        Right = $(window).width() - This.offset().left + 20,
        Top  = This.offset().top;
    $('.p-stock_detail').removeAttr('style');
    $('.p-stock_detail').removeClass('open');
    if(Left > Right){
      Tag.css('left',Left+'px');
      Tag.css('transform','translate(-90%, 10px)');
    }else{
      Tag.css('right',Right+'px');
      Tag.css('transform','translate(110%, 10px)');
    }
    Tag.css('top',Top+'px');
    roomExpand(This);
    Tag.addClass('open');
  });

  $(document).click(function(event) {
    if($(event.target).closest('.c-count, .p-stock_detail').length) {}
    else{ $('.p-stock_detail').removeClass('open'); }

    if ($(event.target).closest('.c-count-none').length){
      $('.p-stock_detail').removeClass('open');
    };
  });
});

function roomExpand(This){
  const id = Number(This.attr('id'));
  const status = This.data('status');
  $('.list_room').empty();
  $.each(LOCAL_CACHE.get('rooms')[id][status], function (index, prospect){
    $('.list_room').append(`
       <a href="/prospect/${prospect['id']}" target="_blank">
            <p class="ttl">${prospect['propertyName']}</p>
            <p class="num">${prospect['roomName']}</p>
          </a>
    `)
  });
}

function ajax(callback) {
  const office_id = $('#select2_office_id').val();
  //ajax処理スタート
  $.ajax({
    url: `/analysis/todayStock/home/getRooms/${office_id}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(callback)
      //通信失敗した時の処理
      .fail(function () {
        console.log('ajaxFalse');
      });
}

function storeOptions(key){
  return function (value){
    LOCAL_CACHE.set(key, value);
  }
}
