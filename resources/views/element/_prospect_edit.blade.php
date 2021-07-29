<div class="p-pseudo_modal" id="modal_prospect_add">
  <div class="c-modal" data-option="w-560">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="head">
      <p class="ttl">見込編集</p>
    </div>
    <form action="{{ route('prospect.update') }}" method="post" accept-charset="utf-8" autocomplete="off">
      @CSRF
      {{Form::hidden('user_id', Auth::user()->id)}}
      {{Form::hidden('prospect_id', $firstProspect->id)}}
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
                  {{Form::select('property_id', [], old('property_id'), ['class'=>'property_name', 'id' =>'propertyNameSelect2', 'disabled' => false, 'required' => 'true'])}}
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
                  {{Form::select('property_id', [], old('property_id'), ['class'=>'property_code', 'id' =>'propertyCodeSelect2', 'disabled' => true, 'required' => 'true','style' =>'width:200px'])}}
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
                  <input type="text" id="prospect_room" value="{{$firstProspect->propertyRooms->first()->room_name}}" name="property_rooms[room_name]" placeholder="太郎課長" class="num" data-option="size-" required>
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
                  <input type="text" id="modal_prospect_datepicker" name="date" placeholder="" value="{{$firstProspect->date}}">
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">営業所</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-select">
                  {{Form::select('office_master_id', $UserMaster->OfficeList, $firstProspect->office_master_id)}}
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="head">
              <p class="ttl">担当エリア</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts" data-option="style-select">
                  {{Form::select('area_master_id', $ActionMasterInstance->AreaSetList, $firstProspect->area_master_id)}}
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
                    <option value="" selected>--</option>
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
          <li class=" @if($firstProspect->generating_medium_master_id !== 68)display_none @endif prospect_site_li">
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
              <p class="ttl">備考</p>
            </div>
            <div class="cnt">
              <div class="f">
                <div class="f_parts">
                  <textarea  name="remark" placeholder="電話NG">{{$firstProspect->remark}}</textarea>
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
<script>
  $('#prospect_add_submit').click(function(){
    if ($('.property_name').val() === '0' && $('.property_code').val() === '0'){
      alert('顧客が未入力です。');
      return false;
    }
  })
  const primary_generating_medium_master_id = @json($ActionMasterInstance->find($firstProspect->generating_medium_master_id)->actionMaster->id);
  const generating_medium_master_id = @json($firstProspect->generating_medium_master_id);
  const propertyRoomName = @json($firstProspect->propertyRooms->first()->room_name);
  const property_id = @json($firstProspect->propertyRooms->first()->property_id);
  const usage_id = @json($firstProspect->usage_action_master_id);
</script>
