@extends('layouts.default')

@section('title', 'ラベル・CSV発行')
@section('description', 'ダッシュボード')
@section('ogtitle', 'ラベル・CSV発行')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container" style="max-width: 1200px">
    <div class="box" data-option="style-page" data-page="page-prospects" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="prospects">ラベル・CSV発行</p>
      </div>
      <form class="SortForm">
        <div class="body_box">
          <div class="c-table">
            <div class="c-sort" data-flex="align-end">
              <div class="f" data-option="style-row style-thin" data-flex="align-end">
                <div class="f_parts" data-option="style-column">
                  <span class="unit" data-option="style-before">営業所</span>
                  <div class="f_parts" data-option="style-select" data-width>
                    {{Form::select('office', $UserMaster->OfficeList, $request->office, ['id' => ''])}}
                  </div>
                </div>
                <div class="f_parts" id='' data-option="style-column">
                  <span class="unit" data-option="style-before">エリア</span>
                  <div class="f_parts" data-option="style-select" data-width>
                    {{Form::select('area', $ActionMasterInstance->AreaList, $request->area, ['id' => ''])}}
                  </div>
                </div>
                <div class="f_parts" data-option="style-column">
                  <span class="unit" data-option="style-before">ステージ</span>
                  <div class="f_parts" data-option="style-select" data-width>
                    {{Form::select('stage', $ActionMasterInstance->SearchStageList, $request->stage, ['id' => 'stage_search_form'])}}
                  </div>
                </div>
                <div class="f_parts" id='none_status_search_form' data-option="style-column">
                  <span class="unit" data-option="style-before">ステータス</span>
                  <div class="f_parts" data-option="style-select" data-width>
                    {{Form::select('status', $request->status < 0 || empty($request->status) || $request->stage == 0 ? [0 => '---'] : $ActionMasterInstance->StatuselongingStage($request->stage), $request->status, ['id' => 'status_search_form'])}}
                  </div>
                </div>
                <div class="f_parts">
                  <input type="text" name="SearchWord" value="{{$request->SearchWord}}"
                         placeholder="キーワードで検索">
                </div>
              </div>
              <div class="btnarea" style="margin-left: 10px">
                <button class="btn">検索</button>
              </div>
              <div class="btn" style="margin-left: 10px; width: 100px;">
                <a class="btn" style="background: white; color: #3B96DD;" href="{{ route('prospect.label') }}">リセット</a>
              </div>
              <div class="c-display">
                <form id="export">
                  <button class="btn" data-option="style-m" style="width: 100px;"
                          formaction="{{ route('prospect.label.export.pdf') }}" formtarget="_blank">ラベル発行
                  </button>
                  <button class="btn" data-option="style-m" style="width: 100px;"
                          formaction="{{ route('prospect.label.export.csv') }}" formtarget="_blank">CSV発行
                  </button>
                </form>
              </div>
            </div>
            @include('element.error.validate_error')
            <table class="table link" style="max-width: 1200px">
              <thead style="display: block; width: 1200px; overflow: scroll;" class="scroll-box" id="scroll_head_box">
              <tr style="display: flex; @if(empty($request->default)) width: 1600px @else width: 100% @endif">
                <th style="width: 40px; display: block">
                  <div class="f">
                    <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                      <input type="checkbox" id="all_check">
                      <label for="all_check"></label>
                    </div>
                  </div>
                </th>
                <th style="width: 90px;">
                  <p><br/>ステージ</p>
                  @include('element.sort_btn',['SortValue' => 'StageSort', 'request' => $request])
                </th>
                <th style="width: 100px;">
                  <p><br/>ステータス</p>
                  @include('element.sort_btn',['SortValue' => 'StatusSort', 'request' => $request])
                </th>
                <th style="width: 240px;">
                  <p><br/>顧客名</p>
                  @include('element.sort_btn',['SortValue' => 'PropertyNameSort', 'request' => $request])
                </th>
                <th style="width: 70px;">
                  <p><br/>担当者</p>
                  @include('element.sort_btn',['SortValue' => 'ProspectsRoomSort', 'request' => $request])
                </th>
                <th style="width: 100px;">
                  <p><br/>顧客名</p>
                  @include('element.sort_btn',['SortValue' => 'ClientSort', 'request' => $request])
                </th>
                <th style="width: 100px;">
                  <p>最終追客<br/>経過日数</p>
                  @include('element.sort_btn',['SortValue' => 'LastProspectActionLogSort', 'request' => $request])
                </th>
                <th style="width: 100px;">
                  <p>現ステージ<br/>滞在日数</p>
                  @include('element.sort_btn',['SortValue' => 'StageStayDateSort', 'request' => $request])
                </th>
                <th style="width: 100px;">
                  <p><br>専有面積</p>
                  @include('element.sort_btn',['SortValue' => 'PropertyOccupiedAreaSort', 'request' => $request])
                </th>
                <th style="width: 110px;">
                  <p><br>竣工年月</p>
                  @include('element.sort_btn',['SortValue' => 'PropertyCompletionDateSort', 'request' => $request])
                </th>
                <th style="width: 90px;"><p><br/>備考</p></th>
                <th style="width: 50px"></th>
              </tr>
              </thead>
              <tbody style="display: block; overflow: scroll; height: 470px; width: 100%" id="scroll_body_box">
              @foreach($prospects as $prospect)
                <tr style="display: flex; width: 100%;" class="prospect_list open_btn">
                  <td style="width: 40px; display: block">
                    <div class="f">
                      <div class="f_parts" data-option="style-checkbox" data-flex="wrap">
                        <input type="checkbox" id="{{ "prospect_{$prospect->property_room_id}" }}" name="room[]"
                               value="{{ $prospect->property_room_id }}">
                        <label for="{{ "prospect_{$prospect->property_room_id}" }}"></label>
                      </div>
                    </div>
                  </td>
                  <x-prospect.label.column.stage action-name="{{ $prospect->stage_name }}"/>
                  <x-prospect.label.column.status status="{{ $prospect->status_name }}"/>
                  <x-prospect.label.column.mansion name="{{ $prospect->property_name }}"/>
                  <x-prospect.label.column.room-number name="{{ $prospect->room_name }}"/>
                  <x-prospect.label.column.client name="{{ $prospect->client_name }}"/>
                  <x-prospect.label.column.stage-stay-date-from-latest-action
                      date="{{ $prospect->prospect_action_log_stage_stay_date }}"/>
                  <x-prospect.label.column.stage-stay-date date="{{ $prospect->latest_action_log_stage_stay_date }}"/>
                  <x-prospect.label.column.occupied-area :area="(int) $prospect->occupied_area"/>
                  <x-prospect.label.column.building-date
                      date="{{ Carbon\Carbon::parse($prospect->date_completion)->format('Y-m') }}"/>
                  <x-prospect.label.column.remark remark="{{ $prospect->remark }}"/>
                </tr>
              @endforeach
              </tbody>
            </table>
            <div class="c-pager">
              <div class="total">
                <p data-total="{{ number_format($prospects->total()) }}">{{ $prospects->lastItem() }}</p>
              </div>
              <ul class="area_pager">
                {{ $prospects->appends(request()->input())->links('vendor.pagination.default') }}
              </ul>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- 読み込み -->
  <script> const PropertyNameList = @json($PropertyInstance->PropertyNameList);</script>
  <script src="{{ asset('js/sort_event.js') }}" defer></script>
  <script src="{{ asset('js/stage_change_for_prospect_search_form.js') }}" defer></script>
  <script src="{{ asset('js/all_check_button.js') }}" defer></script>
  {{--  <script src="{{ asset('js/generating_medium_for_prospect.js') }}" defer></script>--}}
  {{--  <script src="{{ asset('js/stage_change_for_prospect.js') }}" defer></script>--}}
  {{--  <script src="{{ asset('js/stage_change_for_prospect_action_log.js') }}" defer></script>--}}
  {{--  <script type="text/javascript" src="{{asset('/js/prospect_pin.js')}}" defer></script>--}}
  {{--  <script type="text/javascript" src="{{asset('/js/prospect_property_search.js')}}" defer></script>--}}
  {{--  <script type="text/javascript" src="{{asset('/js/list_scroll_control.js')}}" defer></script>--}}
  {{--  <script type="text/javascript" src="{{asset('/js/prospect_add_form_alert.js')}}" defer></script>--}}
  {{--  <script type="text/javascript" src="{{asset('/js/prospect_index_add_form.js')}}" defer></script>--}}
  {{--  <script type="text/javascript" src="{{asset('/js/prospect_action_select.js')}}" defer></script>--}}
  {{--  <script type="text/javascript" src="{{asset('/js/prospect_open_close.js')}}" defer></script>--}}
  {{--  @include('element._prospect_mansion_add')--}}
  {{--  @include('element._counter_add')--}}
  {{--  @include('element._prospect_add')--}}
  {{--  @include('element._prospect_action_add')--}}
@endsection
