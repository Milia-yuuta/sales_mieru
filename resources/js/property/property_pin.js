$(function () {
  //save
  $(document).on('click', '.target_pin', function () {
    let $this = $(this).find('.prospect_pin');
    $this.removeClass("prospect_pin")
    $(this).removeClass('target_pin');
    const pinReviewId = $this.data('review-id');
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/property/pin', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'pinReviewId': pinReviewId //いいねされた投稿のidを送る
      },
    })
        //通信成功した時の処理
        .done(function (data) {
          $this.addClass("pin");
          $this.attr('data-review-id', data);
          $this.data('review-id', data);
          $this.parent().addClass('target_pin_delete')
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('通信が失敗しました。');
        });
  });

  //delete
  $(document).on('click', '.target_pin_delete', function () {
    let $this = $(this).find('.pin');
    $this.removeClass("pin");
    $(this).removeClass('target_pin_delete');
    const pinDeleteReviewId = $this.data('review-id');
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/property/pin/delete', //通信先アドレスで、このURLをあとでルートで設定します
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
          $this.parent().addClass('target_pin')
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('fail');
        });
  });
});