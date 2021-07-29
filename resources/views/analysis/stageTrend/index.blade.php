@extends('layouts.default')

@section('title', 'ステージ推移')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
@section('image', asset('img/ogp.png'))

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-stage" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="stage">ステージ推移</p>
        <div class="c-sort">
          {{ Form::open( ['route' => ['stageTrend'], 'file' => true, 'method' => 'GET', 'enctype' => 'multipart/form-data']) }}
          <div class="f" data-option="style-row">
            <div class="f_parts">
              <span class="unit" data-option="style-before">営業所</span>
              <div class="f_parts" data-option="style-select">
                {{Form::select('office_master_id', $OfficeList, $request->input('office_master_id'),['class'=>'select2 f_parts', 'data-option'=>'style-select', 'id' => 'office_master_id'])}}
              </div>
            </div>
            <div class="f_parts">
              <span class="unit" data-option="style-before">期間</span>
              <div class="f_parts" data-option="">
                <input type="month" name="start_period" id="start_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('start_period'))->format('Y-m') : $request->input('start_period')->format('Y-m')}}">
              </div>
              <span class="unit" data-option="style-center">~</span>
              <div class="f_parts" data-option="">
                <input type="month" name="end_period" id="end_period" value="{{is_string($request->input('end_period')) ? \Carbon\Carbon::create($request->input('end_period'))->subMonth()->format('Y-m') : $request->input('end_period')->format('Y-m')}}">
              </div>
            </div>
          </div>
          <div class="btnarea">
            <button id="period_submit" name="" class="btn">集計</button>
          </div>
          {{Form::close()}}
        </div>
{{--        {{ Form::open( ['route' => ['stageTrend.roomList'], 'file' => true, 'method' => 'post']) }}--}}
{{--        @CSRF--}}
{{--        {{Form::select('office_master_id', $OfficeList, $request->input('office_master_id'),['class'=>'select2 f_parts', 'data-option'=>'style-select', 'id' => 'office_master_id'])}}--}}
{{--        <input type="month" name="start_period" id="start_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('start_period'))->format('Y-m') : $request->input('start_period')->format('Y-m')}}">--}}
{{--        <input type="month" name="end_period" id="end_period" value="{{is_string($request->input('end_period')) ? \Carbon\Carbon::create($request->input('end_period'))->subMonth()->format('Y-m') : $request->input('end_period')->format('Y-m')}}">--}}
{{--        {{Form::submit()}}--}}
{{--        {{Form::close()}}--}}
      </div>
      <div class="body_box">
        <ul class="list_nav">
            @forelse($analysisData as $data)
          <li>
            <article>
              <a href="#stage_area{{$loop->index + 1}}" data-scroll></a>
              <p class="name">{{$data['user']['user_name']}} / {{$data['user']['pair_name']}}</p>
              <p class="ttl">{{$data['user']['area']}}</p>
            </article>
          </li>
          @empty
          @endforelse
        </ul>
        <ul class="list_stage">
          @forelse($analysisData as $data)
          <li id="stage_area{{$loop->index + 1}}">
            <article>
              <div class="c-stage">
                <div class="head_stage">
                  <p class="ttl">{{$data['user']['area']}}</p>
                  <p class="person">{{$data['user']['user_name']}} / {{$data['user']['pair_name']}}</p>
                </div>
                <div class="body_stage">
                  <div class="l" data-space="20">
                    @include('analysis.stageTrend.discrimination', ['date' => $data])
                    @include('analysis.stageTrend.latent', ['date' => $data])
                    @include('analysis.stageTrend.overt', ['date' => $data])
                  </div>
                </div>
                <div class="foot_stage">
                  @include('analysis.stageTrend.foot_stage')
                </div>
              </div>
            </article>
          </li>
          @empty
          @endforelse
        </ul>
      </div>
      <div class="foot_box" data-option="margin-m">
        @include('element.footer_analysis_index')
      </div>
    </div>
  </div>

  <!-- ! 該当顧客 ============================== -->
  <div class="p-stock_detail">
    <div class="head"><p class="ttl">該当顧客</p></div>
    <div class="body loader">
      <ul class="list_room">
      </ul>
    </div>
  </div>

  <!-- ! ストックグラフ ============================== -->
  <script src="{{ asset('js/analysis/stageTrend/index.js') }}" defer></script>
@endsection