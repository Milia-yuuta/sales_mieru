<ul class="list_status_table">
  <li>
    <p class="ttl">新規見込</p>
    <table class="table" data-option="style-clear">
      <thead>
      <tr>
        <th><p>ステージ</p></th>
        <th class="center"><p>当日</p></th>
        <th class="center"><p>当月</p></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th><span class="stage" data-option="discrimination size-m"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" placeholder="{{$analysisUsedInDailyReports['TodayStage']['discrimination']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthStage']['discrimination']}}</span></td>
      </tr>
      <tr>
        <th><span class="stage" data-option="latent size-m"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" placeholder="{{$analysisUsedInDailyReports['TodayStage']['latent']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthStage']['latent']}}</span></td>
      </tr>
      <tr>
        <th><span class="stage" data-option="overt size-m"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" placeholder="{{$analysisUsedInDailyReports['TodayStage']['overt']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthStage']['overt']}}</span></td>
      </tr>
      </tbody>
    </table>
  </li>
  <li>
    <p class="ttl">ステージUP</p>
    <table class="table" data-option="style-clear">
      <thead>
      <tr>
        <th><p>ステージ</p></th>
        <th class="center"><p>当日</p></th>
        <th class="center"><p>当月</p></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th><span class="stage" data-option="discrimination_up size-m" style="background-color: #F2D073"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" id="" name="" value="" placeholder="{{$analysisUsedInDailyReports['TodayStageUp']['LatentForDiscrimination']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthStageUp']['LatentForDiscrimination']}}</span></td>
      </tr>
      <tr>
        <th><span class="stage" data-option="latent_up size-m"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" id="" name="" value="" placeholder="{{$analysisUsedInDailyReports['TodayStageUp']['OvertForDiscrimination']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthStageUp']['OvertForDiscrimination']}}</span></td>
      </tr>
      <tr>
        <th><span class="stage" data-option="overt_up"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" id="" name="" value="" placeholder="{{$analysisUsedInDailyReports['TodayStageUp']['OvertForLatent']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthStageUp']['OvertForLatent']}}</span></td>
      </tr>
      </tbody>
    </table>
  </li>
  <li>
    <p class="ttl">査定・商談</p>
    <table class="table" data-option="style-clear">
      <thead>
      <tr>
        <th><p>ステージ</p></th>
        <th class="center"><p>当日</p></th>
        <th class="center"><p>当月</p></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th><span class="stage" data-option="discrimination size-m"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" id="" name="" value="" placeholder="{{$analysisUsedInDailyReports['TodayOpportunity']['discrimination']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthOpportunity']['discrimination']}}</span></td>
      </tr>
      <tr>
        <th><span class="stage" data-option="latent size-m"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" id="" name="" value="" placeholder="{{$analysisUsedInDailyReports['TodayOpportunity']['latent']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthOpportunity']['latent']}}</span></td>
      </tr>
      <tr>
        <th><span class="stage" data-option="overt size-m"></span></th>
        <td><div class="f"><div class="f_parts" data-width="100"><input type="text" id="" name="" value="" placeholder="{{$analysisUsedInDailyReports['TodayOpportunity']['overt']}}" class="num right" data-option="style-min" disabled></div></div></td>
        <td><span class="c-count" data-option="default size-m" data-flex="justify-end" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthOpportunity']['overt']}}</span></td>
      </tr>
      </tbody>
    </table>
  </li>
  <li>
    <p class="ttl">媒介</p>
    <table class="table" data-option="style-clear">
      <thead>
      <tr>
        <th data-width="40"></th>
        <th class="center"><p>専任</p></th>
        <th class="center"><p>売主</p></th>
        <th class="center"><p>一般</p></th>
        <th class="center"><p>専属</p></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th><p>当月</p></th>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthMediation']['FullTime']}}</span></td>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthMediation']['Seller']}}</span></td>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthMediation']['panpy']}}</span></td>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['ToMonthMediation']['Exclusive']}}</span></td>
      </tr>
      <tr>
        <th><p>半期</p></th>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['HalfPeriodMediation']['FullTime']}}</span></td>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['HalfPeriodMediation']['Seller']}}</span></td>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['HalfPeriodMediation']['panpy']}}</span></td>
        <td><span class="c-count" data-option="mediation size-l" style="cursor: auto">{{$analysisUsedInDailyReports['HalfPeriodMediation']['Exclusive']}}</span></td>
      </tr>
      </tbody>
    </table>
  </li>
</ul>