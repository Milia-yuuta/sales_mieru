<!-- 表示モーダル html(footerなどに) -->
<div class="remodal" data-remodal-id="modal_mansion_add" data-remodal-options="hashTracking:false">
	<div class="c-modal" data-option="w-560">
		{{ Form::open( ['route' => ['property.store'], 'file' => true, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
		@CSRF
		{{Form::hidden('user_id',$loginUser->id)}}
		<button data-remodal-action="close" class="remodal-close"></button>
		<div class="head">
			<p class="ttl">新規顧客登録</p>
		</div>
		<div class="body">
			<ul class="c-list" data-option="head-160">
				<li>
					<div class="head">
						<p class="ttl">顧客コード</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
								<input type="text" id="" name="code" placeholder="210-0004-001" value="" class="num" required>
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
							<div class="f_parts">
								{{Form::select('office_master_id', $UserMaster->OfficeList, Auth::user()->office_master_id,[ 'required' => 'true'])}}
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="head">
						<p class="ttl">エリア</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
								{{Form::select('area_master_id', $ActionMasterInstance->AreaSetList, Auth::user()->AreaSearch,[ 'required' => 'true'])}}
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="head">
						<p class="ttl">顧客名</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
								{{Form::text('property_name', NULL,['placeholder' => 'サンプル半蔵門', 'required' => 'true'])}}
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="head">
						<p class="ttl">都道府県</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
									{{Form::select('prefecture_master_id',$PrefectureList->PrefectureName,12,[ 'required' => 'true'])}}
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="head">
						<p class="ttl">市町村区</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
								{{Form::text('address1',NULL,['required' => 'true', 'placeholder' => '千代田区麹町'])}}
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="head">
						<p class="ttl">番地</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
								{{Form::text('address2',NULL,['required' => 'true', 'placeholder' => '４丁目５−２２'])}}
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="head">
						<p class="ttl">最寄駅</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
								{{Form::text('nearest_station',NULL,['placeholder' => '東京駅'])}}
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="head">
						<p class="ttl">最寄駅徒歩(分)</p>
					</div>
					<div class="cnt">
						<div class="f">
							<div class="f_parts">
								{{Form::number('nearest_station_walk_time', NULL,['placeholder' => '5'])}}
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="foot">
			<div class="btnarea" data-flex="justify-center" style="margin-top: 15px">
				<button class="btn" data-option="size-l" type="submit">顧客を登録する</button>
			</div>
		</div>
		{{Form::close()}}
	</div>
	<script>
		const now = @json(\Carbon\Carbon::now()->format('Y-m-d'));
		$('#date_form').on('change', function(){
			if ($(this).val() > now){
				$(this).val('')
				alert('未来の日付が選択されています。');
			}
		});
	</script>
</div>