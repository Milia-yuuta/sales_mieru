const LOCAL_PROPERTY_NAME_CACHE = new Map();
const LOCAL_PROPERTY_CODE_CACHE = new Map();


$(document).ready(function (){
  fetchOptions('nameList',storeOptions('name'));
  fetchOptions('codeList',storeCodeOptions('code'));

  $('#newProspect').one('click',function (){
    $('#propertyNameSelect2').select2({
      data: LOCAL_PROPERTY_NAME_CACHE.get('name')
    });
    $('#propertyCodeSelect2').select2({
      data: LOCAL_PROPERTY_CODE_CACHE.get('code')
    });
  })

  // 顧客コードで検索された物件を表示させる
  $('.property_code').change(function () {
    const id = $('.property_code').val();
    SearchByCodeAjax(id)
  })


  //顧客名の検索方法が名前なのかコードなのかで表示を切り替える
  $('.property_search_pattern').change(function (){
    if ($('.property_search_pattern').val() === 'code'){
      $('.property_name').prop('disabled', true);
      $('.property_code').prop('disabled', false);
      $('.prospect_name_li').addClass('display_none');
      $('.prospect_code_li').removeClass('display_none');
    }else if($('.property_search_pattern').val() === 'name'){
      $('.property_name').prop('disabled', false);
      $('.property_code').prop('disabled', true);
      $('.prospect_name_li').removeClass('display_none');
      $('.prospect_code_li').addClass('display_none');
    }
  });
});

function fetchOptions(url, callback){
  //ajax処理スタート
  $.ajax({
    url: `/property/${url}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType:'json'
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
    LOCAL_PROPERTY_NAME_CACHE.set(key, value);
  }
}

function storeCodeOptions(key){
  return function (value) {
    LOCAL_PROPERTY_CODE_CACHE.set(key, value);
  }
}

function SearchByCodeAjax(property_id){
  //ajax処理スタート
  $.ajax({
    url: `property/codeList/search/${property_id}`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType:'json'
  })
      //通信成功した時の処理
      .done(function (data){
        $('.property_code_name').text(data);
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('通信が失敗しました。');
      });
}