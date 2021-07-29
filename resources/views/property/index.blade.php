@extends('layouts.default')
@section('title', '顧客リスト')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-mansions" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="mansions">顧客リスト</p>
        <div class="btnarea">
          <a class="btn excavation_btn" data-option="style-counter open-counter-add">発掘カウンタ</a>
          <a class="btn" data-option="style-add" data-remodal-target="modal_mansion_add">新規顧客登録</a>
        </div>
      </div>
      @include('element.error.validate_error')
      <div class="body_box">
        {{ Form::open( ['route' => ['property'], 'method' => 'GET', 'class' => 'SortForm']) }}
        <div class="c-table">
          <div class="c-sort">
            <div class="f" data-option="style-row">
              <div class="f_parts">
                <span class="unit" data-option="style-before">営業所</span>
                <div class="f_parts" data-option="style-select" data-width>
                  {{Form::select('office_master_id', $UserMaster->OfficeList, $request->office_master_id, ['id' => ''])}}
                </div>
              </div>
              <div class="f_parts" >
                <span class="unit" data-option="style-before">エリア</span>
                <div class="f_parts" data-option="style-select" data-width>
                  {{Form::select('area_master_id', $ActionMasterInstance->AreaList, $request->area_master_id, ['id' => ''])}}
                </div>
              </div>
              <div class="f_parts">
                {{Form::text('SearchWord',$request->SearchWord,['placeholder'=>'顧客名/住所'])}}
              </div>
            </div>
            <div class="btnarea" style="margin-left: 2px">
              <button id="" name="" class="btn">検索</button>
            </div>
            <div class="btn" style="margin-left: 10px; width: 100px;">
              <a class="btn" style="background: white; color: #3B96DD;" href="{{route('property')}}">リセット</a>
            </div>
          </div>
          <table class="table">
            <thead style="display: block">
            <tr>
              <th style="width: 40px;"><p></p></th>
              <th style="width: 230px;"><p>顧客名</p> @include('element.sort_btn',['SortValue' => 'PropertyNameSort', 'request' => $request])
                <p>住所</p>@include('element.sort_btn',['SortValue' => 'PropertyAddressSort', 'request' => $request])</th>
              <th style="width: 220px;"><p>アクセス</p> @include('element.sort_btn',['SortValue' => 'PropertyAccessSort', 'request' => $request])</th>
              <th style="width: 110px;"><p>管理人<br />訪問</p>@include('element.sort_btn',['SortValue' => 'PropertyVisitSort', 'request' => $request])</th>
              <th style="width: 110px;" ><p>管理人<br />TEL</p>@include('element.sort_btn',['SortValue' => 'PropertyTelSort', 'request' => $request])</th>
              <th style="width: 110px;"><p>一棟C</p> @include('element.sort_btn',['SortValue' => 'PropertyCheckSort', 'request' => $request])</th>
              <th style="width: 70px;"><p>判別</p></th>
              <th style="width: 70px;"><p>潜在</p></th>
              <th style="width: 70px;"><p>顕在</p></th>
            </tr>
            </thead>
            <tbody style="display: block; overflow-y: scroll; height: 470px;">
            @forelse($searchProperties as $property)
              @include('property.property_list')
            @empty
            @endforelse
            </tbody>
          </table>
            @include('element.pagenation.pagenation', ['PageNationInstance' => $searchProperties])
        </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
  <!-- ! 住戸リスト ============================== -->
  <!-- ! 該当顧客 ============================== -->
  <div class="p-stock_detail property_room_modal">
    <div class="head"><p class="ttl">該当顧客</p></div>
    <div class="body">
      <ul class="list_room">
      </ul>
    </div>
  </div>
  <script type="text/javascript" src="{{asset('/js/property/index.js')}}"></script>
  @include('element.modal._modal_mansion_add')
  @include('element._counter_add')
@endsection
