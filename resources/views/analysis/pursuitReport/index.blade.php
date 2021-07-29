@extends('layouts.default')

@section('title', '追客レポート')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-pursuit" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="pursuit">追客レポート</p>
        <div class="c-sort">
          <form>
            <div class="f" data-option="style-row" style="margin-right: 10px">
              <div class="f_parts">
                <span class="unit" data-option="style-before">営業所</span>
                <div class="f_parts" data-option="style-select">
                  {{Form::select('office_master_id', $OfficeList, $request->input('office_master_id'),['class'=>'select2 f_parts', 'data-option'=>'style-select', 'id' => 'office_master_id'])}}
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
                  <input type="month" name="end_period" id="end_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('end_period'))->endOfMonth()->format('Y-m') : $request->input('end_period')->endOfMonth()->format('Y-m')}}">
                </div>
              </div>
            </div>
            <div class="btnarea">
              <button id="period_submit" name="" class="btn">集計</button>
            </div>
          </form>
        </div>
      </div>
{{--      {{ Form::open( ['route' => ['pursuitReport.roomList'], 'file' => true, 'method' => 'post']) }}--}}
{{--      {{Form::select('office_master_id', $OfficeList, $request->input('office_master_id'),['class'=>'select2 f_parts', 'data-option'=>'style-select'])}}--}}
{{--      <input type="month" name="start_period" id="start_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('start_period'))->format('Y-m') : $request->input('start_period')->format('Y-m')}}">--}}
{{--      <input type="month" name="end_period" id="end_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('end_period'))->endOfMonth()->format('Y-m') : $request->input('end_period')->endOfMonth()->format('Y-m')}}">--}}
{{--      {{Form::submit()}}--}}
{{--      {{Form::close()}}--}}
      <div class="body_box">
        <div class="stack">
          <div class="l" data-space="10">
            <!-- ! 判別 ============================== -->
            <div class="l_4">
              <div class="c-pursuit_report" data-option="style-discrimination">
                <div class="head">
                  <p class="ttl">判別</p>
                </div>
                <div class="body">
                  @include('analysis.pursuitReport.discrimination.body')
                </div>
                <div class="foot">
                  @include('analysis.pursuitReport.discrimination.footer')
                </div>
              </div>
            </div>
            <!-- ! 潜在 ============================== -->
            <div class="l_4">
              <div class="c-pursuit_report" data-option="style-latent">
                <div class="head">
                  <p class="ttl">潜在</p>
                </div>
                <div class="body">
                  @include('analysis.pursuitReport.latent.body')
                </div>
                <div class="foot">
                  @include('analysis.pursuitReport.latent.footer')
                </div>
              </div>
            </div>
            <!-- ! 顕在 ============================== -->
            <div class="l_4">
              <div class="c-pursuit_report" data-option="style-overt">
                <div class="head">
                  <p class="ttl">顕在</p>
                </div>
                <div class="body">
                  @include('analysis.pursuitReport.overt.body')
                </div>
                <div class="foot">
                  @include('analysis.pursuitReport.overt.footer')
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="c-table" data-option="line-wrap scroll-x">
            <table class="table" data-option="style-grid" style="width: 3600px;">
              <thead data-option="space-s">
              @include('analysis.pursuitReport.list.head')
              </thead>
              <tbody>
              @forelse($analysisData['list'] as $IndividualData)
                @include('analysis.pursuitReport.list.body')
              @empty
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="foot_box" data-option="margin-m">
        @include('element.footer_analysis_index')
      </div>
    </div>
    <!-- ! ストックグラフ ============================== -->
    <script defer>
      window.analysisData = @json($analysisData);
    </script>
    <script src="{{ mix('js/analysis/pursuit/index.js') }}" defer></script>
  </div>

  <!-- ! 該当顧客 ============================== -->
  <div class="p-stock_detail">
    <div class="head"><p class="ttl">該当顧客</p></div>
    <div class="body loader">
      <ul class="list_room">
        <li>
        </li>
      </ul>
    </div>
  </div>

  <!-- ! ストックグラフ ============================== -->
  <script>
    $('.list_chart_stock .c-count,.list_chart_yield .c-count').delay(700).queue(function(next){
      $(this).removeClass('start');
      next();
    });
  </script>
  <!-- ! ステージグラフ ============================== -->
  <script>
    $('.list_chart_yield .c-count').delay(700).queue(function(next){
      $(this).removeClass('start');
      next();
    });
  </script>
  <script>
    $(document).on('click', '.list_chart_yield .c-count', function(){
      let This = $(this),
          Tag  = $('.p-stock_detail'),
          Left = This.offset().left,
          Right = $(window).width() - This.offset().left + 20,
          Top  = This.offset().top;
      $('.p-stock_detail').removeAttr('style');
      $('.p-stock_detail').removeClass('open');
      if(Left > Right){
        Tag.css('left',Left+'px');
        Tag.css('transform','translate(-90%, 10px)');
      }else{
        Tag.css('right',Right+'px');
        Tag.css('transform','translate(110%, 10px)');
      }
      Tag.css('top',Top+'px');
      Tag.addClass('open');
    });
  </script>
  <script>
    $(document).click(function(event) {
      if($(event.target).closest('.list_chart_yield .c-count, .p-stock_detail').length) {}
      else{ $('.p-stock_detail').removeClass('open'); }
    });
  </script>
@endsection