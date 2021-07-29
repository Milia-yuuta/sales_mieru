<div class="l_4">
  <div class="stack"><p class="ttl" data-option="overt">顕在</p></div>
  <div class="stack" data-option="m-20">
    <div class="p-chart_stock" data-option="style-line">
      <?php
      $graph_1 = $data['overt']['StartCount'];
      $graph_2 = $data['overt']['MediationCount'];
      $graph_3 = $data['overt']['FromBottomCount'];
      $graph_4 = $data['overt']['DemotedCount'];
      $graph_5 = $data['overt']['NewCount'];
      $graph_6 = $data['overt']['EndCount'];
      if ($graph_1 > $graph_6){
        $graph = [
                $graph_1,
                $graph_2,
                $graph_3,
                $graph_4,
                $graph_5,
                $graph_6,
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
        ];
        $max = 1;
        $cur = $graph_1;
        foreach ($graph as $g) {
          $cur += $g;
          $max = $cur > $max ? $cur : $max;
        }
      }
      if ($graph_3 > 0){$max = $max + $graph_3 + $graph_2; }
      $height = $max;
      $graph_height_1 = floor(abs($graph_1 / $height * 100));
      $graph_height_2 = floor(abs($graph_2 / $height * 100));
      $graph_px_2 = floor(abs(160 * $graph_1 / $height));
      $minus_2 = floor($graph_px_2 - (160 * ($graph_height_2 / 100)));
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
      ?>
      <ul class="list_chart_stock" data-option="row_7">
        <li>
          <div class="body">
            <span class="c-count start" id="{{$data['user']['id']}}" data-name="StartCount" data-stage="overt" data-option="overt" data-num="<?=$graph_1;?>" style="height: <?=160 * $graph_height_1 / 100?>px;"></span>
          </div>
          <div class="foot">
            <p class="ttl">月初</p>
          </div>
        </li>
        <li>
          <div class="body baikai">
            <span class="c-count start <?php if($graph_2 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="MediationCount" data-stage="overt" data-option="mediation" data-num="<?=$graph_2;?>"
                  style="height: <?=160 * $graph_height_2 / 100?>px; transform: translate(0,<?php if($graph_2 === 0){echo '-'.$graph_px_3.'px';}elseif ($graph_2 < 1){ echo '-'.$minus_2.'px'; }else{ echo '-'.$graph_px_2.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">媒介</p>
          </div>
        </li>
        <li>
          <div class="body kaikara">
            <span class="c-count start <?php if($graph_3 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="FromBottomCount" data-stage="overt" data-option="latent" data-num="<?=$graph_3;?>"
                  style="height: <?=160 * $graph_height_3 / 100?>px; transform: translate(0,<?php if($graph_3 === 0){echo '-'.$graph_px_4.'px';}elseif($graph_3 < 1){echo '-'.$minus_3.'px';}else{ echo '-'.$graph_px_3.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">下位<br />Stから</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start <?php if($graph_4 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="DemotedCount" data-stage="overt" data-option="base" data-num="<?=$graph_4;?>"
                  style="height: <?=160 * $graph_height_4 / 100?>px; transform: translate(0,<?php if($graph_4 === 0){echo '-'.$graph_px_5.'px';}elseif($graph_4 < 1){echo '-'.$minus_4.'px';}else{ echo '-'.$graph_px_4.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">降格</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start <?php if($graph_5 < 1){echo 'minus';} ?>" id="{{$data['user']['id']}}" data-name="NewCount" data-stage="overt" data-option="green" data-num="<?=$graph_5;?>"
                  style="height: <?=160 * $graph_height_5 / 100?>px; transform: translate(0,<?php if($graph_5 === 0){echo '-'.$graph_px_6.'px';}elseif($graph_5 < 1){echo '-'.$minus_5.'px';}else{ echo '-'.$graph_px_5.'px'; }?>);">
            </span>
          </div>
          <div class="foot">
            <p class="ttl">新規</p>
          </div>
        </li>
        <li class="bigger">
          <div class="body">
            <span class="c-count start" data-option="overt" data-num="<?=$graph_6;?>" id="{{$data['user']['id']}}" data-name="EndCount" data-stage="overt" style="height: <?=160 * $graph_height_6 / 100?>px;"></span>
          </div>
          <div class="foot">
            <p class="ttl">月末</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>