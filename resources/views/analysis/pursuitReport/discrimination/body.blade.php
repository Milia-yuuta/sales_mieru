<div class="stack" data-flex="align-center justify-end">
  <p>集計期間内新規発生数</p>
  <p>集計開始時ストック数</p>
</div>
<div class="stack" style="overflow: auto">
{{--  {{dd(count($analysisData['graph']['discrimination']['user_name']))}}--}}
  <div class="p-scroll_pursuit" @if(count($analysisData['graph']['discrimination']['user_name']) > 8) style="width:{{count($analysisData['graph']['discrimination']['user_name'])*40}}px" @endif>
    <canvas id="pursuit_stock_discrimination" height="200"></canvas>
  </div>
</div>