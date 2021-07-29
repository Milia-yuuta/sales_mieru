<div class="p-report_add result_report_add">
  <form action="{{route('dailyReport.ResultStore')}}" method="POST" accept-charset="utf-8" id="DailyReportResultStoreForm">
    @CSRF
    {{Form::hidden('daily_report_id', $dailyReport->id)}}
    {{Form::hidden('result_daily_report_action_log_id', NULL,['id' => 'result_daily_report_action_log_id'])}}
    <div class="body" style="overflow: hidden">
      <ul class="list_form">
        <li data-option="style-column">
          <div class="head">
            <p class="ttl">結果</p>
          </div>
          <div class="cnt">
            <div class="f" data-option="style-row">
              <div class="f_parts" data-option="style-select">
{{--                <input type="time" step="300" id="resultStartTime" name="start_time" required>--}}
                <select id="resultStartTime" name="start_time" required>
                  <option value="08:00">08:00</option>
                  <option value="08:30">08:30</option>
                  <option value="09:00">09:00</option>
                  <option value="09:30">09:30</option>
                  <option value="10:00">10:00</option>
                  <option value="10:30">10:30</option>
                  <option value="11:00">11:00</option>
                  <option value="11:30">11:30</option>
                  <option value="12:00">12:00</option>
                  <option value="12:30">12:30</option>
                  <option value="13:00">13:00</option>
                  <option value="13:30">13:30</option>
                  <option value="14:00">14:00</option>
                  <option value="14:30">14:30</option>
                  <option value="15:00">15:00</option>
                  <option value="15:30">15:30</option>
                  <option value="16:00">16:00</option>
                  <option value="16:30">16:30</option>
                  <option value="17:00">17:00</option>
                  <option value="17:30">17:30</option>
                  <option value="18:00">18:00</option>
                  <option value="18:30">18:30</option>
                  <option value="19:00">19:00</option>
                  <option value="19:30">19:30</option>
                  <option value="20:00">20:00</option>
                  <option value="20:30">20:30</option>
                  <option value="21:00">21:00</option>
                  <option value="21:30">21:30</option>
                  <option value="22:00">22:00</option>
                </select>
              </div>
              <span class="unit" data-option="style-center">〜</span>
              <div class="f_parts" data-option="style-select">
{{--                <input type="time" step="300" id="resultEndTime" name="end_time" required>--}}
                <select id="resultEndTime" name="end_time" required>
                  <option value="08:00">08:00</option>
                  <option value="08:30">08:30</option>
                  <option value="09:00">09:00</option>
                  <option value="09:30">09:30</option>
                  <option value="10:00">10:00</option>
                  <option value="10:30">10:30</option>
                  <option value="11:00">11:00</option>
                  <option value="11:30">11:30</option>
                  <option value="12:00">12:00</option>
                  <option value="12:30">12:30</option>
                  <option value="13:00">13:00</option>
                  <option value="13:30">13:30</option>
                  <option value="14:00">14:00</option>
                  <option value="14:30">14:30</option>
                  <option value="15:00">15:00</option>
                  <option value="15:30">15:30</option>
                  <option value="16:00">16:00</option>
                  <option value="16:30">16:30</option>
                  <option value="17:00">17:00</option>
                  <option value="17:30">17:30</option>
                  <option value="18:00">18:00</option>
                  <option value="18:30">18:30</option>
                  <option value="19:00">19:00</option>
                  <option value="19:30">19:30</option>
                  <option value="20:00">20:00</option>
                  <option value="20:30">20:30</option>
                  <option value="21:00">21:00</option>
                  <option value="21:30">21:30</option>
                  <option value="22:00">22:00</option>
                </select>
              </div>
            </div>
          </div>
        </li>
        <li data-option="style-column">
          <div class="head">
            <p class="ttl">大項目</p>
          </div>
          <div class="cnt">
            <div class="f">
              <div class="f_parts" data-option="style-select">
                {{Form::select('DailyReportPrimaryItem', $ActionMasterInstance->DailyReportPrimaryItem, NULL, ['id' => 'ResultPrimaryItem'])}}
              </div>
            </div>
          </div>
        </li>
        <li data-option="style-column">
          <div class="head">
            <p class="ttl">小項目</p>
          </div>
          <div class="cnt">
            <div class="f">
              <div class="f_parts" data-option="style-select">
                {{Form::select('action_master_id', $ActionMasterInstance->DailyReportTertiaryItem, NULL, ['id' => 'ResultTertiaryItem'])}}
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="foot" style="display: flex; justify-content: space-between">
      <div class="btnarea">
        <button class="btn result_submit">保存する</button>
      </div>
      <div class="btnarea">
        <button class="btn result_delete_submit display_none" style="background: indianred; color: white">削除する</button>
      </div>
    </div>
  </form>
</div>
