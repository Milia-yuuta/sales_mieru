<div class="panel_tab show_tab">
  <div class="l" data-flex="align-center">
    <div class="l_fix">
      <p class="ttl h6">追客詳細</p>
    </div>
    <div class="l_auto" data-flex="align-center justify-end">
        <?php
        $FindProspectArray_used_prospect_day = $FindProspectArray;
        $time = [];
        foreach ($FindProspectArray as $prospectActionLog){
            $time[] = $prospectActionLog['prospect_action_logs_date'];
        }
        array_multisort($time, SORT_DESC, $FindProspectArray_used_prospect_day);
        ?>
      <p class="p-prospect_day" data-ttl="最終追客日からの日数" data-after="日">{{$firstProspect->latestActionDate}}</p>
      <div class="btnarea">
        <a class="btn ProspectActionLogBtn ProspectActionLogLogBtn" data-option="style-add open-prospect-action-add" id="NewProspectActionLogBtn">新規追客登録</a>
        {{Form::hidden('prospect_id', $firstProspect->id,['id' => 'hiddenProspectId'])}}
      </div>
    </div>
  </div>
  <div class="l" data-space="m-20">
    <div class="l_auto">
      <div class="c-table">
        <table class="table" data-option="space-s">
          <thead>
          <tr>
            <th data-width="90"><p>追加日</p></th>
            <th data-width="80"><p>ステージ</p></th>
            <th data-width="110"><p>内容</p></th>
            <th data-width="70"><p>作成者</p></th>
            <th data-width="200"><p>結果</p></th>
            <th data-width="100"><p>次回アクション</p></th>
            <th data-width="60"></th>
            <th data-width="60"></th>
          </tr>
          </thead>
          <tbody data-option="vertical-top">
          @if(end($FindProspectArray)['id'] === $firstProspect->prospectActionLogs->first()->id)
              <?php unset($FindProspectArray[array_key_last($FindProspectArray)]); ?>
          @endif
          @if(!empty($FindProspectArray))
              <?php
              $time = [];
              foreach ($FindProspectArray as $prospectActionLog){
                  $time[] = $prospectActionLog['prospect_action_logs_date'];
              }
              foreach ($FindProspectArray as $prospectActionLog){
                  $ids[] = $prospectActionLog['id'];
              }
              array_multisort($time, SORT_DESC, $ids, SORT_DESC,$FindProspectArray);
              ?>
          @endif
          @forelse($FindProspectArray as $index  => $ProspectActionLog)
              <?php
              $statusOnly = 0;
              $key_num =  $loop->index+1;
              $judgeStage = $loop->last ? $firstProspect->prospectActionLogs->first()->stage_action_master_id : $FindProspectArray[$key_num]['stage_action_master_id'];
              ?>
              @if($judgeStage === $ProspectActionLog['stage_action_master_id'] && \App\Models\ProspectActionLog::find($ProspectActionLog['id'])->JudgeAction && $ProspectActionLog['next_action_date'] === NULL)
                <?php $statusOnly = 1; ?>
{{--                @continue;--}}
              @endif
              <?php $judgeStage = $ProspectActionLog['stage_action_master_id'] ?>
              <tr class="vertical-list prospect_list">
                {{Form::hidden('ProspectId', $ProspectActionLog['prospect_id'], ['id' => 'ProspectId'])}}
                {{Form::hidden('ProspectActionLogId', $ProspectActionLog['id'], ['id' => 'ProspectActionLogId', 'class' => 'ProspectActionLogId'])}}
                @isset($ProspectActionLog['next_prospect_action_logs_id'])
                  {{Form::hidden('NextProspectActionLogId', $ProspectActionLog['next_prospect_action_logs_id'], ['id' => 'NextProspectActionLogId', 'class' => 'NextProspectActionLogId'])}}
                @endisset
                <td><p class="day">{{ $ProspectActionLog['prospect_action_logs_date'] }}</p></td>
                <td>
                <span class="stage" data-option="{{ $ProspectActionLog['CssStage'] }}">
                  {{Form::hidden('hiddenStage', $ProspectActionLog['stage_action_master_id'],['id' => 'ProspectStage'])}}
                  {{Form::hidden('hiddenStatus', $ProspectActionLog['status_action_master_id'],['id' => 'ProspectStatus'])}}
                </span>
                </td>
                <td>
                  @foreach($ProspectActionLog['action'] as $action)
                    <p class="action_list">{{ $action }}</p>
                  @endforeach
                  @if($statusOnly === 1)
                      <p class="action_list"></p>
                    @endif
                </td>
                <td><p>{{ $ProspectActionLog['UserName'] }}</p></td>
                <td><p class="prospectActionLogResult" style="overflow-wrap: break-word; width: 200px">{{ $ProspectActionLog['result'] }}</p></td>
                <td>
                  @isset($ProspectActionLog['next_action_date'])
                    <div class="stack"><p class="next_action_date">{{$ProspectActionLog['next_action_date']}}</p></div>
                  @endisset
                  @forelse($ProspectActionLog['next_action'] as $action)
                    <div class="stack" data-option="m-5"><p class="next_action_list">{{ $action }}</p></div>
                  @empty
                  @endforelse
                </td>
                <td><a class="btn ProspectActionLogEditBtn ProspectActionLogLogBtn" style="color: white;" data-option="style-edit size-s open-prospect-action-add">編集</a></td>
                <td><a class="btn prospectActionLogDelete" data-option="style-add size-s" style="border-color: indianred; color: indianred">削除</a></td>
              </tr>
          @empty
          @endforelse

          {{--          新規追加--}}
          <tr class="vertical-list prospect_list">
            {{Form::hidden('ProspectId', $firstProspect->id, ['id' => 'ProspectId'])}}
            {{Form::hidden('ProspectActionLogId', $firstProspect->prospectActionLogs->first()->id, ['id' => 'ProspectActionLogId', 'class' => 'ProspectActionLogId'])}}
            @isset($firstProspect->ProspectActionLogs->first()->NextProspectActionLogs->first()->id)
              {{Form::hidden('NextProspectActionLogId', $firstProspect->prospectActionLogs->first()->NextProspectActionLogs->first()->id, ['id' => 'NextProspectActionLogId', 'class' => 'NextProspectActionLogId'])}}
            @endif
            <td><p class="day">{{ $firstProspect->prospectActionLogs->first()->date }}</p></td>
            <td>
                <span class="stage" data-option="{{ $firstProspect->prospectActionLogs->first()->CssStageName }}">
                  {{Form::hidden('hiddenStage',$firstProspect->prospectActionLogs->first()->stage_action_master_id,['id' => 'ProspectStage'])}}
                  {{Form::hidden('hiddenStatus',$firstProspect->prospectActionLogs->first()->status_action_master_id,['id' => 'ProspectStatus'])}}
                </span>
            </td>
            <td>
              <p class="action_list">新規追加</p>
            </td>
            <td><p>{{ $firstProspect->prospectActionLogs->first()?->user?->sei }}{{ $firstProspect->prospectActionLogs->first()?->user?->mei }}</p></td>
            <td><p class="prospectActionLogResult" style="overflow-wrap: break-word; width: 200px">{{ $firstProspect->prospectActionLogs->first()->result }}</p></td>
            <td>
              @isset( $firstProspect->prospectActionLogs->first()->NextProspectActionLogs->next_action_date)
                <div class="stack"><p class="next_action_date">{{$firstProspect->prospectActionLogs->first()->NextProspectActionLogs->next_action_date}}</p></div>
              @endisset
              @if($firstProspect->prospectActionLogs->first()->NextProspectActionLogs)
                @forelse($firstProspect->prospectActionLogs->first()->NextProspectActionLogs->ActionList as $action)
                  <div class="stack" data-option="m-5"><p class="next_action_list">{{ $action }}</p></div>
                @empty
                @endforelse
              @endif
            </td>
            <td><a class="btn ProspectActionLogEditBtn firstActionBtn" style="color: white;" data-option="style-edit size-s open-prospect-action-add">編集</a></td>
            {{--            <td><a class="btn prospectActionLogDelete" data-option="style-add size-s" style="border-color: indianred; color: indianred">削除</a></td>--}}
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
