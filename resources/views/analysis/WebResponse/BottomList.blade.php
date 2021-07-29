<div class="c-table" data-option="line-wrap">
  <table class="table" data-option="style-grid">
    <thead data-option="space-s">
    <tr data-option="bg-gray-light vertical-middle">
      <th data-width="80"><p>エリア</p></th>
      <th><p>営業</p></th>
      <th><p>hat</p></th>
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
    @forelse($analysisData['list'] as $data)
    <tr>
      <th><p>{{$data['area']}}</p></th>
      <th><p>{{$data['sale']}}</p></th>
      <th><p>{{$data['hat']}}</p></th>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['EchoRate'])}}%</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['AssessmentRate'])}}%</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['MediationRate'])}}%</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['ExclusiveRate'])}}%</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['EchoCount'])}}</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['ResponseCount'])}}</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['WebNegotiationCount'])}}</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['AssessmentNegotiationCount'])}}</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['MediationCount'])}}</p></td>
      <td class="right"><p class="num" data-option="size-s">{{number_format($data['ExclusiveCount'])}}</p></td>
    </tr>
    @empty
    @endforelse
    </tbody>
  </table>
</div>