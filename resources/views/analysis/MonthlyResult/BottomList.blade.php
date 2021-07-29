<div class="c-sort">
    <div class="f" data-option="style-row">
      <div class="f_parts" data-width="200">
        <span class="unit" data-option="style-before">営業所</span>
        <div class="f_parts" data-width data-option="style-select">
{{--          <x-office-select :selected="$request['office_master_id']" />--}}
          {{Form::select('office_master_id', $userMaster->OfficeList, $request->input('office_master_id'))}}
        </div>
      </div>
      <div class="f_parts">
        <span class="unit" data-option="style-before">期間</span>
        <div class="f_parts" data-option="">
          <input type="month" name="period" value="{{is_string($request->input('period')) ? \Carbon\Carbon::create($request->input('period'))->format('Y-m') : $request->input('period')->format('Y-m')}}">
        </div>
      </div>
    </div>
    <div class="btnarea">
      <button id="" name="" class="btn" style="margin-left: 10px">集計</button>
    </div>
</div>
<div class="c-table" data-option="line-wrap">
  <table class="table" data-option="style-grid">
    <thead>
    <tr>
      <th rowspan="2" data-width="60"><p>エリア</p></th>
      <th rowspan="2"><p>営業</p></th>
      <th rowspan="2"><p>hat</p></th>
      <th colspan="4" data-option="bg-green"><p>見込発生数</p></th>
      <th colspan="4" data-option="bg-blue"><p>ステージUP数</p></th>
      <th colspan="4" data-option="bg-yellow"><p>査定・訪問数等</p></th>
      <th colspan="5" data-option="bg-red"><p>媒介数</p></th>
    </tr>
    <tr>
      <th class="center"><p>判別</p></th>
      <th class="center"><p>潜在</p></th>
      <th class="center"><p>顕在</p></th>
      <th class="center" data-option="bg-green-light"><p>合計</p></th>
      <th><p>判別<br />→潜在</p></th>
      <th><p>判別<br />→顕在</p></th>
      <th><p>潜在<br />→顕在</p></th>
      <th class="center" data-option="bg-blue-light"><p>合計</p></th>
      <th class="center"><p>Web商談</p></th>
      <th><p>査定・<br />訪問等</p></th>
      <th class="center"><p>再商談</p></th>
      <th class="center" data-option="bg-orange-light"><p>合計</p></th>
      <th class="center"><p>専任</p></th>
      <th class="center"><p>売主</p></th>
      <th class="center"><p>一般</p></th>
      <th class="center"><p>専属</p></th>
      <th class="center" data-option="bg-red-light"><p>合計</p></th>
    </tr>
    </thead>
    <tbody>
    @forelse($individualReport as $report)
    <tr>
      <th><p>{{$report['TeamName']['area']}}</p></th>
      <th><p>{{$report['TeamName']['sales']}}</p></th>
      <th><p>{{$report['TeamName']['hat']}}</p></th>
      <td><p class="num">{{$report['countProspect']['discrimination']}}</p></td>
      <td><p class="num">{{$report['countProspect']['latent']}}</p></td>
      <td><p class="num">{{$report['countProspect']['overt']}}</p></td>
      <td class="total" data-option="bg-green-light"><p class="num">{{$report['countProspect']['total']}}</p></td>
      <td><p class="num">{{$report['countStageUp']['LatentFormDiscrimination']}}</p></td>
      <td><p class="num">{{$report['countStageUp']['OvertFromDiscrimination']}}</p></td>
      <td><p class="num">{{$report['countStageUp']['OvertFromLatent']}}</p></td>
      <td class="total" data-option="bg-blue-light"><p class="num">{{$report['countStageUp']['total']}}</p></td>
      <td><p class="num">{{$report['countVisit']['WebNegotiation']}}</p></td>
      <td><p class="num">{{$report['countVisit']['AssessmentNegotiation']}}</p></td>
      <td><p class="num">{{$report['countVisit']['ReNegotiation']}}</p></td>
      <td class="total" data-option="bg-orange-light"><p class="num">{{$report['countVisit']['total']}}</p></td>
      <td><p class="num">{{$report['countMediation']['DedicatedIntermediaryCount']}}</p></td>
      <td><p class="num">{{$report['countMediation']['SellerCount']}}</p></td>
      <td><p class="num">{{$report['countMediation']['panpyCount']}}</p></td>
      <td><p class="num">{{$report['countMediation']['ExclusiveCount']}}</p></td>
      <td class="total" data-option="bg-red-light"><p class="num">{{$report['countMediation']['total']}}</p></td>
    </tr>
    @empty
    @endforelse
    </tbody>
  </table>
</div>