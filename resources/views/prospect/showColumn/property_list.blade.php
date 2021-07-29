<div class="panel_tab">
  <div class="l">
    <div class="l_auto">
      <p class="ttl h6">顧客情報</p>
    </div>
  </div>
  <div class="l" data-space="m-20">
    <div class="l_auto">
      <ul class="list_form">
        <li>
          <div class="head">
            <p class="ttl">顧客コード</p>
          </div>
          <div class="cnt">
            <p>{{ $property->code }}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">住所</p>
          </div>
          <div class="cnt">
            <p style="width: 700px; overflow: hidden">{{ $property->Address }}</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">アクセス</p>
          </div>
          <div class="cnt">
            <p style="width: 700px; overflow: hidden">{{ $property->nearest_station }}　@if($property->bus_stop_walk_time > 0) バス{{ $property->bus_stop_walk_time }}分@endif　@if($property->nearest_station_walk_time > 0)徒歩{{ $property->nearest_station_walk_time }}分@endif</p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">竣工年月</p>
          </div>
          <div class="cnt">
            <p class="wareki_target">{{$property?->date_completion?->format('Y-m')}}<span class="wareki_insert"><span></p>
          </div>
        </li>
        <li>
          <div class="head">
            <p class="ttl">戸数</p>
          </div>
          <div class="cnt">
            <p>{{$property->total_unit}}戸</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>