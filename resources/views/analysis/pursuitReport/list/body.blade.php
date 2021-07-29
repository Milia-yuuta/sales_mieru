<tr>
{{--  担当者--}}
  <th class="sticky"><p>{{$IndividualData['user']['user_name']}}</p>
{{--    判別--}}
  {{--  ストック数--}}
  <td><p class="num">{{$IndividualData['discrimination']['StartMonthStockCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['ToMonthNewCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['StockTotalCount']}}</p></td>
  {{--  ステージUP--}}
  <td><p class="num">{{$IndividualData['discrimination']['StageUpCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['StageUpRate']}}%</p></td>
  {{--行動量--}}
  <td><p class="num">{{$IndividualData['discrimination']['TelCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['LetterCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['VisitCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['VisitCaretakerCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['TelCaretakerCount']}}</p></td>
  <td><p class="num">{{$IndividualData['discrimination']['OnSiteCheckCount']}}</p></td>
{{--潜在--}}
  {{--  ストック数--}}
  <td><p class="num">{{$IndividualData['latent']['StartMonthStockCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['ToMonthNewCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['StockTotalCount']}}</p></td>
  {{--  ステージUP率--}}
  <td><p class="num">{{$IndividualData['latent']['StageUpCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['StageUpRate']}}%</p></td>
  {{--  追客--}}
  <td><p class="num">{{$IndividualData['latent']['TelCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['EmailCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['LetterCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['VisitCount']}}</p></td>
  {{--調査--}}
  <td><p class="num">{{$IndividualData['latent']['VisitCaretakerCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['TelCaretakerCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['OnSiteCheckCount']}}</p></td>
  {{--商談--}}
  <td><p class="num">{{$IndividualData['latent']['SendAssessmentReportCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['AssessmentReportEmailCount']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['AssessmentNegotiation']}}</p></td>
  <td><p class="num">{{$IndividualData['latent']['ReNegotiation']}}</p></td>
{{--顕在--}}
  {{--  ストック数--}}
  <td><p class="num">{{$IndividualData['overt']['StartMonthStockCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['ToMonthNewCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['StockTotalCount']}}</p></td>
  {{--ステージUP率--}}
  <td><p class="num">{{$IndividualData['overt']['StageUpCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['OtherStagesMediatedFromCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['StageUpTotal']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['StageUpRate']}}%</p></td>
  {{--追客--}}
  <td><p class="num">{{$IndividualData['overt']['TelCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['EmailCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['LetterCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['VisitCount']}}</p></td>
  {{--調査--}}
  <td><p class="num">{{$IndividualData['overt']['VisitCaretakerCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['TelCaretakerCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['OnSiteCheckCount']}}</p></td>
  {{--商談--}}
  <td><p class="num">{{$IndividualData['overt']['SendAssessmentReportCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['AssessmentReportEmailCount']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['AssessmentNegotiation']}}</p></td>
  <td><p class="num">{{$IndividualData['overt']['ReNegotiation']}}</p></td>
</tr>