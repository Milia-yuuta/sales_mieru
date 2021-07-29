<div class="p-pseudo_modal ">
	<div class="c-modal" data-option="w-560">
    	<button data-remodal-action="close" class="remodal-close"></button>
    	<div class="head">
      	<p class="ttl">新規顧客登録</p>
    	</div>
    	<form action="{{ route('property.store') }}" method="" accept-charset="utf-8">
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
              	    <input type="text" id="" name="" placeholder="サンプル半蔵門">
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
              	    <input type="text" id="prospect_room" name="" placeholder="太郎課長" class="num" data-option="size-">
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
              	    <input type="text" id="prospect_datepicker" name="" placeholder="<?php date_default_timezone_set('UTC'); echo date('Y.m.d'); ?>"> 
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
              	    <select id="" name="">
                	    <option value="" selected="">エリア発掘</option>
                	    <option value="">社内発掘</option>
                	    <option value="">反響</option>
                	    <option value="">前取関連</option>
                	    <option value="">その他</option>
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
              	    <select id="" name="">
                	    <option value="">管理人訪問</option>
                	    <option value="">個人訪問</option>
                	    <option value="">ポストチェック</option>
                	    <option value="">一棟チェック</option>
                	    <option value="">巡回現地情報</option>
                	    <option value="">DM手まき反響</option>
                	    <option value="">チラシ手まき反響</option>
                	    <option value="">手紙・封書手まき反響</option>
                	    <option value="">ランダム戸別訪問</option>
              	    </select> 
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
              	    <select id="" name="">
                	    <option value="" selected="">判別</option>
                	    <option value="">潜在</option>
                	    <option value="">顕在</option>
                	    <option value="">媒介</option>
                	    <option value="">発掘降格</option>
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
              	    <select id="" name="">
                	    <option value="">℡有</option>
                	    <option value="">℡無</option>
                	    <option value="">手段無</option>
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
              	    <textarea id="" name="" placeholder="電話NG"></textarea>
            	    </div>
          	    </div>
        	    </div>
        	  </li>
        	</ul>             
      	</div>
      	<div class="foot">
        	<div class="btnarea" data-flex="justify-center">
          	<button class="btn" id="property_submit" data-option="size-l">顧客を登録する</button>
        	</div>
      	</div>
    	</form>
	</div>
	<script>
		$('#property_submit').click(function (){
			$(this).css('pointer-events','none');
		})
	</script>
</div>