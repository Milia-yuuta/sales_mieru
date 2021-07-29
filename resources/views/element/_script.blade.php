<!-- ! スクリプト ============================== -->
<script type="text/javascript" src="{{asset('/js/remodal.js')}}"></script>

<!-- フラッシュを閉じる -->
<script>
  $(document).on('click', '.list_flash > li', function() {
      $(this).addClass('flash_remove');
    }
  );
</script>
<!-- フラッシュの表示 -->
<script>
  $(function() {
    var query = location.search;
    var value = query.split('=');
    if(decodeURIComponent(value[1]) == 'successReset' || decodeURIComponent(value[1]) == 'success_reissue' ||  decodeURIComponent(value[1]) == 'on') {
      $('.area_flash').addClass('flash_on');
    }
  });
</script>
<script>
	  $('a[data-scroll]').on('click', function(e){
		  e.preventDefault();
		  var id = $(this).attr('href');
		  var offset = ($(this).attr('data-offset') != undefined) ? parseInt($(this).attr('data-offset')): 0;
		  $("html,body").animate({scrollTop:$(id).offset().top + offset}, 1000);
		});
</script>
<!-- メニューボタン -->
<script>
  $(document).on('click', '.button_hamburger', function(){
    $(this).toggleClass('open');
    $('.list_menu').toggleClass('open');
  });
</script>
<!------ タブ ----->
<script>
  $(document).on('click', '[class*="list_tab"] > li:not(.button)', function() {
    let index = $(this).index();
    $(this).parent().find('li:not(.button)').removeClass('current_tab');
    $(this).addClass('current_tab');

    // ⑤コンテンツを一旦非表示にし、クリックされた順番のコンテンツのみを表示
    $(this).parent().parent().find('.panel_tab').removeClass('show_tab').eq(index).addClass('show_tab');
  });
</script>
<!-- テーブルリンク -->
<script>
$(function(){
  $('tbody tr[data-href]').addClass('clickable').click( function() {
      window.location = $(this).attr('data-href');
  }).find('a').hover( function() {
      $(this).parents('tr').unbind('click');
  }, function() {
      $(this).parents('tr').click( function() {
          window.location = $(this).attr('data-href');
      });
  });
});
</script>
<!-- テーブルピン -->
<script>
  $(document).on('click', 'tr[data-option] .pin', function(){
    if($(this).attr('data-option') == 'style-pin'){
      $(this).parents('tr').attr('data-option','');
    }else{
      $(this).parents('tr').attr('data-option','style-pin');
    }
  });
</script>
<!-- 表示項目 開閉 -->
<script>
  $(document).on('click', '.c-display .btn', function(){
    $('.display_modal').toggleClass('open');
  });
</script>
<script>
  $(document).click(function(event) {
    if($(event.target).closest('.c-display').length) {
    }
    // それ以外の要素をクリックした際に非表示
    else{
      $('.display_modal').removeClass('open');
    }
  });
</script>
<!-- 追客追加フォーム 開閉 -->
<script>
  $('.ProspectActionLogBtn').click(function(e){
    e.stopPropagation();
    $('#modal_prospect_action_add').addClass('open');
  });
</script>
<script>
  $('.ProspectActionLogEditBtn').click(function(){
    $('#modal_prospect_action_add').addClass('open');
  });
</script>
<script>
  $(document).click(function(event) {
    if($(event.target).closest('[data-option*="open-prospect-action-add"],.p-prospect_add,.ui-datepicker').length) {
    }
    // それ以外の要素をクリックした際に非表示
    else{
      $('.p-prospect_add').removeClass('open');
    }
  });
  $('#modal_prospect_action_close').on('click',function (){
    $('.p-prospect_action_add').removeClass('open');
  })
</script>
<!-- 次回アクション追加フォーム 開閉 -->
{{--<script>--}}
{{--  $(document).on('click', '[data-option*="open-prospect_action_add"]', function(){--}}
{{--    console.log('1');--}}
{{--    $('.p-prospect_action_add').addClass('open');--}}
{{--  });--}}
{{--</script>--}}
{{--<script>--}}
{{--  $(document).click(function(event) {--}}
{{--    if($(event.target).closest('[data-option*="open-prospect_action_add"],.p-prospect_add,.ui-datepicker').length) {--}}
{{--    }--}}
{{--    // それ以外の要素をクリックした際に非表示--}}
{{--    else{--}}
{{--      $('.p-prospect_action_add').removeClass('open');--}}
{{--    }--}}
{{--  });--}}
{{--</script>--}}
<!-- 発掘カウンタ追加フォーム 開閉 -->
<script>
  $(document).on('click', '[data-option*="open-counter-add"]', function(){
    $('.p-counter_add').addClass('open');
    $('#counter_tab').addClass('show_tab');
  });
</script>
<script>
  $(document).click(function(event) {
    if($(event.target).closest('[data-option*="open-counter-add"],.p-counter_add,.ui-datepicker,.ui-datepicker-header,.ui-corner-all').length) {
    }
    // それ以外の要素をクリックした際に非表示
    else{
      $('.p-counter_add').removeClass('open');
      $('#counter_tab').removeClass('show_tab');
      $('#counter_body_tab').removeClass('show_tab');
      $('#head_tab').addClass('current_tab');

    }
  });
</script>
<!-- 見込該当住戸リスト 開閉 -->
<script>
  $('.reaction_check').click(function(){
    let Top  = $(this).offset().top + 26,
        Left = $(this).offset().left;
    $('.property_room_modal').css('top',Top+'px').css('left',Left+'px');
    $('.property_room_modal').delay(400).queue(function(next){
       $('.property_room_modal').addClass('open');
       next();
    });
  });
  $('.assessment_check').click(function(){
    let Top  = $(this).offset().top + 26,
        Left = $(this).offset().left;
    $('.property_room_modal').css('top',Top+'px').css('left',Left+'px');
    $('.property_room_modal').delay(400).queue(function(next){
      $('.property_room_modal').addClass('open');
      next();
    });
  });
  $('.c-count').click(function(){
    let Top  = $(this).offset().top + 26,
        Left = $(this).offset().left;
    $('.property_room_modal').css('top',Top+'px').css('left',Left+'px');
    $('.property_room_modal').delay(400).queue(function(next){
      $('.property_room_modal').addClass('open');
      next();
    });
  });

</script>
<script>
  $(document).click(function(event) {
    if($(this).attr('class') === 'c-count') {
      let Top  = $(this).offset().top + 26,
          Left = $(this).offset().left;
      $('.property_room_modal').css('top',Top+'px').css('left',Left+'px');
      $('.property_room_modal').delay(400).queue(function(next){
        $('.property_room_modal').addClass('open');
        next();
      });
    }
    // それ以外の要素をクリックした際に非表示
    else{
      $('.property_room_modal').removeClass('open');
    }
  });
</script>
<!-- テーブルソート -->
{{--<script>--}}
{{--  $(document).on('click', '.button_sort', function(){--}}
{{--    let Tag  = $('.button_sort'),--}}
{{--        This = $(this);--}}
{{--    if(This.hasClass('up')){--}}
{{--      Tag.removeClass('up');--}}
{{--      Tag.removeClass('down');--}}
{{--      This.addClass('down');--}}
{{--    }else if(This.hasClass('down')){--}}
{{--      Tag.removeClass('up');--}}
{{--      Tag.removeClass('down');--}}
{{--      This.addClass('up');--}}
{{--    }else{--}}
{{--      Tag.removeClass('up');--}}
{{--      Tag.removeClass('down');--}}
{{--      This.addClass('up');--}}
{{--    }--}}
{{--  });--}}
{{--</script>--}}
<!-- 発掘カウンタ追加ボタン -->
<script>
  $(function() {
    var touched = false;
    var touch_time = 0;
    $('.count_up,.count_down').bind({
      'touchstart mousedown': function(e) {
        touched = true;
        touch_time = 0;
        const $this = $(this);
        const Tag = $(this).parents('.f_parts').find('.input_val');
        let num = Tag.val();
        document.interval = setInterval(function(e){
          num = Tag.val();
          touch_time = 100;
          if($this.attr('data-option') == 'style-count-up-hundred'){
            Tag.val(Number(num) + Number(touch_time));
          }else if($this.attr('data-option') == 'style-count-down-hundred' && num > 0 && (Number(num) - Number(touch_time)) >= 0){
            Tag.val(Number(num) - Number(touch_time));
          }
          if($this.attr('data-option') == 'style-count-up-50'){
            Tag.val(Number(num) + Number(touch_time / 2));
          }else if($this.attr('data-option') == 'style-count-down-50' && num > 0 && (Number(num) - Number(touch_time / 2)) >= 0){
            Tag.val(Number(num) - Number(touch_time / 2));
          }
          if($this.attr('data-option') == 'style-count-up-10'){
            Tag.val(Number(num) + Number(touch_time / 10));
          }else if($this.attr('data-option') == 'style-count-down-10' && num > 0 && (Number(num) - Number(touch_time / 10)) >= 0){
            Tag.val(Number(num) - Number(touch_time / 10));
          }
          if($this.attr('data-option') == 'style-count-up-5'){
            Tag.val(Number(num) + Number(touch_time / 20));
          }else if($this.attr('data-option') == 'style-count-down-5' && num > 0 && (Number(num) - Number(touch_time / 20)) >= 0){
            Tag.val(Number(num) - Number(touch_time / 20));
          }
          if($this.attr('data-option') == 'style-count-up'){
            Tag.val(Number(num) + Number(touch_time / 100));
          }else if($this.attr('data-option') == 'style-count-down' && num > 0 && (Number(num) - Number(touch_time / 100)) >= 0){
            Tag.val(Number(num) - Number(touch_time / 100));
          }
        }, 75)
        e.preventDefault();
      },
      'touchend mouseup mouseout': function(e) { // マウスが領域外に出たかどうかも拾うと、より自然
        if (touched) {
          if (touch_time < 1000 ) {
            // 短いタップでの処理
          }
        }
        touched = false;
        clearInterval(document.interval);
        e.preventDefault();
      }
    });
  });
</script>

<!-- datepicker -->
<script>
  $(function(){
    $('#counter_datepicker,#prospect_datepicker,#report_datepicker,#report_datepicker_start,#report_datepicker_end,#web_datepicker_start,#web_datepicker_end,#modal_prospect_datepicker,#next_prospect_datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
    });
    $('#prospect_action_log_datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
    });
  });
</script>

<!-- 日報スケジュール登録 -->
<script>
  $(document).on('click', '.plan_report', function(){
    let Top  = $(this).offset().top + 20,
        Left = $(this).offset().left + 20,
        Tag = $('.plan_report_add');
    Tag.addClass('open');
    Tag.css('top',Top+'px').css('left',Left+'px');
    Tag.delay(400).queue(function(next){
       Tag.addClass('open');
       next();
    });
  });
  $(document).on('click', '.result_report', function(){
    let Top  = $(this).offset().top + 20,
        Left = $(this).offset().left + 20,
        Tag = $('.result_report_add');
    Tag.addClass('open');
    Tag.css('top',Top+'px').css('left',Left+'px');
    Tag.delay(400).queue(function(next){
      Tag.addClass('open');
      next();
    });
  });
</script>
<script>
  $(document).click(function(event) {
    if($(event.target).closest('.plan_report article, .p-report_add').length) {
    }
    // それ以外の要素をクリックした際に非表示
    else{
      $('.p-report_add').removeClass('open');
    }
  });
    $(document).click(function(event) {
    if($(event.target).closest('.result_report article, .result_report_add').length) {
    }
    // それ以外の要素をクリックした際に非表示
    else{
      $('.result_report_add').removeClass('open');
    }
  });

</script>
<!-- 新規見込登録 -->
<script>
  $(document).on('click', '[data-option*="open-prospect-add"]', function(e){
    $('#modal_prospect_add').addClass('open');
  });
</script>
<script>
  $('.remodal-close').click(function (){
    $('.p-pseudo_modal').removeClass('open');
  });
</script>
<!-- 新規日報登録 -->
<script>
  $(document).on('click', '[data-option*="open-dailyReport_create"]', function(){
    $('#modal_dailyReport_creat').addClass('open');
  });
  $('.remodal-close').click(function (){
    $('#modal_dailyReport_creat').removeClass('open');
  })
</script>
<script>
  $(document).click(function(event) {
    if($(event.target).closest('.p-daily_modal.open .c-modal,[data-option*="open-dailyReport_creat"],.ui-corner-all').length) {
    }
    // それ以外の要素をクリックした際に非表示
    else{
      $('#modal_dailyReport_creat').removeClass('open');
    }
  });
</script>
<!-- 見込削除 -->
<script>
  $(document).on('click', '[data-option*="open-prospect-delete"]', function(){
    $('#modal_prospect_delete').addClass('open');
  });
</script>
<script>
  $('.remodal-close').click(function (){
    $('.p-pseudo_modal').removeClass('open');
  });
</script>

<!-- 見込削除 -->
<script>
  $('.prospectActionLogDelete').click(function(){
     const ProspectActionLogId = $(this).parents('.prospect_list').find('.ProspectActionLogId').val();
     const NextProspectActionLogId = $(this).parents('.prospect_list').find('.NextProspectActionLogId').val();
     $('.delete_prospectActionLog').val(ProspectActionLogId);
     $('.delete_nextProspectActionLog').val(NextProspectActionLogId);
    $('#modal_prospect_action_log_delete').addClass('open');
  });
</script>
<script>
  $('.remodal-prospect_action_log_delete_close').click(function (){
    $('#modal_prospect_action_log_delete').removeClass('open');
  });
</script>


