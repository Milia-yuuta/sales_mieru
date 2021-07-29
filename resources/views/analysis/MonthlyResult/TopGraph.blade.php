<div class="p-chart">
  <div class="c-sort">
      <div class="f" data-option="style-row">
        <div class="f_parts" data-width="200">
          <span class="unit" data-option="style-before">営業所</span>
          <div class="f_parts" data-width data-option="style-select">
            {{Form::select('top_office_id', $UserMaster->OfficeList, $request->top_office_id, ['id' => 'top_office_id'])}}
          </div>
        </div>
        <div class="f_parts" data-width="200">
          <span class="unit" data-option="style-before">担当者</span>
          <div class="f_parts" data-width data-option="style-select">
            {{Form::select('team_id', $TeamArrayReturnAction, $request->team_id, ['id' => 'top_user_id', 'data-option' => $request->team_id])}}
          </div>
        </div>
        <div class="f_parts">
          <span class="unit" data-option="style-before">期間</span>
          <div class="f_parts" data-option="">
            <input type="month" name="start_period" id="start_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('start_period'))->format('Y-m') : $request->input('start_period')->format('Y-m')}}">
          </div>
          <span class="unit" data-option="style-center">~</span>
          <div class="f_parts" data-option="">
            <input type="month" name="end_period" id="end_period" value="{{is_string($request->input('end_period')) ? \Carbon\Carbon::create($request->input('end_period'))->format('Y-m') : $request->input('end_period')->endOfMonth()->format('Y-m')}}">
          </div>
        </div>
      </div>
      <div class="btnarea">
        <button id="period_submit" name="" class="btn" style="margin-left: 10px">集計</button>
      </div>
  </div>
  <div class="f_parts" data-width="200" style="display: flex; justify-content: center">
    <p class="unit">{{\App\Models\UserMaster::find(\App\Models\Team::find($request->team_id)->office_master_id)->name}}営業所</p>
    <p class="unit" style="margin-left: 10px">{{\App\Models\Team::find($request->team_id)->area->action_name}}</p>
    <p class="unit" style="margin-left: 10px">{{\App\Models\Team::find($request->team_id)?->sale?->sei}}　/　{{\App\Models\Team::find($request->team_id)?->hat?->sei}}</p>

  </div>
  <div class="area_chart">
    <canvas id="monthly_bar" height="100"></canvas>
  </div>
  <script>
    $('#period_submit').click(function (){
      const start_period = new Date($('#start_period').val());
      const end_period = new Date($('#end_period').val());
      console.log(start_period);
      console.log(end_period);
      console.log(start_period > end_period);
      if(start_period > end_period){
        alert('日付が矛盾しています。')
        return false;
      }
    });
  </script>
</div>