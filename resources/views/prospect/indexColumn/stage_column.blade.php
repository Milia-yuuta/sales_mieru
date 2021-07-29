@if($ActionMasterInstance->ThisAction($prospect->stage_action_master_id)->action_name == "判別")
<td style="@if(empty($request->display_stage)) display: none @endif"><span class="stage" data-option="discrimination">{{Form::hidden('hiddenStage',$prospect->stage_action_master_id,['id' => 'ProspectStage'])}}</span></td>
@elseif($ActionMasterInstance->ThisAction($prospect->stage_action_master_id)->action_name == "潜在")
  <td style="@if(empty($request->display_stage)) display: none @endif"><span class="stage" data-option="latent"></span>{{Form::hidden('hiddenStage',$prospect->stage_action_master_id,['id' => 'ProspectStage'])}}</td>
@elseif($ActionMasterInstance->ThisAction($prospect->stage_action_master_id)->action_name == "顕在")
  <td style="@if(empty($request->display_stage)) display: none @endif"><span class="stage" data-option="overt">{{Form::hidden('hiddenStage',$prospect->stage_action_master_id,['id' => 'ProspectStage'])}}</span></td>
@elseif($ActionMasterInstance->ThisAction($prospect->stage_action_master_id)->action_name == "媒介")
  <td style="@if(empty($request->display_stage)) display: none @endif"><span class="stage" data-option="mediation">{{Form::hidden('hiddenStage',$prospect->stage_action_master_id,['id' => 'ProspectStage'])}}</span></td>
@else
<td style="@if(empty($request->display_stage)) display: none @endif"><span class="stage">{{Form::hidden('hiddenStage',$prospect->stage_action_master_id,['id' => 'ProspectStage'])}}</span></td>
@endif
