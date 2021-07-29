<div class="l_4">
  <div class="stack">
    <p class="ttl" data-option="discrimination">判別</p>
  </div>
  <div class="stack" data-option="m-20">
    <div class="p-chart_stock" data-option="style-line">
      <?php
      $graph_1 = $data['discrimination']['StartCount'];
      $graph_2 = $data['discrimination']['MediationCount'];
      $graph_3 = $data['discrimination']['StageUpCount'];
      $graph_4 = $data['discrimination']['StageDiscriminationDownCount'];
      $graph_5 = $data['discrimination']['DemotedCount'];
      $graph_6 = $data['discrimination']['NewCount'];
      $graph_7 = $data['discrimination']['EndCount'];
      if ($graph_1 > $graph_7){
        $graph = [
                $graph_1,
                $graph_2,
                $graph_3,
                $graph_4,
                $graph_5,
                $graph_6,
                $graph_7
        ];
        $max = 1;
        $cur = $graph_1;
        foreach ($graph as $g) {
          //            $cur += $g;
          $max = $cur > $max ? $cur : $max;
        }
      }else{
        $graph = [
                $graph_2,
                $graph_3,
                $graph_4,
                $graph_5,
                $graph_6,
        ];
        $max = 1;
        $cur = $graph_1;
        foreach ($graph as $g) {
          $cur += $g;
          $max = $cur > $max ? $cur : $max;
        }
      }
      $height = $max;
      $graph_height_1 = floor(abs($graph_1 / $height * 100));
      $graph_height_2 = floor(abs($graph_2 / $height * 100));
      $graph_px_2 = floor(abs(160 * $graph_1 / $height));
      $minus_2 = floor($graph_px_2 - (160 * ($graph_height_2 / 100)));
      //        if ($graph_1 > $graph_7){ $minus_2 = $minus_2 / 2;}
      if($graph_height_2 < 2){ $minus_2 = $minus_2 - 4;}
      $graph_height_3 = floor(abs($graph_3 / $height * 100));
      $graph_px_3 = floor(abs((160 * $graph_2 / $height) + $graph_px_2));
      $minus_3 = floor($graph_px_3 - (160 * ($graph_height_3 / 100)));
      if($graph_height_3 < 2){ $minus_3 = $minus_3 - 4;}
      $graph_height_4 = floor(abs($graph_4 / $height * 100));
      $graph_px_4 = floor(abs((160 * $graph_3 / $height) + $graph_px_3));
      $minus_4 = floor($graph_px_4 - (160 * ($graph_height_4 / 100)));
      if($graph_height_4 < 2){ $minus_4 = $minus_4 - 4;}
      $graph_height_5 = floor(abs($graph_5 / $height * 100));
      $graph_px_5 = floor(abs((160 * $graph_4 / $height) + $graph_px_4));
      $minus_5 = floor($graph_px_5 - (160 * ($graph_height_5 / 100)));
      if($graph_height_5 < 2){ $minus_5 = $minus_5 - 4;}
      $graph_height_6 = floor(abs($graph_6 / $height * 100));
      $graph_px_6 = floor(abs((160 * $graph_5 / $height) + $graph_px_5));
      $minus_6 = floor($graph_px_6 - (160 * ($graph_height_6 / 100)));
      if($graph_height_6 < 2){ $minus_6 = $minus_6 - 4;}
      $graph_height_7 = floor(abs($graph_7 / $height * 100));
      $graph_px_7 = floor(abs((160 * $graph_6 / $height) + $graph_px_6));
      $minus_7 = floor($graph_px_7 - (160 * ($graph_height_7 / 100)));
      if($graph_height_7 < 2){ $minus_7 = $minus_7 - 4;}
      ?>
      <ul class="list_chart_stock" data-option="row_7">
        <li>
          <div class="body">
            <span class="c-count start" id="{{$data['user']['id']}}" data-name="StartCount" data-stage="discrimination" data-option="discrimination" data-num="<?=$graph_1;?>" style="height: <?=160 * $graph_height_1 / 100?>px;"></span>
          </div>
          <div class="foot">
            <p class="ttl">月初</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start <?php if($graph_2 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="MediationCount" data-stage="discrimination" data-option="mediation" data-num="<?=$graph_2;?>"
                  style="height: <?=160 * $graph_height_2 / 100?>px; transform: translate(0,<?php if($graph_2 === 0){echo '-'.$graph_px_3.'px';}elseif ($graph_2 < 1){ echo '-'.$minus_2.'px'; }else{ echo '-'.$graph_px_2.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">媒介</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start <?php if($graph_3 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="StageUpCount" data-stage="discrimination" data-option="latent" data-num="<?=$graph_3;?>"
                  style="height: <?=160 * $graph_height_3 / 100?>px; transform: translate(0,<?php if($graph_3 === 0){echo '-'.$graph_px_4.'px';}elseif($graph_3 < 1){echo '-'.$minus_3.'px';}else{ echo '-'.$graph_px_3.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">上位<br />Stへ</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start <?php if($graph_4 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="StageDiscriminationDownCount" data-stage="discrimination" data-option="overt" data-num="<?=$graph_4;?>"
                  style="height: <?=160 * $graph_height_4 / 100?>px; transform: translate(0,<?php if($graph_4 === 0){echo '-'.$graph_px_5.'px';}elseif($graph_4 < 1){echo '-'.$minus_4.'px';}else{ echo '-'.$graph_px_4.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">上位<br />Stから</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start <?php if($graph_5 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="DemotedCount" data-stage="discrimination" data-option="base" data-num="<?=$graph_5;?>"
                  style="height: <?=160 * $graph_height_5 / 100?>px; transform: translate(0,<?php if($graph_5 === 0){echo '-'.$graph_px_6.'px';}elseif($graph_5 < 1){echo '-'.$minus_5.'px';}else{ echo '-'.$graph_px_5.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">降格</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start <?php if($graph_6 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="NewCount" data-stage="discrimination" data-option="green" data-num="<?=$graph_6;?>"
                  style="height: <?=160 * $graph_height_6 / 100?>px; transform: translate(0,<?php if($graph_6 < 1){echo '-'.$minus_6.'px';}else{ echo '-'.$graph_px_6.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">新規</p>
          </div>
        </li>
        <li class="bigger">
          <div class="body">
            <span class="c-count start" data-option="discrimination" data-num="<?=$graph_7;?>" id="{{$data['user']['id']}}" data-name="EndCount" data-stage="discrimination" style="height: <?=160 * $graph_height_7 / 100?>px;"></span>
          </div>
          <div class="foot">
            <p class="ttl">月末</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>