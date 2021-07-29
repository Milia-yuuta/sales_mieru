<div class="panel_tab">
  <div class="l">
    <div class="l_auto">
      <p class="ttl h6">見込情報</p>
    </div>
  </div>
  <div class="l" data-space="m-20">
    <div class="l_auto">
      <ul class="list_form">
        <li>
          <div class="head">
            <p class="ttl">営業所</p>
          </div>
          <div class="cnt">
            <p class="num">{{\App\Models\UserMaster::find($firstProspect->office_master_id)->name}}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">担当エリア</p>
          </div>
          <div class="cnt">
            <p class="num">{{\App\Models\ActionMaster::find($firstProspect->area_master_id)->action_name}}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">営業</p>
          </div>
          <div class="cnt">
            <p class="num">{{\App\Models\Team::where('office_master_id', $firstProspect->office_master_id)->where('area_master_id', $firstProspect->area_master_id)->first()->sale->fullName}}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">hat</p>
          </div>
          <div class="cnt">
            <p class="num">{{\App\Models\Team::where('office_master_id', $firstProspect->office_master_id)->where('area_master_id', $firstProspect->area_master_id)->first()?->hat?->fullName}}</p>
          </div>
        </li>

        <li>
          <div class="head">
            <p class="ttl">現ステージ</p>
          </div>
          <div class="cnt">
            <span class="stage" data-option="{{$firstProspect->prospectActionLogs->sortByDesc('created_at')->first()->CssStageName}} size-m"></span>
            <p style="display: none" id="stage_id_css">{{$firstProspect->prospectActionLogs->sortByDesc('created_at')->first()->stage_action_master_id}}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">見込発生日</p>
          </div>
          <div class="cnt">
            <p class="num">{{$firstProspect->date->format('Y.m.d')}}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">発生媒体1</p>
          </div>
          <div class="cnt">
            <p>{{$firstProspect->Medium}}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">発生媒体2</p>
          </div>
          <div class="cnt">
            <p>{{$firstProspect->Medium2}}</p>
          </div>
        </li>
        @if($firstProspect->Medium2 === '一括査定サイト')
          <li>
            <div class="head">
              <p class="ttl">一括査定サイト</p>
            </div>
            <div class="cnt">
              <p>{{$firstProspect->MediumSite}}</p>
            </div>
          </li>
        @endif
        <li>
          <div class="head">
            <p class="ttl">ステータス</p>
          </div>
          <div class="cnt">
            <div class="f">
              <p style="display: none" id="status_id">{{$firstProspect->prospectActionLogs->sortByDesc('created_at')->first()->status_action_master_id}}</p>
              <p>{{$firstProspect->prospectActionLogs->sortByDesc('created_at')->first()->status->action_name}}</p>
            </div>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">現ステージ滞在日数</p>
          </div>
          <div class="cnt">
            <p>{{$firstProspect->StageStayDate}}</p>
          </div>
        </li>
        <li data-option="style-column">
          <div class="head">
            <p class="ttl">備考</p>
          </div>
          <div id="flash-status-area" style="color: #1f6fb2"></div>
          <div class="cnt">
            <textarea id="prospectRemark" data-review-id="{{ $firstProspect->id }}" name="remark"  readonly>@isset($firstProspect->remark){{$firstProspect->remark}}@endisset</textarea>
          </div>
        </li>
        <li>
          <div class="btnarea">
            <a class="btn prospect_edit" data-option="style-add open-prospect-add" id="newProspect">見込情報編集</a>
            <a class="btn" data-option="style-add open-prospect-delete" style="border-color: indianred; color: indianred">見込削除</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
