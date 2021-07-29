<div class="p-prospect_action_add" id="modal_prospect_action_add" style="max-width: 1000px">
  <button data-remodal-action="close" class="remodal-close" id="modal_prospect_action_close"></button>
  <form action="{{route('prospectActionLog.store')}}" method="POST" accept-charset="utf-8" id="ProspectActionLogEditForm">
    @CSRF
    {{Form::hidden('user_id', Auth::user()->id)}}
    {{Form::hidden('prospect_id', NULL, ['id' => 'ProspectActionLogProspect_id'])}}
    {{Form::hidden('next[prospect_id]', NULL, ['id' => 'NextProspectActionLogProspect_id'])}}
    {{Form::hidden('ProspectActionLog_id', NULL, ['id' => 'ProspectActionLog_id'])}}
    {{Form::hidden('next[NextProspectActionLog_id]', NULL, ['id' => 'NextProspectActionLog_id'])}}
    <div class="head" style="margin: 15px">
      <span class="stage" id="stageCss" data-option="latent" style="margin: 15px 0; width: 60px;"></span>
      <a class="btn stage_display_btn"  data-option="size-m" style="width: 100px; margin: 0 15px; padding: 0 5px; background: white; color: #3B96DD">ステージ切替</a>
      <div class="f stage_display">
        <div class="f_parts">
          <span class="unit" data-option="style-before">ステージ変更</span>
          <div class="f_parts" data-option="style-select" data-width="200">
            {{Form::select('stage_action_master_id', $ActionMasterInstance->ModalStageList, old($request->StageList), ['id' => 'ProspectActionLogStage'])}}
          </div>
        </div>
      </div>
      <div class="f">
        <div class="f_parts">
          <span class="unit" data-option="style-before">ステータス変更</span>
          <div class="f_parts" data-option="style-select" data-width="200">
            {{Form::select('status_action_master_id', $ActionMasterInstance->AllStatusList, NULL, ['id' => 'ProspectActionLogStatus'])}}
          </div>
        </div>
      </div>
    </div>
    <div class="body">
      <div class="area_tab" style="display: flex">
{{--        <ul class="list_tab_button">--}}
{{--          <li class=""><div class="" data-option="size-s">追客行動</div></li>--}}
{{--          <li><div class="" data-option="size-s">次回アクション</div></li>--}}
{{--        </ul>--}}
        <div class="action_log_area" style="width: 400px; padding: 0 15px; background-color: whitesmoke; margin-right: 15px">
          <div class="stack">
            <div data-flex="align-center" style="display: flex; justify-content: space-between; margin-bottom: 15px">
              <p class="ttl">追客行動</p>
              <div class="f">
                <div class="f_parts">
                  <span class="ttl" data-option="style-before" style="margin-right: 5px">日付</span>
                  <div class="f_parts" data-option="style-date">
                    <input type="text" style="margin-top: 10px" id="prospect_action_log_datepicker" name="date" placeholder="<?php date_default_timezone_set('Asia/Tokyo'); echo date('Y.m.d'); ?>" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" autocomplete="off" readonly required>
                  </div>
                </div>
              </div>
            </div>
            <ul class="list_prospect_add list_prospect_action_add">
              <li>
                <p class="ttl">追客</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="hidden" id="" name="TEL_home" value="0">
                    <input type="checkbox" id="TEL_home" name="TEL_home" value="1">
                    <label for="TEL_home">見込TEL</label>
                    <input type="hidden" id="" name="send_letter" value="0">
                    <input type="checkbox" id="send_letter" name="send_letter" value="1">
                    <label for="send_letter">手紙送付</label>
                    <input type="hidden" id="" name="local_letter" value="0">
                    <input type="checkbox" id="local_letter" name="local_letter" value="1">
                    <label for="local_letter">現地手紙</label>
                    <input type="hidden" id="" name="visit" value="0">
                    <input type="checkbox" id="visit" name="visit" value="1">
                    <label for="visit">戸別訪問在宅</label>
                    <input type="hidden" id="" name="email" value="0">
                    <input type="checkbox" id="email" name="email" value="1">
                    <label for="email">メール送信</label>
                    <input type="hidden" id="" name="pursuit_other" value="0">
                    <input type="checkbox" id="pursuit_other" name="pursuit_other" value="1">
                    <label for="pursuit_other">その他</label>
                  </div>
                </div>
              </li>
              <li>
                <p class="ttl">商談</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="hidden" id="" name="send_assessment_report" value="0">
                    <input type="checkbox" id="send_assessment_report" name="send_assessment_report" value="1">
                    <label for="send_assessment_report">査定書送付</label>
                    <input type="hidden" id="" name="assessment_report_email" value="0">
                    <input type="checkbox" id="assessment_report_email" name="assessment_report_email" value="1">
                    <label for="assessment_report_email">査定書メール</label>
                    <input type="hidden" id="" name="web_negotiation" value="0">
                    <input type="checkbox" id="web_negotiation" name="web_negotiation" value="1">
                    <label for="web_negotiation">Web商談</label>
                    <input type="hidden" id="" name="assessment_negotiation" value="0">
                    <input type="checkbox" id="assessment_negotiation" name="assessment_negotiation" value="1">
                    <label for="assessment_negotiation">査定・商談</label>
                    <input type="hidden" id="" name="re-negotiation" value="0">
                    <input type="checkbox" id="re-negotiation" name="re-negotiation" value="1">
                    <label for="re-negotiation">再商談</label>
                  </div>
                </div>
              </li>
              <li>
                <p class="ttl">調査</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="hidden" id="" name="visit_caretaker" value="0">
                    <input type="checkbox" id="visit_caretaker" name="visit_caretaker" value="1">
                    <label for="visit_caretaker">管理人訪問</label>
                    <input type="hidden" id="" name="TEL_caretaker" value="0">
                    <input type="checkbox" id="TEL_caretaker" name="TEL_caretaker" value="1">
                    <label for="TEL_caretaker">管理人TEL</label>
                    <input type="hidden" id="" name="on-site_check" value="0">
                    <input type="checkbox" id="on-site_check" name="on-site_check" value="1">
                    <label for="on-site_check">現地チェック</label>
                    <input type="hidden" id="" name="research_other" value="0">
                    <input type="checkbox" id="research_other" name="research_other" value="1">
                    <label for="research_other">その他</label>
                  </div>
                </div>
              </li>
              <li>
                <p class="ttl">お客様より</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="hidden" id="" name="re_TEL" value="0">
                    <input type="checkbox" id="re_TEL" name="re_TEL" value="1">
                    <label for="re_TEL">TEL</label>
                    <input type="hidden" id="" name="re_email" value="0">
                    <input type="checkbox" id="re_email" name="re_email" value="1">
                    <label for="re_email">メール</label>
                    <input type="hidden" id="" name="re_letter" value="0">
                    <input type="checkbox" id="re_letter" name="re_letter" value="1">
                    <label for="re_letter">手紙・FAX</label>
                    <input type="hidden" id="" name="re_hp" value="0">
                    <input type="checkbox" id="re_hp" name="re_hp" value="1">
                    <label for="re_hp">当社HP反響</label>
                    <input type="hidden" id="" name="re_site" value="0">
                    <input type="checkbox" id="re_site" name="re_site" value="1">
                    <label for="re_site">一括査定サイト</label>
                    <input type="hidden" id="" name="re_other" value="0">
                    <input type="checkbox" id="re_other" name="re_other" value="1">
                    <label for="re_other">その他</label>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="stack" style="padding-bottom: 15px">
            <p class="ttl">結果</p>
            <div class="f">
              <div class="f_parts">
                <textarea  name="result" id="result" placeholder="追客による結果を記述"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="_next_action_log_area" style="width: 400px; padding: 0 15px; background-color: whitesmoke" >
          <div class="stack next_action_log_stack">
            <div data-flex="align-center" style="display: flex; justify-content: space-between; margin-bottom: 15px">
              <p class="ttl">次回アクション</p>
              <div class="f">
                <div class="f_parts">
                  <span class="ttl" data-option="style-before" style="margin-right: 5px">日付</span>
                  <div class="f_parts" data-option="style-date">
                    <input type="text" style="margin-top: 10px" id="next_prospect_datepicker" name="next[next_action_date]" placeholder="<?php date_default_timezone_set('Asia/Tokyo'); echo date('Y-m-d'); ?>" value="" autocomplete="off" readonly>
                  </div>
                </div>
              </div>
            </div>
            <ul class="list_prospect_add">
              <li>
                <p class="ttl">追客</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="hidden" id="" name="next[TEL_home]" value="0">
                    <input type="checkbox" id="next_TEL_home" name="next[TEL_home]" value="1">
                    <label for="next_TEL_home">見込TEL</label>
                    <input type="hidden" id="" name="next[send_letter]" value="0">
                    <input type="checkbox" id="next_send_letter" name="next[send_letter]" value="1">
                    <label for="next_send_letter">手紙送付</label>
                    <input type="hidden" id="" name="next[local_letter]" value="0">
                    <input type="checkbox" id="next_local_letter" name="next[local_letter]" value="1">
                    <label for="next_local_letter">現地手紙</label>
                    <input type="hidden" id="" name="next[visit]" value="0">
                    <input type="checkbox" id="next_visit" name="next[visit]" value="1">
                    <label for="next_visit">戸別訪問</label>
                    <input type="hidden" id="" name="next[email]" value="0">
                    <input type="checkbox" id="next_email" name="next[email]" value="1">
                    <label for="next_email">メール送信</label>
                    <input type="hidden" id="" name="next[pursuit_other]" value="0">
                    <input type="checkbox" id="next_pursuit_other" name="next[pursuit_other]" value="1">
                    <label for="next_pursuit_other">その他</label>
                  </div>
                </div>
              </li>
              <li>
                <p class="ttl">商談</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="hidden" id="" name="next[assessment_report_email]" value="0">
                    <input type="checkbox" id="next_assessment_report_email" name="next[assessment_report_email]" value="1">
                    <label for="next_assessment_report_email">査定書送付</label>
                    <input type="hidden" id="" name="next[send_assessment_report]" value="0">
                    <input type="checkbox" id="next_send_assessment_report" name="next[send_assessment_report]" value="1">
                    <label for="next_send_assessment_report">査定書メール</label>
                    <input type="hidden" id="" name="next[web_negotiation]" value="0">
                    <input type="checkbox" id="next_web_negotiation" name="next[web_negotiation]" value="1">
                    <label for="next_web_negotiation">Web商談</label>
                    <input type="hidden" id="" name="next[assessment_negotiation]" value="0">
                    <input type="checkbox" id="next_assessment_negotiation" name="next[assessment_negotiation]" value="1">
                    <label for="next_assessment_negotiation">査定・商談</label>
                    <input type="hidden" id="" name="next[re-negotiation]" value="0">
                    <input type="checkbox" id="next_re-negotiation" name="next[re-negotiation]" value="1">
                    <label for="next_re-negotiation">再商談</label>
                  </div>
                </div>
              </li>
              <li>
                <p class="ttl">調査</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                    <input type="hidden" id="" name="next[visit_caretaker]" value="0">
                    <input type="checkbox" id="next_visit_caretaker" name="next[visit_caretaker]" value="1">
                    <label for="next_visit_caretaker">管理人訪問</label>
                    <input type="hidden" id="" name="next[TEL_caretaker]" value="0">
                    <input type="checkbox" id="next_TEL_caretaker" name="next[TEL_caretaker]" value="1">
                    <label for="next_TEL_caretaker">管理人TEL</label>
                    <input type="hidden" id="" name="next[on-site_check]" value="0">
                    <input type="checkbox" id="next_on-site_check" name="next[on-site_check]" value="1">
                    <label for="next_on-site_check">現地チェック</label>
                    <input type="hidden" id="" name="next[research_other]" value="0">
                    <input type="checkbox" id="next_research_other" name="next[research_other]" value="1">
                    <label for="next_research_other">その他</label>
                  </div>
                </div>
              </li>
{{--              <li>--}}
{{--                <p class="ttl">お客様より</p>--}}
{{--                <div class="f">--}}
{{--                  <div class="f_parts" data-option="style-checkbox" data-flex="wrap">--}}
{{--                    <input type="checkbox" id="next_re_TEL" name="next[re_TEL]" value="1">--}}
{{--                    <label for="next_re_TEL">TEL</label>--}}
{{--                    <input type="checkbox" id="next_re_email" name="next[re_email]" value="1">--}}
{{--                    <label for="next_re_email">メール</label>--}}
{{--                    <input type="checkbox" id="next_re_letter" name="next[re_letter]" value="1">--}}
{{--                    <label for="next_re_letter">手紙・FAX</label>--}}
{{--                    <input type="checkbox" id="next_re_hp" name="next[re_hp]" value="1">--}}
{{--                    <label for="next_re_hp">当社HP反響</label>--}}
{{--                    <input type="checkbox" id="next_re_site" name="next[re_site]" value="1">--}}
{{--                    <label for="next_re_site">一括査定サイト</label>--}}
{{--                    <input type="checkbox" id="next_re_other" name="next[re_other]" value="1">--}}
{{--                    <label for="next_re_other">その他</label>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </li>--}}
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="foot">
      <div class="btnarea">
        <button class="btn prospect_action_log_submit" data-option="w-full" id="prospect_action_log_submit">追客登録</button>
        <button class="btn first_btn" data-option="w-full" id="" style="display: none">追客登録</button>
        <button class="btn" data-option="w-full" id="next_action_clear">次回アクションをクリア</button>
      </div>
    </div>
  </form>
  <script>
    const now = @json(\Carbon\Carbon::now()->format('Y-m-d'));
    $('#prospect_action_log_datepicker').on('change', function(){
      if ($(this).val() > now){
        $(this).val('')
        alert('未来の日付が選択されています。');
      }
    });
    $('.ProspectActionLogBtn').click(function (){
      $('.stage_display').addClass('display_none');
    })
    $('.stage_display_btn').click(function (){
      $('.stage_display').removeClass('display_none');
    })
    $('.firstActionBtn').click(function (){
      $('.list_prospect_action_add').css('visibility', 'hidden');
      $('.next_action_log_stack').css('visibility', 'hidden');
      $('#next_action_clear').css('visibility', 'hidden');
      $('.first_btn').css('display', '');
      $('.prospect_action_log_submit').css('display', 'none');

    });
    $('.ProspectActionLogLogBtn').click(function (){
      $('.list_prospect_action_add').css('visibility', '');
      $('.next_action_log_stack').css('visibility', '');
      $('#next_action_clear').css('visibility', '');
      $('.first_btn').css('display', 'none');
      $('.prospect_action_log_submit').css('display', '');
    });
  </script>
</div>
