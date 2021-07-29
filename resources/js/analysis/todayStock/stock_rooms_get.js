const LOCAL_CACHE = new Map()

$(document).ready(function (){
  ajax(storeOptions('rooms'));
  $('.unit').click(function (){
  })
});

function ajax(callback) {
  const office_id = $('#select2_office_id').val();
  //ajax処理スタート
  $.ajax({
    url: `/analysis/todayStock/getRooms/${office_id}`, //通信先アドレスで、このURLをあとでルートで設定します
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