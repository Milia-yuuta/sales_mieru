@extends('layouts.default')

@section('title', '歩留まり集計')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-aggregate" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="aggregate">歩留まり集計</p>
        <div class="c-sort">
          <form action="" method="" accept-charset="utf-8">
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
                  <input type="month" name="end_period" id="end_period" value="{{is_string($request->input('start_period')) ? \Carbon\Carbon::create($request->input('end_period'))->format('Y-m') : $request->input('end_period')->endOfMonth()->format('Y-m')}}">
                </div>
              </div>
            </div>

            <div class="f_parts" style="margin: 0 10px;">
              <span class="material-icons js-drop-choice-period" style="margin-top: 12px;">expand_more</span>
                <div class="analysis_display_modal">
                  <div class="f">
                    <div class="f_parts" data-option="style-checkbox style-tab">
                        <input type="checkbox" id="analysis_last_year" name="analysis_last_year" data-start="{{$request->input('last_year_start_period')->format('Y-m')}}" data-end="{{$request->input('last_year_end_period')->endOfMonth()->format('Y-m')}}">
                        <label for="analysis_last_year" id="last_year_elem">前年度</label>
                        <input type="checkbox" id="analysis_old" name="analysis_old" data-start="{{$request->input('before_last_year_start_period')->format('Y-m')}}" data-end="{{$request->input('before_last_year_end_period')->endOfMonth()->format('Y-m')}}">
                        <label for="analysis_old" id="old_elem">前々年度</label>
                        <input type="checkbox" id="analysis_all" name="analysis_all" data-start="{{$request->input('whole_year_start_period')}}" data-end="{{$request->input('whole_year_end_period')->endOfMonth()->format('Y-m')}}">
                        <label for="analysis_all" id="all_elem">全期間</label>
                    </div>
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
          <span class="material-icons white" style="cursor: default; opacity: 1;">info</span><a class="js-display-info">歩留まり集計の注意点</a>
        </div>
        <div class="discription-infomation">
          <div class="f_parts">
            <p>  担当顧客の線引き変更を行ったエリアは、発掘行動数・見込発生数・媒介数・見込発生率・媒介率の*整合性が取れない場合があります。線引き変更を行う前、もしくは後のみの期間で集計するなど、工夫してご活用ください。<br><br>
 
 *整合性が取れない理由： 発掘行動数は営業・hatが所属するエリアに対してカウントしています。一方、見込発生数や媒介数は営業・hatが所属するエリアに紐づいた担当顧客で発生した案件をカウントしています。担当顧客の線引き変更を行う（渡す側もらう側双方）と上記の理由から発掘行動数に増減はありませんが、見込発生数や媒介数は増減する場合があります。見込発生数や媒介数が増減すると見込発生率や媒介率も変動する為、値の整合性が取れない場合があります。</p>
          </div>
        </div>
      </div>
      <div class="body_box">
        <div class="stack">
          @include('analysis.yield.AllOfficeGraph')
        </div>
        <div style="margin-top: 15px; height: 1000px; overflow-x: hidden" id="scroll_target">
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <!-- ! エリア発掘 ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.AreaGraph')
            </div>
            <!-- ! ポスト発掘 ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.PostGraph')
            </div>
            <!-- ! 一棟C ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.BuildingGraph')
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <!-- ! 巡回現地 ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.patrol_local_information')
            </div>
            <!-- ! DM ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.DM_distribution')
            </div>
            <!-- ! チラシ手まき ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.flyer_distribution')
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <!-- ! 手紙、封書手まき ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.letter_distribution')
            </div>
            <!-- ! ランダム戸別訪問 ============================== -->
            <div class="l_4">
              @include('analysis.yield.area.random_visit')
            </div>
            <!-- ! 管理人TEL ============================== -->
            <div class="l_4">
              @include('analysis.yield.company.manager_TEL')
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <!-- ! ランダムTEL ============================== -->
            <div class="l_4">
              @include('analysis.yield.company.random_TEL')
            </div>
            <!-- ! 限定手紙、封書郵送 ============================== -->
            <div class="l_4">
              @include('analysis.yield.company.mail_letter')
            </div>
            <!-- ! チラシ宅配依頼 ============================== -->
            <div class="l_4">
              @include('analysis.yield.company.flyer_delivery')
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <!-- ! DM ============================== -->
            <div class="l_4">
              @include('analysis.yield.company.DM_mail')
            </div>
            <!-- ! 賃貸情報 ============================== -->
            <div class="l_4">
              @include('analysis.yield.company.rental_information')
            </div>
            <!-- ! DM ============================== -->
            <div class="l_4">
              @include('analysis.yield.company.building_confirmation_information')
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <div class="l_4">
              @include('analysis.yield.company.registration_information')
            </div>
            <!-- ! 郵送物戻り ============================== -->
            <div class="l_4">
              @include('analysis.yield.re.hp')
            </div>
            <!-- ! DM ============================== -->
            <div class="l_4">
              @include('analysis.yield.re.site')
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <!-- ! 賃貸情報 ============================== -->
            <div class="l_4">
              @include('analysis.yield.re.other_sales_office')
            </div>
            <div class="l_4">
              @include('analysis.yield.re.other_group_company')
            </div>
            <div class="l_4">
              @include('analysis.yield.other.business_involvement')
            </div>
          </div>
        </div>
        <div class="stack" data-option="m-30">
          <div class="l" data-space="10">
            <div class="l_4">
              @include('analysis.yield.other.free_visit')
            </div>
            <div class="l_4">
              @include('analysis.yield.other.open_room')
            </div>
            <div class="l_4">
              @include('analysis.yield.other.other')
            </div>
          </div>
        </div>
        </div>
      </div>
      <div class="foot_box" data-option="margin-m">
        @include('element.footer_analysis_index')
      </div>
    </div>
  </div>
  <script>
    window.individualReport = @json($individualReport);
  </script>
  <script src="{{mix('js/analysis/yield/index.js')}}" defer></script>
@endsection