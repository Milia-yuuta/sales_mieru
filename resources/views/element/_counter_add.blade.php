<div class="p-counter_add" style="max-width: 700px; width: 700px; -webkit-user-select:none;">
  {{ Form::open( ['route' => ['excavationBehaviorLog.store'], 'file' => true, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
  @CSRF
  {{Form::hidden('user_id',$loginUser->id)}}
  <div class="head">
    <p class="ttl">発掘カウンタ登録</p>
    <div class="f" style="display: flex">
      <div class="f_parts" style="margin-right: 15px; margin-top: 6px">
        <span class="unit" data-option="style-before">実施エリア</span>
          <?php
          use App\Models\ActionMaster;
          $AreaList =  [];
          foreach (ActionMaster::query()->where('group_num', 7)->whereIn('id', \Auth::user()->AllAreaSearch)->select('id','action_name')->get()->toArray() as $value){
              $AreaList += [$value['id'] => $value['action_name']];
          }
          ?>
        <div class="f_parts" data-option="style-select">
          {{Form::select('area_master_id', $AreaList, '',['required' => true, 'id' => 'excavation_area_id'])}}
        </div>
      </div>
      <div class="f_parts">
        <span class="unit" data-option="style-before">日付</span>
        <div class="f_parts" data-option="style-date">
          <input type="text" id="counter_datepicker" name="action_date" value="<?php date_default_timezone_set('Asia/Tokyo'); echo date('Y-m-d'); ?>" readonly>
        </div>
      </div>
    </div>
  </div>
  <div class="body">
    <div class="area_tab">
      {{--      <ul class="list_tab_button">--}}
      {{--        <li class="current_tab" id="head_tab"><div class="button_tab" data-option="size-s">発掘行動登録</div></li>--}}
      {{--        <li><div class="button_tab" data-option="size-s">顧客毎発掘状況</div></li>--}}
      {{--      </ul>--}}
      <div class="panel_tab counter_tab" id="counter_tab">
        <div class="stack">
          <ul class="list_counter_add" style="display: flex">
            <li class="area">
              <p class="ttl">エリア発掘</p>
              <ul class="list_form">
                @foreach($AreaTypeList as $key => $value)
                  <li>
                    <div class="head" style="margin: 0 15px">
                      <p class="ttl">{{$key}}</p>
                    </div>
                    <div class="cnt">
                      <div class="f">
                        <div class="f_parts">
                          <input type="number" class="input_val"  name="{{$value}}" id="{{$value}}" value="0">
                          <span class="unit" data-option="style-after">件</span>
                          <div class="btnarea">
                            <div class="btn count_up" data-option=
                            @if($value === 'flyer_distribution_count')
                                "style-count-up-hundred"
                            @elseif($value === 'DM_distribution_count')
                              "style-count-up-50"
                            @elseif($value === 'letter_distribution_count')
                              "style-count-up-10"
                            @else
                              "style-count-up"
                            @endif></div>
                          <div class="btn count_down" data-option=
                          @if($value === 'flyer_distribution_count')
                              "style-count-down-hundred"
                          @elseif($value === 'DM_distribution_count')
                            "style-count-down-50"
                          @elseif($value === 'letter_distribution_count')
                            "style-count-down-10"
                          @else
                            "style-count-down"
                          @endif
                          ></div>
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </li>
            <li class="company" style="margin-left: 75px">
              <p class="ttl" style="margin: 0;margin-bottom: 12px">社内発掘</p>
              <ul class="list_form">
                @foreach($CompanyTypeList as $key => $value)
                  <li>
                    <div class="head" style="margin: 0 15px">
                      <p class="ttl">{{$key}}</p>
                    </div>
                    <div class="cnt">
                      <div class="f">
                        <div class="f_parts">
                          <input type="number" class="input_val"  name="{{$value}}" id="{{$value}}" value="0">
                          <span class="unit" data-option="style-after">件</span>
                          <div class="btnarea">
                            <div class="btn count_up" data-option=
                            @if($value === 'flyer_delivery_count')
                                "style-count-up-hundred"
                            @elseif($value === 'DM_mail_count')
                              "style-count-up-50"
                            @elseif($value === 'mail_letter_count')
                              "style-count-up-5"
                            @else
                              "style-count-up"
                            @endif
                            >
                          </div>
                          <div class="btn count_down" data-option=
                          @if($value === 'flyer_delivery_count')
                              "style-count-down-hundred"
                          @elseif($value === 'DM_mail_count')
                            "style-count-down-50"
                          @elseif($value === 'mail_letter_count')
                            "style-count-down-5"
                          @else
                            "style-count-down"
                          @endif></div>
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
              <p class="ttl" style="margin: 0;margin: 12px 0; background-color: #EFE7CD">前取関連</p>
              <ul class="list_form">
                @foreach($PreTypeList as $key => $value)
                  <li>
                    <div class="head" style="margin: 0 15px">
                      <p class="ttl">{{$key}}</p>
                    </div>
                    <div class="cnt">
                      <div class="f">
                        <div class="f_parts">
                          <input type="number" class="input_val"  name="{{$value}}" id="{{$value}}" value="0">
                          <span class="unit" data-option="style-after">件</span>
                          <div class="btnarea">
                            <div class="btn count_up" data-option="style-count-up"></div>
                            <div class="btn count_down" data-option="style-count-down"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </li>
          </ul>
        </div>
      </div>
      {{--      <div class="panel_tab counter_tab property_excavation_behavior" id="counter_body_tab">--}}
      {{--        <div class="stack">--}}
      {{--          <table class="table">--}}
      {{--            <thead>--}}
      {{--            <tr>--}}
      {{--              <th data-width="150"><p>顧客名 / 住所</p></th>--}}
      {{--              <th data-width="80"><p>管理人訪問</p></th>--}}
      {{--              <th data-width="80"><p>管理人TEL</p></th>--}}
      {{--              <th data-width="80"><p>一棟C</p>--}}
      {{--              <th data-width="100"><p>行動日</p>--}}
      {{--            </tr>--}}
      {{--            </thead>--}}
      {{--            <tbody class="excavation_property_tbody">--}}
      {{--            <tr>--}}
      {{--            <td style="width: 150px">--}}
      {{--              <p class="excavation_property_name"></p>--}}
      {{--              <p class="excavation_property_address address"></p>--}}
      {{--            </td>--}}
      {{--            <td style="width: 80px"><span class="visit_check"></span></td>--}}
      {{--            <td style="width: 80px"><span class="tel_check"></span></td>--}}
      {{--            <td style="width: 80px"><span class="building_check"></span></td>--}}
      {{--            <td style="width: 100px"><p></p></td>--}}
      {{--            </tr>--}}
      {{--            </tbody>--}}
      {{--          </table>--}}
      {{--        </div>--}}
      {{--      </div>--}}
    </div>
  </div>
  <div class="foot">
    <div class="btnarea">
      <button class="btn" data-option="w-full">行動保存</button>
    </div>
  </div>
  {{Form::close()}}
  <script type="text/javascript" src="{{asset('/js/excavation_behavior_log.js')}}" defer></script>
</div>