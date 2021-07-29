<div class="head_box" data-headbox-option="space_min">
    <p class="ttl h6">次回アクション予定見込</p>
</div>
<div class="body_box">
    <div class="c-table">
        <table class="table" data-option="space-s" style="display: block;">
            <thead>
            <tr>
                <th data-width="80"><p>ステージ</p></th>
                <th data-width="70"><p>ステータス</p></th>
                <th data-width="130"><p>顧客名</p></th>
                <th data-width="50"><p>担当者</p></th>
                <th data-width="130"><p>結果</p></th>
                <th data-width="130"><p>次回アクション</p></th>
            </tr>
            </thead>
            <tbody style="max-height: 250px; overflow: auto; display: block;">
            @forelse($ProspectList as $prospect)
                <?php
                $first_prospectActionLog = $prospect->prospectActionLogs->where('date', '<',$date->format('Y-m-d'))->sortByDesc('date')->sortByDesc('created_at')->first();
                if (empty($first_prospectActionLog)){
                    $first_prospectActionLog = $prospect->prospectActionLogs->where('date',$date->format('Y-m-d'))->sortByDesc('date')->sortByDesc('created_at')->first();
                }
                ?>
                @if($prospect->prospectActionLogs->where('stage_action_master_id', '>',3)->isNotEmpty() || $first_prospectActionLog?->stage_action_master_id > 3)
                    @continue;
                @endif
                <?php
                $check = false;
                $match = 0;
                foreach ($prospect->prospectActionLogs as $prospectActionLog){
                    if ($prospect->nextProspectActionLogs->first()->created_at < $prospectActionLog->created_at && $prospect->nextProspectActionLogs->first()->next_action_date < $date->startOfDay()->format('Y-m-d')){
                        $check = true;
                    }
                    if ($prospect->nextProspectActionLogs->first()->created_at < $prospectActionLog->created_at && $prospect->nextProspectActionLogs->first()->next_action_date === $prospectActionLog->date){
                        $match = 1;
                    }
                    if ($prospectActionLog->date >= $date->format('Y-m-d') && $match === 0){
                        $check = false;
                    }
                }
                ?>
                @if($check)
                    @continue;
                @endif
                <tr>
                    <td style="width: 80px; margin-right: 10px">
                        <span class="stage" data-stage="{{$first_prospectActionLog?->CssStageName}}"></span>
                        <?php
                        $stageCheck = 0;
                        $statusCheck = 0;
                        ?>
                        @forelse($prospect->prospectActionLogs as $prospectActionLog)
                            @if($stageCheck === $prospectActionLog->stage_action_master_id && $prospectActionLog->JudgeAction)
                                @continue
                            @endif
                            @if($prospect->nextProspectActionLogs->first()->created_at< $prospectActionLog->created_at && $prospectActionLog->date === $date->format('Y-m-d'))
                                <span class="stage" data-stage="{{$prospectActionLog->CssStageName}}"></span>
                            @endif
                            <?php
                            $stageCheck = $prospectActionLog->stage_action_master_id;
                            $statusCheck = $prospectActionLog->status_action_master_id;
                            ?>
                        @empty
                        @endforelse
                    </td>
                    <td style="width: 70px">
                        <p>{{ \App\Models\ActionMaster::find($first_prospectActionLog?->status_action_master_id)?->action_name}}</p>
                        <?php
                        $stageCheck = 0;
                        $statusCheck = 0;
                        ?>
                        @forelse($prospect->prospectActionLogs as $prospectActionLog)
                            @if($stageCheck === $prospectActionLog->stage_action_master_id && $prospectActionLog->JudgeAction)
                                @continue
                            @endif
                            @if($prospect->nextProspectActionLogs->first()->created_at < $prospectActionLog->created_at && $prospectActionLog->date === $date->format('Y-m-d'))
                                <p>{{ \App\Models\ActionMaster::find($prospectActionLog->status_action_master_id)->action_name}}</p>
                            @endif
                            <?php
                            $stageCheck = $prospectActionLog->stage_action_master_id;
                            $statusCheck = $prospectActionLog->status_action_master_id;
                            ?>
                        @empty
                        @endforelse
                    </td>
                    <td style="width: 130px"><p>{{$prospect->propertyRooms->first()->property->property_name}}</p></td>
                    <td style="width: 50px"><p>{{$prospect->propertyRooms->first()->room_name}}</p></td>
                    <td style="width: 130px">
                        <?php
                        $stageCheck = 0;
                        $statusCheck = 0;
                        ?>
                        @forelse($prospect->prospectActionLogs as $prospectActionLog)
                            @if($stageCheck === $prospectActionLog->stage_action_master_id && $statusCheck && $prospectActionLog->JudgeAction)
                                @continue
                            @endif
                            @if($prospect->nextProspectActionLogs->first()->created_at < $prospectActionLog->created_at && $prospectActionLog->date === $date->format('Y-m-d'))
                                <div class="f" style="border-radius: 3px; border: solid 1px #3B96DD; margin-bottom: 5px" data-option="style-line size-m space-s">
                                    @if($prospectActionLog->JudgeAction)
                                        <p>ステージ変更のみ</p>
                                    @else
                                    @foreach($prospectActionLog->ActionList as $actionList)
                                        <p>{{$actionList}}</p>
                                    @endforeach
                                        @endif
                                </div>
                            @endif
                            <?php
                            $stageCheck = $prospectActionLog->stage_action_master_id;
                            $statusCheck = $prospectActionLog->status_action_master_id;
                            ?>
                        @empty
                        @endforelse
                    </td>
                    <td style="width: 110px">
                        <a class="btn open_btn" id="{{$prospect->id}}" data-option="style-line size-m space-s" style="height: 100%">
                            {{$prospect->nextProspectActionLogs->first()->next_action_date}}<br>
                            @forelse($prospect->nextProspectActionLogs->first()->ActionList as $list) {{$list}} <br> @empty @endforelse
                        </a>
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>
{{--<div class="c-pager" style="margin: 10px">--}}
{{--    <div class="total">--}}
{{--        <p data-total="{{ number_format($ProspectList->total()) }}">{{$ProspectList->lastItem()}}</p>--}}
{{--    </div>--}}
{{--    <ul class="area_pager">--}}
{{--        {{ $ProspectList->appends(request()->input())->links('vendor.pagination.default') }}--}}
{{--    </ul>--}}
{{--</div>--}}
