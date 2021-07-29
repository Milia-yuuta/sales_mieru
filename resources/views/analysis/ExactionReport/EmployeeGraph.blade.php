@forelse($analysisData['graph'] as $index => $data)
<li>
  <article>
    <div class="area_chart">
      <div class="wra_chart">
        <canvas id="excavation_report_{{ $index + 1 }}" height="200" style="z-index: 1"></canvas>
        <p class="num" data-ttl="見込発生" style="font-size: 25px">{{$data['total']}}</p>
      </div>
      <p class="ttl">{{$data['person']['user_name']}}</p>
    </div>
  </article>
</li>
@empty
@endforelse