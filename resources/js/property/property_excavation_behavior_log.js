$(document).ready(function (){
  //countUP
  //管理人訪問クリック時
  $('.visit_check').click(function () {
    $(this).addClass('checked');
    const property_id = $(this).data('review-id');
    const action_name = 'manager_visit_count';
    const area_master_id =  $(this).data('area-id');
    //ajax処理スタート
    ajax(property_id, action_name, area_master_id)
  })

  ;//管理人TELクリック時
  $('.tel_check').click(function () {
    $(this).addClass('checked');
    const property_id = $(this).data('review-id');
    const action_name = 'manager_TEL_count';
    const area_master_id =  $(this).data('area-id');
    //ajax処理スタート
    ajax(property_id, action_name, area_master_id)
  });

  //一棟Cクリック時
  $('.building_check').click(function () {
    $(this).addClass('checked');
    const property_id = $(this).data('review-id');
    const action_name = 'check_building_count';
    const area_master_id =  $(this).data('area-id');
    //ajax処理スタート
    ajax(property_id, action_name, area_master_id)
  });

  function ajax(property_id, action_name, area_master_id){
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/propertyExcavationBehaviorLog/store', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'property_id': property_id,
        'action_name' : action_name,
        'area_master_id' : area_master_id,
      },
    })
        //通信成功した時の処理
        .done(function (data) {
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('通信が失敗しました。')
        });
  }

  //CountDown
  //管理人訪問クリック時
  $('.visit_checked').click(function () {
    $(this).removeClass('checked');
    const property_id = $(this).data('review-id');
    const action_name = 'manager_visit_count';
    const area_master_id =  $(this).data('area-id');
    //ajax処理スタート
    CountDownAjax(property_id, action_name, area_master_id)
  })

  ;//管理人TELクリック時
  $('.tel_checked').click(function () {
    $(this).removeClass('checked');
    const property_id = $(this).data('review-id');
    const action_name = 'manager_TEL_count';
    const area_master_id =  $(this).data('area-id');
    //ajax処理スタート
    CountDownAjax(property_id, action_name, area_master_id)
  });

  //一棟Cクリック時
  $('.building_checked').click(function () {
    $(this).removeClass('checked');
    const property_id = $(this).data('review-id');
    const action_name = 'check_building_count';
    const area_master_id =  $(this).data('area-id');
    //ajax処理スタート
    CountDownAjax(property_id, action_name, area_master_id)
  });

  function CountDownAjax(property_id, action_name, area_master_id){
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/propertyExcavationBehaviorLog/CountDown', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'property_id': property_id,
        'action_name' : action_name,
        'area_master_id' : area_master_id,
      },
    })
        //通信成功した時の処理
        .done(function (data) {
          console.log('checkok')
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('checkout')
        });
  }
});