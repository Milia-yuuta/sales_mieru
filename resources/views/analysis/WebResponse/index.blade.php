
@extends('layouts.default')

@section('title', 'ネット反響各指標')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-net" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="net">ネット反響各指標</p>
        <div class="c-sort">
          <form>
            <div class="f" data-option="style-row">
              <div class="f_parts">
                <span class="unit" data-option="style-before">営業所</span>
                <div class="f_parts" data-option="style-select">
                  {{Form::select('office_master_id', $OfficeList, $request->input('office_master_id'),['class'=>'select2 f_parts', 'data-option'=>'style-select'])}}
                </div>
              </div>
              <div class="f_parts">
                <span class="unit" data-option="style-before">期間</span>
                <div class="f_parts" data-option="">
                  <input type="month" id="start_period" name="start_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('start_period'))->format('Y-m') : $request->input('start_period')->format('Y-m')}}">
                </div>
                <span class="unit" data-option="style-center">~</span>
                <div class="f_parts" data-option="">
                  <input type="month" id="end_period" name="end_period" value="{{is_string($request->input('end_period')) ? \Carbon\Carbon::create($request->input('end_period'))->format('Y-m') : $request->input('end_period')->format('Y-m')}}">
                </div>
              </div>
            </div>
            <div class="btnarea">
              <button id="period_submit" name="" class="btn">集計</button>
            </div>
          </form>
        </div>
      </div>
      <div class="body_box">
        <div class="c-table">
          <div class="head_table" data-flex="justify-end flex">
            @include('analysis.WebResponse.TopList')
          </div>
          <div class="body_table">
            @include('analysis.WebResponse.BottomList')
          </div>
        </div>
      </div>
      <div class="foot_box" data-option="margin-m">
        @include('element.footer_analysis_index')
      </div>
    </div>
  </div>
  <script src="{{ asset('js/analysis/webResponse/index.js') }}" defer></script>
@endsection