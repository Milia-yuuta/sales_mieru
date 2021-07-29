$(function () {
  $('#prospectRemark').change(function (){
    let prospectId;
    let $this = $(this);
    prospectId = $this.data('review-id');
    let remark = $('#prospectRemark').val();
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/prospect/update', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'prospect_id': prospectId,
        'remark' : remark
      },
    })
        //通信成功した時の処理
        .done(function (data) {
          $('#flash-status-area').flash_message({
            text: '備考を保存しました。',
            how: 'append'
          });
          // $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
        })
        //通信失敗した時の処理
        .fail(function () {
          console.log('通信に失敗しました。');
        });
  });

  //備考欄用のフラッシュメッセージ
  $.fn.flash_message = function(options) {
    options = $.extend({
      text: 'Done',
      time: 750,
      how: 'before',
      class_name: ''
    }, options);
    return $(this).each(function() {
      if( $(this).parent().find('.flash_message').get(0) )
        return;
      var message = $('<span />', {
        'class': 'flash_message ' + options.class_name,
        text: options.text
      }).hide().fadeIn('fast');
      $(this)[options.how](message);
      message.delay(options.time).fadeOut('normal', function() {
        $(this).remove();
      });

    });
  };
})