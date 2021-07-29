const LOCAL_CACHE = new Map()

$(document).ready(function (){
  propertyExcavationBehaviorAjax(storeOptions(1));

  $('#counter_datepicker').on('change', function () {
    console.log('check');
    const date = $(this).val();
    const area = $('#excavation_area_id').val();
    //ajax処理スタート
    ajax(date ,area)
  });
  $('#excavation_area_id').on('change', function () {
    console.log('check');
    const date = $('#counter_datepicker').val();
    const area = $('#excavation_area_id').val();
    //ajax処理スタート
    ajax(date ,area)
  });
  $('.excavation_btn').click(function () {
    const date = $('#counter_datepicker').val();
    const area = $('#excavation_area_id').val();
    //ajax処理スタート
    ajax(date, area)
  });
});

function ajax(date, area){
  $.ajax({
    headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
      'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
    url: '/excavationBehaviorLog/search', //通信先アドレスで、このURLをあとでルートで設定します
    method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    data: { //サーバーに送信するデータ
      'date': date,//いいねされた投稿のidを送る
      'area': area
    },
  })
      //通信成功した時の処理
      .done(function (data) {
        if (data['manager_visit_count'] >= 0){
          FormUpdate(data)
        }else{
          FormInitialize()
        }
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('通信が失敗しました。')
      });
}

function propertyExcavationBehaviorAjax(callback) {
  //ajax処理スタート
  $.ajax({
    url: `/propertyExcavationBehaviorLog/search`, //通信先アドレスで、このURLをあとでルートで設定します
    method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
    dataType: 'json'
  })
      //通信成功した時の処理
      .done(callback)
      //通信失敗した時の処理
      .fail(function () {
        console.log('false');
      });
}

function storeOptions(key){
  return function (value){
    LOCAL_CACHE.set(key, value);
  }
}

function FormUpdate(data) {
  $('#manager_visit_count').val(data['manager_visit_count']);
  $('#personal_visit_count').val(data['personal_visit_count'])
  $('#check_post_count').val(data['check_post_count'])
  $('#check_building_count').val(data['check_building_count'])
  $('#DM_distribution_count').val(data['DM_distribution_count'])
  $('#flyer_distribution_count').val(data['flyer_distribution_count'])
  $('#letter_distribution_count').val(data['letter_distribution_count'])
  $('#random_visit_implementation_count').val(data['random_visit_implementation_count'])
  $('#random_visit_at_home_count').val(data['random_visit_at_home_count'])
  $('#manager_TEL_count').val(data['manager_TEL_count'])
  $('#personal_TEL_count').val(data['personal_TEL_count'])
  $('#random_TEL_implementation_count').val(data['random_TEL_implementation_count'])
  $('#random_TEL_at_home_count').val(data['random_TEL_at_home_count'])
  $('#mail_letter_count').val(data['mail_letter_count'])
  $('#flyer_delivery_count').val(data['flyer_delivery_count'])
  $('#DM_mail_count').val(data['DM_mail_count'])
  $('#return_to_mail').val(data['return_to_mail'])
  $('#rental_information').val(data['rental_information'])
  $('#registration_information').val(data['registration_information'])
  $('#building_confirmation_information').val(data['building_confirmation_information'])
  $('#pre_visit_preliminary_count').val(data['pre_visit_preliminary_count'])
  $('#pre_visit_home_count').val(data['pre_visit_home_count'])
  $('#pre_TEL_home_count').val(data['pre_TEL_home_count'])
}

function FormInitialize(){
  $('#manager_visit_count').val(0);
  $('#personal_visit_count').val(0)
  $('#check_post_count').val(0)
  $('#check_building_count').val(0)
  $('#DM_distribution_count').val(0)
  $('#flyer_distribution_count').val(0)
  $('#letter_distribution_count').val(0)
  $('#random_visit_implementation_count').val(0)
  $('#random_visit_at_home_count').val(0)
  $('#manager_TEL_count').val(0)
  $('#personal_TEL_count').val(0)
  $('#random_TEL_implementation_count').val(0)
  $('#random_TEL_at_home_count').val(0)
  $('#mail_letter_count').val(0)
  $('#flyer_delivery_count').val(0)
  $('#DM_mail_count').val(0)
  $('#return_to_mail').val(0)
  $('#rental_information').val(0)
  $('#registration_information').val(0)
  $('#building_confirmation_information').val(0)
  $('#pre_visit_preliminary_count').val(0)
  $('#pre_visit_home_count').val(0)
  $('#pre_TEL_home_count').val(0)
}