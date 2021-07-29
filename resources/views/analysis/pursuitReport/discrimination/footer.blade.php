<div class="stack" data-flex="align-center justify-end">
  <p>ステージUP数</p>
  <p>ステージUP率</p>
</div>
<?php
$max_count = $analysisData['FooterMax']['discriminationMaxStageUpCount'];
$max_percent = $analysisData['FooterMax']['discriminationMaxStageUpRate'];
?>
<div class="stack">
  <div class="p-scroll_pursuit">
    <div class="l" data-space="10">
      <div class="l_fix" data-width="30">
        <ul class="list_ticks" data-option="style-line cut-6">
          <li><p>{{$max_count}}</p></li>
          <li><p></p></li>
          <li><p>0</p></li>
        </ul>
      </div>
      <div class="l_auto">
        <div class="chart_line">
          <div class="line_3"></div>
          <div class="line_2"></div>
          <div class="line_1"></div>
        </div>
        <ul class="list_chart_yield">
          @forelse($analysisData['FooterGraph'] as $DiscriminationData)
          <li>
            <div class="body">
              <span class="c-count bar_count start" id="{{$DiscriminationData['FooterGraphDiscrimination']['user_id']}}" data-option="color-blue" data-stage-up="{{$DiscriminationData['FooterGraphDiscrimination']['StageUpCount']}}" data-stage-percent="{{$DiscriminationData['FooterGraphDiscrimination']['StageUpRate']}}" data-stage="discrimination" style="height: <?php $DiscriminationData['FooterGraphDiscrimination']['StageUpCount'] == 0 ? $height = 0 : $height = $DiscriminationData['FooterGraphDiscrimination']['StageUpCount'] / $max_count * 100; echo $height.'%'?>"></span>
              <div class="c-percent" data-optin="color-pink" data-num="" style="bottom: <?php $DiscriminationData['FooterGraphDiscrimination']['StageUpRate'] == 0 ? $height = 0 : $height = $DiscriminationData['FooterGraphDiscrimination']['StageUpRate']/$max_percent*100; echo $height.'%'?>"></div>
            </div>
            <div class="foot">
              <p class="ttl">{{$DiscriminationData['FooterGraphDiscrimination']['user_name']}}</p>
            </div>
          </li>
          @empty
          @endforelse
        </ul>
      </div>
      <div class="l_fix" data-width="30">
        <ul class="list_ticks" data-option="style-line cut-6 position-right">
          <li><p data-after="%">{{$max_percent}}</p></li>
          <li><p {{$max_percent == 0 ? '　': 'data-after=%'}}>{{$max_percent == 0 ? '　': round($max_percent / 2, 1)}}</p></li>
          <li><p data-after="%">0</p></li>
        </ul>
      </div>
    </div>
  </div>
</div>