@extends('layouts.default')

@section('title', '予定編集')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-reports" data-box-option="space_min">
      <div class="head_box">
        <a class="c-back" href="{{route('dailyReport') }}"></a>
        <p class="ttl" id="daily_report_date">{{$dailyReport->date->format('Y-m-d')}}</p>
        <p style="font: 600 25px/1em 'Noto Sans JP',sans-serif;color: #444;display: flex; align-items: center;">　{{$dailyReport->user->sei}}{{$dailyReport->user->mei}}</p>
        <div class="btnarea">
          <div style="display: flex">
            {{ Form::open( ['route' => ['dailyReport.edit'],'method' => 'POST', 'style' => 'width:160px;'])}}
            {{Form::hidden('id', $dailyReport->id)}}
            @if($dailyReport->plan_check === 1)
              {{Form::hidden('plan_check', 0)}}
              <button class="btn" style="background: #ECF0F4; border: none; color: #5E6B76;">予定の入力済を取消</button>
            @else
              {{Form::hidden('plan_check', 1)}}
              <button class="btn" style="background: white; color: #3B96DD;">予定を入力済にする</button>
            @endif
            {{Form::close()}}

            {{ Form::open( ['route' => ['dailyReport.edit'],'method' => 'POST', 'style' => 'width:160px;']) }}
            {{Form::hidden('id', $dailyReport->id)}}
            @if($dailyReport->result_check === 1)
              {{Form::hidden('result_check', 0)}}
              <button class="btn"  style="background: #ECF0F4; border: none; color: #5E6B76;">結果の入力済を取消</button>
            @else
              {{Form::hidden('result_check', 1)}}
              <button class="btn" style="background: white; color: #3B96DD;">結果を入力済にする</button>
            @endif
            {{Form::close()}}
          </div>
          <a class="btn excavation_btn" id="daily_report_excavation" data-option="style-counter open-counter-add">発掘カウンタ</a>
        </div>
      </div>
      @include('element.error.validate_error')
      <div class="body_box">
        <div class="l" data-space="30">
          <div class="l_fix" style="width: 400px;">
            @include('dailyReport.ShowColumn.time_list')
          </div>
          <div class="l_auto">
            <div class="box" data-box-option="space_min">
              @include('dailyReport.ShowColumn.prospect_list')
              <div class="body_box">
                @include('dailyReport.ShowColumn.prospect_status_list')
              </div>
            </div>
          </div>
        </div>
        <div class="l" data-space="m-40">
          @include('dailyReport.ShowColumn.analysis_date_list')
        </div>
      </div>
      <div class="foot_box">
      </div>
    </div>
  </div>
  @include('element._counter_add')
  @include('element._report_plan_add')
  @include('element._report_result_add')
  @include('element._prospect_action_add')
  <script>
    const dailyReportId = @json($dailyReport->id);
    const planCheck = @json($dailyReport->plan_check);
    const resultCheck = @json($dailyReport->result_check);
    let PlanTimeList = @json($PlanTimeList);
    let resultTimeList = @json($ResultTimeList);
  </script>
  <script src="{{ asset('js/dailyReport/show/index.js') }}" defer></script>
  <script>
    $(document).ready(function (){
      $('#counter_datepicker').val($('#daily_report_date').text());
    })
  </script>
@endsection
