@extends('layouts.default')

@section('title', '月次結果一覧')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-monthly" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="monthly">月次結果一覧</p>
      </div>
      <form>
      <!-- ! チャート ============================== -->
      <div class="body_box">
        @include('analysis.MonthlyResult.TopGraph')
      </div>
      <!-- ! List ============================== -->
      <div class="body_box">
       @include('analysis.MonthlyResult.BottomList')
      </div>
      </form>
      <div class="foot_box" data-option="margin-m">
        @include('element.footer_analysis_index')
      </div>
    </div>
    <script src="{{ mix('js/analysis/monthResult/index.js') }}" defer></script>
  </div>
  <script>
    const officeReport = @json($officeReport);
  </script>
@endsection