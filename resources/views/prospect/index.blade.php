@extends('layouts.default')

@section('title', '見込リスト')
@section('description', 'ダッシュボード')
@section('ogtitle', '見込リスト')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-prospects" data-box-option="space_min">
      <div class="head_box">
        <p class="ttl" data-ico="prospects">見込リスト</p>
        <div class="btnarea">
          <a class="btn excavation_btn" data-option="style-counter open-counter-add">発掘カウンタ</a>
          <a class="btn" data-option="style-add open-prospect-add" id="newProspect">新規見込登録</a>
        </div>
      </div>
      <form class="SortForm">
        <div class="body_box">
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
                  {{Form::select('status', $request->status < 0 || empty($request->status) || $request->stage == 0 ? [0 => 'ALL'] : $ActionMasterInstance->StatuselongingStage($request->stage), $request->status, ['id' => 'status_search_form'])}}
                </div>
              </div>
              <div class="f_parts">
                <input type="text"  name="SearchWord" value="{{$request->SearchWord}}" placeholder="キーワードで検索">
              </div>
            </div>
            <div class="btnarea" style="margin-left: 10px">
              <button class="btn">検索</button>
            </div>
            <div class="btn" style="margin-left: 10px; width: 100px;">
              <a class="btn" style="background: white; color: #3B96DD;" href="{{route('prospect')}}">リセット</a>
            </div>
            <div class="c-display">
              <a class="btn" data-option="style-m" style="width: 100px;">表示項目</a>
              <div class="display_modal">
                <p class="ttl">表示項目を選択</p>
                <div class="f">
                  <div class="f_parts" data-option="style-checkbox style-tab">
                    <input type="checkbox" id="display_stage" name="display_stage" @if(!empty($request->input('display_stage'))) checked @endif>
                    <label for="display_stage">ステージ</label>
                    <input type="checkbox" id="display_status" name="display_status" @if(!empty($request->input('display_status') )) checked @endif>
                    <label for="display_status">ステータス</label>
                    <input type="checkbox" id="display_mansion" name="display_mansion" @if(!empty($request->input('display_mansion') )) checked @endif>
                    <label for="display_mansion">顧客名</label>
                    <input type="checkbox" id="display_room" name="display_room" @if(!empty($request->input('display_room') )) checked @endif>
                    <label for="display_room">担当</label>
                    <input type="checkbox" id="display_address" name="display_address" @if(!empty($request->input('display_address') )) checked @endif>
                    <label for="display_address">住所</label>
                    <input type="checkbox" id="display_generating_medium" name="display_generating_medium" @if(!empty($request->input('display_generating_medium') )) checked @endif>
                    <label for="display_generating_medium">発生媒体2</label>
                    <input type="checkbox" id="display_date" name="display_date" @if(!empty($request->input('display_date') )) checked @endif>
                    <label for="display_date">見込発生日</label>
                    <input type="checkbox" id="display_elapsed" name="display_elapsed" @if(!empty($request->input('display_elapsed') )) checked @endif>
                    <label for="display_elapsed">最終追客経過日数</label>
                    <input type="checkbox" id="display_stay" name="display_stay" @if(!empty($request->input('display_stay') )) checked @endif>
                    <label for="display_stay">現ステージ滞在日数</label>
                    <input type="checkbox" id="display_next_action_date" name="display_next_action_date" @if(!empty($request->input('display_next_action_date') )) checked @endif>
                    <label for="display_next_action_date">次回アクション日</label>
                    <input type="checkbox" id="display_reaction" name="display_reaction" @if(!empty($request->input('display_reaction') )) checked @endif>
                    <label for="display_reaction">反応</label>
                    <input type="checkbox" id="display_assessment" name="display_assessment" @if(!empty($request->input('display_assessment') )) checked @endif>
                    <label for="display_assessment">査定</label>
                    <input type="checkbox" id="display_memo" name="display_memo" @if(!empty($request->input('display_memo') )) checked @endif>
                    <label for="display_memo">備考</label>
                    <input type="checkbox" id="display_person" name="display_person" @if(!empty($request->input('display_person') )) checked @endif>
                    <label for="display_person">担当</label>
                  </div>
                </div>
                <div class="btnarea">
                  <button id="" name="" data-option="style-m" class="btn">表示項目を更新する</button>
                </div>
              </div>
            </div>
          </div>
          <div class="stack">
            <div class="c-table" data-option="scroll-x" style="height: 470px">
              @include('element.error.validate_error')
              <table class="table link fixed">
                <thead style="display: table-header-group;" class="scroll-box" id="scroll_head_box">
                <tr style="@if(empty($request->default)) @else width: 100% @endif">
                  <th style="width: 30px; display: table-cell;"></th>
                  <th style="width: 90px; display: table-cell; @if(empty($request->display_stage)) display: none @endif ">
                    <p><br />ステージ</p>
                    @include('element.sort_btn',['SortValue' => 'StageSort', 'request' => $request])
                  </th>
                  <th style="width: 100px; display: table-cell; @if(empty($request->input('display_status') )) display: none @endif ">
                    <p><br />ステータス</p>
                    @include('element.sort_btn',['SortValue' => 'StatusSort', 'request' => $request])
                  </th>
                  <th  style="width: 200px; display: table-cell; @if(empty($request->input('display_mansion') )) display: none @endif ">
                    <p><br />顧客名</p>
                    @include('element.sort_btn',['SortValue' => 'PropertyNameSort', 'request' => $request])
                  </th>
                  <th style="width: 70px; display: table-cell; @if(empty($request->input('display_room') )) display: none @endif ">
                    <p><br />担当</p>
                    @include('element.sort_btn',['SortValue' => 'ProspectsRoomSort', 'request' => $request])
                  </th>
                  <th style="width: 100px; display: table-cell; @if(empty($request->input('display_address') )) display: none @endif ">
                    <p><br />住所</p>
                    @include('element.sort_btn',['SortValue' => 'AddressSort', 'request' => $request])
                  </th>
                  <th style="width: 110px; display: table-cell; @if(empty($request->input('display_generating_medium') )) display: none @endif "><p><br />発生媒体2</p></th>
                  <th style="width: 90px; display: table-cell; @if(empty($request->input('display_date') )) display: none @endif ">
                    <p>見込<br />発生日</p>
                    @include('element.sort_btn',['SortValue' => 'ProspectDateSort', 'request' => $request])
                  </th>
                  <th style="width: 90px; display: table-cell; @if(empty($request->input('display_elapsed') )) display: none @endif ">
                    <p>最終追客<br />経過日数</p>
                    @include('element.sort_btn',['SortValue' => 'LastProspectActionLogSort', 'request' => $request])
                  </th>
                  <th style="width: 90px; display: table-cell; @if(empty($request->input('display_stay') )) display: none @endif ">
                    <p>現ｽﾃｰｼﾞ<br/>滞在日数</p>
                    @include('element.sort_btn',['SortValue' => 'StageStayDateSort', 'request' => $request])
                  </th>
                  <th style="width: 100px; display: table-cell; @if(empty($request->input('display_next_action_date') )) display: none @endif ">
                    <p>次回<br />ｱｸｼｮﾝ日</p>
                    @include('element.sort_btn',['SortValue' => 'NextActionDateSort', 'request' => $request])
                  </th>
                  <th style="width: 40px; display: table-cell; @if(empty($request->input('display_reaction') )) display: none @endif "><p><br />反応</p></th>
                  <th style="width: 40px; display: table-cell; @if(empty($request->input('display_assessment') )) display: none @endif "><p><br />査定</p></th>
                  <th style="width: 80px; display: table-cell; @if(empty($request->input('display_memo') )) display: none; @endif"><p>備考</p></th>
                  <th style="width: 90px; display: table-cell; @if(empty($request->input('display_person') )) display: none @endif"><p>担当</p></th>
                  <th style="width: 70px"></th>
                </tr>
                </thead>
                <tbody style="display: table-row-group; @if(empty($request->default)) overflow: scroll; @endif overflow-x:scroll;" id="scroll_body_box">
                @foreach($searchProspects as $prospect)
                  <tr style=" @if(empty($request->default))@else width: 100% @endif" data-option= @if(isset($prospect->prospect_favorites_prospect_id)) "style-pin" @else "none" @endif class="prospect_list open_btn" id="{{$prospect->id}}">
                  @include('prospect.indexColumn.pin_column')
                  @include('prospect.indexColumn.stage_column')
                  {{Form::hidden('ProspectId', $prospect->id, ['id' => 'ProspectId'])}}
                  {{Form::hidden('ProspectStatusId', $prospect->status_action_master_id, ['id' => 'ProspectStatusId'])}}
                  <td style="@if(empty($request->display_status))  display: none @endif "><p> @isset($prospect->status_action_master_id){{ $ActionMasterInstance->ThisAction($prospect->status_action_master_id)->action_name }} @endisset</p></td>
                  <td style="@if(empty($request->display_mansion))  display: none @endif ">
                    <p style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ $prospect->property_name }}</p>
                  </td>
                  <td style="@if(empty($request->display_room)) display: none @endif "><p>{{ $prospect->room_name }}</p></td>
                  <td style="@if(empty($request->display_address)) display: none @endif "><p>{{ $prospect->address1 }}{{ $prospect->address2 }}</p></td>
                  <td style="@if(empty($request->display_generating_medium)) display: none @endif "><p>{{ $ActionMasterInstance->ThisAction($prospect->generating_medium_master_id)->action_name }}</p></td>
                  <td style="@if(empty($request->display_date)) display: none @endif "><p >{{ $prospect->date->format('Y.m.d') }}</p></td>
                  <td style="@if(empty($request->display_elapsed)) display: none @endif "><p>{{ $prospect->last_action_date === NULL ? '-' : \Illuminate\Support\Carbon::now()->diffInDays($prospect->last_action_date).'日' }}</p></td>
                  <td style=" @if(empty($request->display_stay)) display: none @endif "><p>{{ $prospect->StageStayDate}}日</p></td>
                  <td style=" @if(empty($request->display_next_action_date)) display: none @endif "><p @if(empty($prospect->next_action_date))@elseif($prospect->next_action_date === \Carbon\Carbon::now()->format('Y-m-d')) style="color: #F2D073" @elseif($prospect->next_action_date < \Carbon\Carbon::now()->format('Y-m-d')) style="color: red" @endif> {{$prospect->next_action_date}} </p></td>
                  <td style=" @if(empty($request->display_reaction)) display: none @endif ">
                    @if($prospect->generating_medium_master_id === 67 || $prospect->generating_medium_master_id === 68)<span @if(!$ProspectActionLogInstance->ResponseCheck($prospect->id)) data-option="open-rooms" @endif class="c-check @if($ProspectActionLogInstance->ResponseCheck($prospect->id)) checked @else reaction_check @endif"></span> @endif
                  </td>
                  <td style="@if(empty($request->display_assessment)) display: none @endif ">
                    @if($prospect->generating_medium_master_id === 67 || $prospect->generating_medium_master_id === 68)<span @if(!$ProspectActionLogInstance->AssessmentCheck($prospect->id)) data-option="open-rooms" @endif class="c-check @if($ProspectActionLogInstance->AssessmentCheck($prospect->id)) checked @else assessment_check @endif"></span>@endif
                  </td>
                  <td style="@if(empty($request->display_memo)) display: none @endif "><p style="width: 45px; overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ $prospect->remark }}</p></td>
                  <td style="width: auto; @if(empty($request->input('display_person'))) display: none @endif "><p>{{ $prospect->user->full_name }}</p></td>
                  <td class="prospect_action_log_add" style="width: 80px;"><a class="btn ProspectActionLogBtn" data-option="size-s open-prospect-action-add" id="ProspectActionLogBtn">追客</a></td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="stack" data-option="m-20">
            <div class="c-pager">
              <div class="total">
                <p data-total="{{ number_format($searchProspects->total()) }}">{{$searchProspects->lastItem()}}</p>
              </div>
              <ul class="area_pager">
                {{ $searchProspects->appends(request()->input())->links('vendor.pagination.default') }}
              </ul>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- ! 住戸リスト ============================== -->
  <div class="property_room_modal" style="width: 180px;">
  </div>
  <!-- 読み込み -->
  <script src="{{ asset('js/prospect/index/index.js') }}" defer></script>
  @include('element._counter_add')
  @include('element._prospect_add')
  @include('element._prospect_action_add')
@endsection
