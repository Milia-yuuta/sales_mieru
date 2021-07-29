<div class="p-pseudo_modal" id="modal_prospect_add">
  <div class="c-modal" data-option="w-560">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="head">
      <p class="ttl">新規見込登録</p>
    </div>
    <form action="{{ route('prospect.store') }}" method="post" accept-charset="utf-8" autocomplete="off">
      @CSRF
      {{Form::hidden('user_id', $loginUser->id)}}
      <div class="body">
        <ul class="c-list" data-option="head-160">
          <li>
            <div class="head">
              <p class="ttl">顧客検索方法</p>
            </div>
            <div class="cnt">
              <div class="f">
                <!-- ! select2 ============================== -->
                <div class="f_parts" data-option="style-select">
                  {{Form::select('property_id', ['name' => '顧客名', 'code' => '顧客コード'], old('property_id'), ['class'=>'property_search_pattern'])}}
                </div>
              </div>
            </div>
          </li>
          <li class="prospect_name_li">
            <div class="head">
              <p class="ttl">顧客名</p>
            </div>
            <div class="cnt">
              <div class="f">
                <!-- ! select2 ============================== -->
                <div class="f_parts" data-option="style-select">
                  {{Form::select('property_id', [], old('property_id'), ['class'=>'property_name', 'id' => 'propertyNameSelect2', 'disabled' => false, 'required' => 'true', 'placeholder' => '顧客名予測検索'])}}
                </div>
              </div>
            </div>
          </li>
          <li class="prospect_code_li display_none">
            <div class="head">
              <p class="ttl">コード</p>
            </div>
            <div class="cnt">
              <div class="f">
                <!-- ! select2 ============================== -->
                <div class="f_parts" data-option="style-select">
                  {{Form::select('property_id', [], old('property_id'), ['class'=>'property_code', 'id' => 'propertyCodeSelect2', 'disabled' => true, 'required' => 'true','style' =>'width:200px', 'placeholder' => '顧客コード予測検索'])}}
                  <p class="property_code_name ttl" style="margin-left: 15px; width: 140px"></p>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">担当者名</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-width="100">
                  <input type="text" id="prospect_room" name="property_rooms[room_name]" placeholder="太郎課長" class="num" data-option="size-" required>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">見込発生日</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-date">
                  <input type="text" id="modal_prospect_datepicker" name="date" placeholder="" value="<?php date_default_timezone_set('Asia/Tokyo'); echo date('Y-m-d'); ?>" readonly>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">発生媒体１</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-select" data-width="160">
                  <select id="TopGeneratingMedium" name="TopGeneratingMedium" required>
                    <option value="" selected="selected">---</option>
                    @foreach($ActionMasterInstance->TopGeneratingMedium as $id => $ActionName)
                    <option value="{{$id}}">{{$ActionName}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">発生媒体２</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-select" data-width="160">
                  <select id="GeneratingMedium" name="generating_medium_master_id" required>
                    <option value="">--</option>
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li class="display_none prospect_site_li">
            <div class="head">
              <p class="ttl">一括査定サイト</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-select" data-width="160">
                  {{Form::select('source_media_site_master_id', $ActionMasterInstance->SiteList, old('source_media_site_master_id'), ['id' => 'source_media_site', 'disabled' => true])}}
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">ステージ</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-select" data-width="140">
                  <select id="stage_action_master_id" name="prospect_action_logs[stage_action_master_id]" required>
                    <option value="" selected="selected">---</option>
                  @foreach($ActionMasterInstance->StageList as $id => $ActionName)
                    <option value="{{$id}}">{{$ActionName}}</option>
                  @endforeach
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">ステータス</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-select" data-width="140">
                  <select id="status_action_master_id" name="prospect_action_logs[status_action_master_id]" required>
                    <option value="">---</option>
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">備考</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts">
                  <textarea  name="remark" placeholder="電話NG"></textarea>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="foot">
        <div class="btnarea" data-flex="justify-center">
          <button class="btn" id="prospect_add_submit" data-option="size-l">見込を登録する</button>
        </div>
      </div>
    </form>
  </div>
</div>
