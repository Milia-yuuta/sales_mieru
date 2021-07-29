<div class="c-table" data-option="line-wrap" style="max-width: 800px">
  <table class="table" data-option="style-grid">
    <thead data-option="space-s">
    <tr data-option="bg-blue vertical-middle">
      <th data-width="80"><p>反応有率</p></th>
      <th data-width="80"><p>査定率</p></th>
      <th data-width="80"><p>媒介率</p></th>
      <th data-width="80"><p>専任専属<br />売主率</p></th>
      <th data-width="80"><p>反響数</p></th>
      <th data-width="80"><p>反応有数</p></th>
      <th data-width="80"><p>Web商談数</p></th>
      <th data-width="80"><p>査定数</p></th>
      <th data-width="80"><p>媒介数</p></th>
      <th data-width="80"><p>専任専属<br />売主数</p></th>
    </tr>
    </thead>
    <tbody>
    <tr data-option="bg-gray-ligh">
      @forelse($analysisData['average'] as $index => $averageResult)
      <th class="right"><p class="num {{$index}}">{{$averageResult}}%</p></th>
      @empty
      @endforelse
      @forelse($analysisData['sum'] as $index => $sumResult)
        <th class="right"><p class="num {{$index}}">{{$sumResult}}</p></th>
      @empty
      @endforelse
    </tr>
    </tbody>
  </table>
</div>