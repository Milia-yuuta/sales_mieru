@extends('layouts.default')

@section('title', '発掘レポート')
@section('description', '発掘レポート')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-excavation" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="excavation">発掘レポート</p>
        <div class="c-sort">
          <form>
            <div class="f" data-option="style-row" style="margin-right: 10px">
              <div class="f_parts">
                <span class="unit" data-option="style-before">営業所</span>
                <div class="f_parts" data-option="style-select">
                  {{Form::select('office_master_id', $OfficeList, $request->input('office_master_id'),['class'=>'select2 f_parts', 'data-option'=>'style-select'])}}
                </div>
              </div>
            </div>
            <div class="f" data-option="style-row">
              <div class="f_parts">
                <span class="unit" data-option="style-before">期間</span>
                <div class="f_parts" data-option="">
                  <input type="month" name="start_period" id="start_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('start_period'))->format('Y-m') : $request->input('start_period')->format('Y-m')}}">
                </div>
                <span class="unit" data-option="style-center">~</span>
                <div class="f_parts" data-option="">
                  <input type="month" name="end_period" id="end_period" value="{{is_string($request->input('end_period')) ? \Carbon\Carbon::create($request->input('end_period'))->endOfMonth()->format('Y-m') : $request->input('end_period')->endOfMonth()->format('Y-m')}}">
                </div>
              </div>
            </div>
            <div class="btnarea">
              <button id="period_submit" name="" class="btn">集計</button>
            </div>
          </form>
        </div>
      </div>
      <div class="info-box">
        <div class="exction-info">
          <span class="material-icons white" style="cursor: default; opacity: 1;">info</span><a class="js-display-info">発掘レポートの注意点</a>
        </div>
        <div class="discription-infomation">
          <div class="f_parts">
            <p> 担当顧客の線引き変更を行ったエリアは、行動数・発生数・発生率の*整合性が取れない場合があります。線引き変更を行う前、もしくは後のみの期間で集計するなど、工夫してご活用ください。<br><br>
 *整合性が取れない理由：発掘行動数は営業・hatが所属するエリアに対してカウントしています。一方、見込発生数は営業・hatが所属するエリアに紐づいた担当顧客で発生した見込をカウントしています。担当顧客の線引き変更を行う（渡す側もらう側双方）と上記の理由から発掘行動数に増減はありませんが、見込発生数は増減する場合があります。見込発生数が増減すると見込発生率も変動する為、値の整合性が取れない場合があります。</p>
          </div>
        </div>
      </div>
      <div class="body_box">
        <div class="stack">
          <ul class="list_pie">
            {{--            営業所のトータルレポート--}}
            @include('analysis.ExactionReport.OfficeGraph')
            {{--            社員毎のレポート--}}
            @include('analysis.ExactionReport.EmployeeGraph')
          </ul>
        </div>
        <div class="stack" data-option='m-40'>
          {{--          詳細リスト--}}
          <div class="c-table" data-option="line-wrap scroll-x">
            <table class="table" data-option="style-grid" style="width: 8000px;">
              <thead data-option="space-s">
              @include('analysis.ExactionReport.ListParts.head')
              </thead>
              <tbody data-option="space-s">
              @include('analysis.ExactionReport.ListParts.body')
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="foot_box" data-option="margin-m">
        @include('element.footer_analysis_index')
      </div>
    </div>
    <script>
      const analysisData = @json($analysisData);
    </script>
    <!-- ! ストックグラフ ============================== -->
    <script src="{{ asset('js/analysis/exactionReport/index.js')}}" defer></script>
  </div>
@endsection