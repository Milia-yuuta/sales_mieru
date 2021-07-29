$(function () {
  //save
  $(document).on('click', '.pin_target',function (e) {
    e.stopPropagation();
    let $this = $(this).find('.prospect_pin');
    $(this).removeClass('pin_target');
    $this.removeClass("prospect_pin")
    const pinReviewId = $this.data('review-id');
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/prospect/pin', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'pinReviewId': pinReviewId //いいねされた投稿のidを送る
      },
    })
        //通信成功した時の処理
        .done(function (data) {
          $($this.parent()).addClass("pin_target_delete");
          $this.addClass("pin");
          $this.parents('.prospect_list').attr('data-option', "style-pin");
          $this.parents('.prospect_list').data('option', "style-pin");
          $this.attr('data-review-id', data);
          $this.data('review-id', data);
          return false;
        })
        //通信失敗した時の処理
        .fail(function () {
          $(this).addClass('pin_target');
          $this.addClass("prospect_pin")
          console.log('通信が失敗しました。')
          console.log('fail');
        });
  });

  //delete
  $(document).on('click', '.pin_target_delete',function (e) {
    e.stopPropagation();
    let $this = $(this).find('.pin');
    $(this).removeClass('pin_target_delete');
    $this.removeClass("pin")
    const pinDeleteReviewId = $this.data('review-id');
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/prospect/pin/delete', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'post', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'pinReviewId': pinDeleteReviewId //いいねされた投稿のidを送る
      },
    })
        //通信成功した時の処理
        .done(function (data) {
          $this.addClass("prospect_pin")
          $this.attr('data-review-id', data);
          $this.data('review-id', data);
          $($this.parent()).addClass('pin_target');
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('fail');
        });
  });
});