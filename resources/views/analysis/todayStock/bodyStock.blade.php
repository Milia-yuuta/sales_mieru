<div class="body_stock">
  <div class="area_chart">
    <div class="p-chart_stock">
        <?php
          $total = $data['totalCount'];
          //特別TEL無しグラフの設定
        if ($data['DiscriminationNoTELCount'] == 0) {
            $graph_1 = 0;
            $graph_height_1 = 0;
        } else {
            $graph_1 = $data['DiscriminationNoTELCount'];
            $graph_height_1 = ($graph_1 / $total * 100);
        }

        //特別TEL有グラフの設定
        if ($data['DiscriminationTELCount'] == 0) {
            $graph_2 = 0;
            $graph_height_2 = 0;
            $graph_px_2 = (168 * $graph_1 / $total);
        } else {
            $graph_2 = $data['DiscriminationTELCount'];
            $graph_height_2 = ($graph_2 / $total * 100);
            $graph_px_2 = (168 * $graph_1 / $total);
        }

        //潜在短期
        if ($data['ShortLatentCount'] == 0){
            $graph_3 = 0;
            $graph_height_3 = 0;
            $graph_px_3 = ((168 * $graph_2 / $total) + $graph_px_2);
        }else{
            $graph_3 = $data['ShortLatentCount'];
            $graph_height_3 = ($graph_3 / $total * 100);
            $graph_px_3 = ((168 * $graph_2 / $total) + $graph_px_2);
        }

        //顕在今期
        if ($data['ActualThisOvertCount'] == 0){
            $graph_4 = 0;
            $graph_height_4 = 0;
            $graph_px_4 =  ((168 * $graph_3 / $total) + $graph_px_3);
        }else{
            $graph_4 = $data['ActualThisOvertCount'];
            $graph_height_4 = ($graph_4 / $total * 100);
            $graph_px_4 = ((168 * $graph_3 / $total) + $graph_px_3);
        }

        //顕在月内
        if ($data['OvertMonthCount'] == 0){
            $graph_5 = 0;
            $graph_height_5 =0;
            $graph_px_5 = ((168 * $graph_4 / $total) + $graph_px_4);
        }else{
            $graph_5 = $data['OvertMonthCount'];
            $graph_height_5 = ($graph_5 / $total * 100);
            $graph_px_5 = ((168 * $graph_4 / $total) + $graph_px_4);
        }
        ?>
      <ul class="list_chart_stock" data-option="row_7" style="height: 230px">
        <li>
          <div class="body">
            <span class="c-count start" id="{{$data['id']}}" name="test"  data-status="DiscriminationNoTELCount" data-option="discrimination" data-num="{{$data['DiscriminationNoTELCount']}}" style="height: <?=168 * $graph_height_1 / 100?>px;"></span>
          </div>
          <div class="foot">
            <p class="ttl">判別<br />TEL無</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start" id="{{$data['id']}}"  data-status="DiscriminationTELCount" data-option="discrimination" data-num="{{$data['DiscriminationTELCount']}}" style="height: <?=168 * $graph_height_2 / 100?>px; transform: translate(0,<?='-'.$graph_px_2.'px'?>);"></span>
          </div>
          <div class="foot">
            <p class="ttl">判別<br />TEL有</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start" id="{{$data['id']}}" data-option="latent"  data-status="ShortLatentCount" data-num="{{$data['ShortLatentCount']}}" style="height: <?=168 * $graph_height_3 / 100?>px; transform: translate(0,<?='-'.$graph_px_3.'px'?>);"></span>
          </div>
          <div class="foot">
            <p class="ttl">潜在<br />短期</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start" id="{{$data['id']}}"  data-status="ActualThisOvertCount" data-option="overt" data-num="{{$data['ActualThisOvertCount']}}" style="height: <?=168 * $graph_height_4 / 100?>px; transform: translate(0,<?='-'.$graph_px_4.'px' ?>);"></span>
          </div>
          <div class="foot">
            <p class="ttl">顕在<br />今期</p>
          </div>
        </li>
        <li>
          <div class="body">
            <span class="c-count start" id="{{$data['id']}}"  data-status="OvertMonthCount" data-option="overt" data-num="{{$data['OvertMonthCount']}}" style="height: <?=168 * $graph_height_5 / 100?>px; transform: translate(0,<?='-'.$graph_px_5.'px'?>);"></span>
          </div>
          <div class="foot">
            <p class="ttl">顕在<br />月内</p>
          </div>
        </li>
        <li class="bigger">
          <div class="body">
            <span class="c-count start c-count-none" data-option="base" data-num="{{$data['totalCount']}}" style="height: 168px !important;"></span>
          </div>
          <div class="foot">
            <p class="ttl">合計</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
