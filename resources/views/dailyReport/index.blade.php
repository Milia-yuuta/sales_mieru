@extends('layouts.default')

@section('title', '日報')
@section('description', 'ダッシュボード')
@section('ogtitle', ' 日報')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-reports" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl">日報</p>
        <div class="btnarea">
          <a class="btn" data-option="style-add open-dailyReport_create" data-ico="report">日報を作成</a>
        </div>
      </div>
      <div class="body_box">
        <div class="c-table">
          <div class="c-sort">
            {{ Form::open( ['route' => ['dailyReport'], 'method' => 'GET', 'autocomplete' => 'off']) }}
            @CSRF
            <div class="f" data-option="style-row">
              <div class="f_parts" data-option="style-column">
                <span class="unit" data-option="style-before">営業所</span>
                <div class="f_parts" data-option="style-select" data-width>
                  {{Form::select('office', $UserMaster->OfficeList, $request->office, ['id' => 'office_select', 'class' => 'select2'])}}
                </div>
              </div>
              <div class="f_parts">
                <a class="arrow_s js-week-sub-button" data-action="weekSub" data-date="{{ $DailyReportList['date'][0]['date'] }}" style="height: 100%; color:#3B96DD; transform: scaleX(-1); top: 7px;"></a>
              </div>
              <div class="f_parts" data-option="style-column">
                <span class="unit" data-option="style-before">日付</span>
                <div class="f_parts" data-option="style-date">
                  <input type="text" id="report_datepicker_start" name="start_period" value="{{$request->input('start_period')}}" autocomplete="off" readonly>
                </div>
              </div>
              <span class="unit" data-option="style-center" style="margin-top: 10px">~</span>
              <div class="f_parts" data-option="style-column">
                <span class="unit" data-option="style-before">　　</span>
                <div class="f_parts" data-option="style-date">
                  <input type="text" id="report_datepicker_end" name="end_period" value="{{$request->input('end_period')}}" autocomplete="off" readonly>
                </div>
              </div>
              <div class="f_parts" style="margin-right: 10px;">
                <a class="arrow_s js-week-add-button" data-action="weekAdd" data-date="{{ $DailyReportList['date'][0]['date'] }}" style="height: 100%; color:#3B96DD; top: 7px;"></a>
              </div>
            </div>
            <div class="btnarea" style="margin-left: 10px; margin-top: 15px">
              <button class="btn daily_search_btn">検索</button>
            </div>
            <div class="btnarea" style="margin-left: 4px; width: 100px; margin-top: 15px">
              <a class="btn" style="background: white; color: #3B96DD;" href="{{route('dailyReport')}}">リセット</a>
            </div>
            {{Form::close()}}
          </div>
          <div class="p-table">
            <div class="p-table__head">
              <div class="p-table__head__date" style="border-right: none">
                <div class="p-table__head__user">
                  <p class="area">担当エリア</p>
                  <p class="user">担当者名</p>
                </div>
              </div>
              <div class="p-table__head__contents">
                @forelse($DailyReportList['reports'] as $DailyReports)
                  <div class="p-table__head__user">
                    <p class="area">@forelse(\App\Models\User::find(array_keys($DailyReports))->first()->AllAreaSearchName as $name){{str_replace('エリア', '', $name)}}　 @empty エリア無し @endforelse</p>
                    <p class="user">{{\App\Models\User::find(array_keys($DailyReports))->first()->sei}}</p>
                  </div>
                @empty
                @endforelse
              </div>
            </div>
            <div class="p-table__body">
              <div class="p-table__body__date">
                @foreach($DailyReportList['date'] as $date)
                  <p class="date">{{$date['date']}}</p>
                @endforeach
              </div>
              <div class="p-table__body__contents">
                @forelse($DailyReportList['reports'] as $DailyReports)
                  @foreach($DailyReports as $DailyReport)
                  <div class="p-table__body__user">
                    @foreach($DailyReport as $report)
                      @if($report['unreachableDate'] === 1)
                        @if(isset($report['id']))
                        <a style="background: darkgrey; color: gray" href="{{route('dailyReport.show', $report['id'])}}">-</a>
                        @else
                          <p style="background: darkgrey; color: gray">×</p>
                          @endif
                      @elseif(empty($report['id']))
                        <p class="notCreated">×</p>
                      @elseif($report['plan_check'] === 0)
                        <a href="{{route('dailyReport.show', $report['id'])}}" class="unregistered">-</a>
                      @elseif($report['plan_check'] === 1 && $report['result_check'] === 0)
                        <a href="{{route('dailyReport.show', $report['id'])}}" class="filledIn">◯</a>
                      @elseif($report['plan_check'] === 1 && $report['result_check'] === 1)
                        <a href="{{route('dailyReport.show', $report['id'])}}" class="done">◎</a>
                      @endif
                    @endforeach
                  </div>
                  @endforeach
                @empty
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('element._dailyReport_create')
  <script src="{{ asset('js/dailyReport/index/index.js') }}" defer></script>
@endsection