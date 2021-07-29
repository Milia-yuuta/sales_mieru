@extends('layouts.default')

@section('title', '今日のストック')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-prospects" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="stock">今日のストック</p>
      </div>
      <div class="c-table">
      <div class="c-sort">
        {{ Form::open( ['route' => ['todayStock'], 'file' => true, 'method' => 'GET', 'enctype' => 'multipart/form-data']) }}
        @CSRF
        <div class="f" data-option="style-row">
          <div class="f_parts">
            <span class="unit" data-option="style-before">営業所</span>
            <div class="f_parts" data-option="style-select">
              {{Form::select('office_master_id', $OfficeList, $request->input('office_master_id'),['class'=>'select2 f_parts', 'data-option'=>'style-select', 'id' => 'select2_office_id'])}}
            </div>
          </div>
        </div>
        <div class="btnarea">
          <button class="btn">検索</button>
        </div>
        {{Form::close()}}
      </div>
      </div>
      <div class="body_box">
        <ul class="list_stock">
          @if(!empty($analysisDate))
          @forelse($analysisDate['analysis'] as $data)
            <li>
              <div class="c-stock">
                <div class="head_stock">
                  <p class="ttl">{{$data['OfficeName']}}営業所/{{$data['area_name']}}</p>
                  <p class="person">{{$data['sale_name']}} / {{$data['hat_name']}}</p>
                </div>
                @if($data['totalCount'] !== 0)
                  @include('analysis.todayStock.bodyStock', ['date' => $data])
                @else
                  <div class="body_stock" style="height: 225px; text-align: center;">
                    <div class="area_chart">
                      <div class="p-chart_stock">
                        <p style="line-height: 140px">該当する見込データが未登録です。</p>
                      </div>
                    </div>
                  </div>
                @endif
                  @include('analysis.todayStock.footStock', ['date' => $data])
              </div>
            </li>
          @empty
            no tasks
          @endforelse
            @endif
        </ul>
      </div>
      <div class="foot_box" data-option="margin-m">
        @include('element.footer_analysis_index')
      </div>
    </div>
  </div>

  <!-- ! 該当顧客 ============================== -->
  <div class="p-stock_detail tgetest">
    <div class="head"><p class="ttl">該当顧客</p></div>
    <div class="body loader">
      <ul class="list_room">
      </ul>
    </div>
  </div>

  <!-- ! ストックグラフ ============================== -->
  <script src="{{ asset('js/analysis/todayStock/index.js') }}" defer></script>
@endsection
