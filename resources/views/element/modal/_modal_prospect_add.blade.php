<!-- 表示モーダル html(footerなどに) -->
<div class="remodal" data-remodal-id="modal_prospect_add" data-remodal-options="hashTracking:false" >
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
							<p class="ttl">顧客名</p>
						</div>
						<div class="cnt">
							<div class="f">
								<!-- ! select2 ============================== -->
								<div class="f_parts" data-option="style-select">
									{{Form::select('property_id', $PropertyInstance->PropertyNameList, old('property_id'), ['class'=>'undefined'])}}
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
									<input type="number" id="prospect_room" name="property_rooms[room_name]" placeholder="太郎課長" class="num" data-option="size-" required>
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
								<div class="f_parts">
									<input type="date"  name="date" value="" placeholder="<?php date_default_timezone_set('UTC'); echo date('Y.m.d'); ?>" required>
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
									{{Form::select('undefined', $ActionMasterInstance->TopGeneratingMedium, old('undefined'))}}
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
									{{Form::select('generating_medium_master_id', $ActionMasterInstance->GeneratingMedium, old('generating_medium_master_id'))}}
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
									{{Form::select('prospect_action_logs[stage_action_master_id]', $ActionMasterInstance->StageList, old('stage_action_master_id'))}}
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
									{{Form::select('prospect_action_logs[status_action_master_id]', $ActionMasterInstance->ModelStatusList, old('property_action_logs[status_action_master_id]'))}}
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
					<button class="btn" data-option="size-l">顧客を登録する</button>
				</div>
			</div>
		</form>
	</div>
</div>
