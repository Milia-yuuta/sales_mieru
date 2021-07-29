@forelse($analysisData['user'] as $data)
  @unset($data['area']['areaTotal'], $data['company']['companyTotal'], $data['pre']['preTotal'], $data['re']['reTotal'], $data['other']['otherTotal'])
{{--  sales--}}
<tr>
  <th class="sticky" rowspan="4"><p>{{$data['sale']['area_name']}}</p></th>
  <th class="sticky"><p>{{$data['sale']['person']['user_name']}}</p></th>
  @foreach($data['sale']['area'] as $index => $areaDate)
  <th @if(($loop->index+1) % 2 === 0) style="background-color:whitesmoke;" rowspan="4" @endif><p>{{$areaDate}}</p></th>
  @endforeach
  @foreach($data['sale']['company'] as $index => $companyDate)
  <th @if(($loop->index+1) % 2 === 0 ) style="background-color:whitesmoke;" rowspan="4" @endif><p>{{$companyDate}}</p></th>
  @endforeach
  @foreach($data['sale']['re'] as $index => $reDate)
  <th @if(($loop->index+1) % 2 === 0) style="background-color:whitesmoke;" rowspan="4" @endif><p>{{$reDate}}</p></th>
  @endforeach
  @foreach($data['sale']['pre'] as $index => $preDate)
  <th @if(($loop->index+1) % 2 === 0) style="background-color:whitesmoke;" rowspan="4" @endif><p>{{$preDate}}</p></th>
  @endforeach
  @foreach($data['sale']['other'] as $index => $otherDate)
  <th @if(($loop->index+1) % 2 === 0) style="background-color:whitesmoke;" rowspan="4" @endif><p>{{$otherDate}}</p></th>
  @endforeach
<tr>
{{--  hat--}}
  <tr>
    <th class="sticky"><p>{{$data['hat']['person']['user_name']}}</p></th>
    @foreach($data['hat']['area'] as $index => $areaDate)
      <th><p>{{$areaDate}}</p></th>
    @endforeach
    @foreach($data['hat']['company'] as $index => $companyDate)
      <th><p>{{$companyDate}}</p></th>
    @endforeach
    @foreach($data['hat']['re'] as $index => $reDate)
      <th><p>{{$reDate}}</p></th>
    @endforeach
    @foreach($data['hat']['pre'] as $index => $preDate)
      <th><p>{{$preDate}}</p></th>
    @endforeach
    @foreach($data['hat']['other'] as $index => $otherDate)
      <th><p>{{$otherDate}}</p></th>
  @endforeach
  <tr>
@empty
@endforelse