<div class="p-daily_modal" id="modal_dailyReport_creat">
  <div class="c-modal" data-option="w-560">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="head">
      <p class="ttl">新規日報登録</p>
    </div>
    <form action="{{ route('dailyReport.store') }}" method="POST" accept-charset="utf-8">
      @CSRF
      {{Form::hidden('user_id', Auth::user()->id)}}
      <div class="body">
        <ul class="c-list" data-option="head-160">
          <li>
            <div class="head">
              <p class="ttl">日付</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-date">
                  <input type="text" id="prospect_datepicker" name="date" placeholder="<?php date_default_timezone_set('UTC'); echo date('Y-m-d'); ?>" autocomplete="off" required readonly>
                </div>
              </div>
            </div>
          </li>
{{--          <li>--}}
{{--            <div class="head">--}}
{{--              <p class="ttl">氏名</p>--}}
{{--            </div>--}}
{{--            <div class="cnt">--}}
{{--              <div class="f">--}}
{{--                <div class="f_parts" data-option="style-date">--}}
{{--                  {{Form::select('user_id', Auth::user()->NameArray, Auth::user()->id, ['class'=>'select2', 'disabled' => false, 'required' => 'true', 'placeholder' => '氏名予測検索'])}}--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </li>--}}
        </ul>
      </div>
      <div class="foot">
        <div class="btnarea" data-flex="justify-center">
          <button class="btn" id="daily_submit" data-option="size-l">日報を作成する</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    $('#daily_submit').click(function (){
      const date = $('#prospect_datepicker').val();
      if (!date){
        alert('日付が未選択です');
        return false;
      }
    })
  </script>
</div>