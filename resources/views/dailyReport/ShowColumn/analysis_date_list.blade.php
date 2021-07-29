<div class="area_tab">
  <ul class="list_tab_button">
    <li class="current_tab">
      <div class="button_tab">発掘行動</div>
    </li>
    <li><div class="button_tab">追客行動</div></li>
    <li><div class="button_tab">活動時間</div></li>
    {{--    <li><div class="button_tab">販売行動</div></li>--}}
  </ul>
  <div class="panel_tab show_tab">
    <!-- ! エリア発掘 社内発掘 前取 -->
    <div class="l" data-space="10">
      <div class="l_6">
        <div class="c-table" data-option="style-box" data-ttl="エリア発掘">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th data-width="150"></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            @foreach($ExcavationBehaviorLogAnalysis['area'] as $title => $times)
              <tr>
                <th><p>{{$title}}</p></th>
                @foreach($times as $time)
                  <td><p class="num">{{$time}}</p></td>
                @endforeach
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="l_6">
        <div class="c-table" data-option="style-box" data-ttl="社内発掘">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th data-width="130"></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            @foreach($ExcavationBehaviorLogAnalysis['office'] as $title => $times)
              <tr>
                <th><p>{{$title}}</p></th>
                @foreach($times as $time)
                  <td><p class="num">{{$time}}</p></td>
                @endforeach
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <div class="c-table" data-option="style-box" data-ttl="前取">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th data-width="130"></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            @foreach($ExcavationBehaviorLogAnalysis['pre'] as $title => $times)
              <tr>
                <th><p>{{$title}}</p></th>
                @foreach($times as $time)
                  <td><p class="num">{{$time}}</p></td>
                @endforeach
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="panel_tab">
    <div class="l">
      <div class="l_auto">
        <p class="ttl h6">判別</p>
      </div>
    </div>
    <div class="l" data-space="10">
      <div class="l_6">
        <div class="c-table" data-option="style-box ttl-blue" data-ttl="追客">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>見込℡ 在宅数</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['TELHomeToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['TELHomeToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['TELHomeToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>手紙送付</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['SendLetterToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['SendLetterToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['SendLetterToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>現地手紙</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['LocalLetterToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['LocalLetterToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['LocalLetterToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>戸別訪問在宅数</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['VisitToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['VisitToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['VisitToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>メール送信</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['EmailToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['EmailToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['EmailToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>その他</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['PursuitOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['PursuitOtherMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['PursuitOtherPeriod']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="l_6">
        <p class="ttl"></p>
        <div class="c-table" data-option="style-box ttl-blue" data-ttl="調査">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th data-width="130"></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>管理人訪問</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['VisitCaretakerToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['VisitCaretakerToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['VisitCaretakerToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>管理人℡</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['TELCaretakerToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['TELCaretakerToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['TELCaretakerToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>現地C</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['OnSiteCheckToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['OnSiteCheckToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['OnSiteCheckToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>その他</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['ResearchOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['ResearchOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['discrimination']['ResearchOtherToday']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="l" data-space="m-14">
      <div class="l_auto">
        <p class="ttl h6">潜在</p>
      </div>
    </div>
    <div class="l" data-space="10">
      <div class="l_6">
        <div class="c-table" data-option="style-box ttl-yellow" data-ttl="追客">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>見込℡ 在宅数</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['TELHomeToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['TELHomeToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['TELHomeToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>手紙送付</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['SendLetterToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['SendLetterToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['SendLetterToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>現地手紙</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['LocalLetterToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['LocalLetterToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['LocalLetterToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>メール送信</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['EmailToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['EmailToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['EmailToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>戸別訪問在宅数</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['VisitToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['VisitToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['VisitToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>その他</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['PursuitOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['PursuitOtherMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['PursuitOtherPeriod']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
        <div class="c-table" data-option="style-box ttl-yellow" data-ttl="調査">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th data-width="150"></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>管理人訪問</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['VisitCaretakerToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['VisitCaretakerToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['VisitCaretakerToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>管理人℡</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['TELCaretakerToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['TELCaretakerToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['TELCaretakerToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>現地C</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['OnSiteCheckToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['OnSiteCheckToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['OnSiteCheckToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>その他</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['ResearchOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['ResearchOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['ResearchOtherToday']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="l_6">
        <div class="c-table" data-option="style-box ttl-yellow" data-ttl="商談">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>査定書送付</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['SendAssessmentReportToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['SendAssessmentReportToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['SendAssessmentToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>査定書メール送信</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['AssessmentReportEmailToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['AssessmentReportEmailToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['AssessmentReportEmailToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>Web商談</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['WebNegotiationToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['WebNegotiationToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['WebNegotiationToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>査定・商談</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['AssessmentNegotiationToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['AssessmentNegotiationToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['AssessmentNegotiationToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>再商談</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['ReNegotiationToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['ReNegotiationToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['latent']['ReNegotiationToPeriod']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="l" data-space="m-14">
      <div class="l_auto">
        <p class="ttl h6">顕在</p>
      </div>
    </div>
    <div class="l" data-space="10">
      <div class="l_6">
        <div class="c-table" data-option="style-box ttl-orange" data-ttl="追客">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>見込℡ 在宅数</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['TELHomeToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['TELHomeToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['TELHomeToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>手紙送付</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['SendLetterToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['SendLetterToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['SendLetterToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>現地手紙</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['LocalLetterToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['LocalLetterToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['LocalLetterToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>メール送信</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['EmailToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['EmailToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['EmailToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>戸別訪問在宅数</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['VisitToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['VisitToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['VisitToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>その他</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['PursuitOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['PursuitOtherMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['PursuitOtherPeriod']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
        <div class="c-table" data-option="style-box ttl-orange" data-ttl="調査">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th data-width="150"></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>管理人訪問</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['VisitCaretakerToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['VisitCaretakerToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['VisitCaretakerToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>管理人℡</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['TELCaretakerToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['TELCaretakerToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['TELCaretakerToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>現地C</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['OnSiteCheckToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['OnSiteCheckToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['OnSiteCheckToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>その他</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['ResearchOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['ResearchOtherToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['ResearchOtherToday']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="l_6">
        <div class="c-table" data-option="style-box ttl-orange" data-ttl="商談">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>当日</p></th>
              <th><p>当月</p></th>
              <th><p>当半期</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>査定書送付</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['SendAssessmentReportToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['SendAssessmentReportToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['SendAssessmentToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>査定書メール送信</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['AssessmentReportEmailToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['AssessmentReportEmailToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['AssessmentReportEmailToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>Web商談</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['WebNegotiationToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['WebNegotiationToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['WebNegotiationToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>査定・商談</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['AssessmentNegotiationToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['AssessmentNegotiationToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['AssessmentNegotiationToPeriod']}}</p></td>
            </tr>
            <tr>
              <th><p>再商談</p></th>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['ReNegotiationToday']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['ReNegotiationToMonth']}}</p></td>
              <td><p class="num">{{$ProspectActionLogAnalysis['overt']['ReNegotiationToPeriod']}}</p></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="panel_tab">
    <!-- ! エリア -->
    <div class="l">
      <div class="l_auto">
        <div class="c-table" data-option="style-box" data-ttl="エリア">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>A</p></th>
              <th><p>B</p></th>
              <th><p>C</p></th>
              <th><p>D</p></th>
              <th><p>E</p></th>
              <th><p>F</p></th>
              <th><p>G</p></th>
              <th><p>H</p></th>
              <th><p>累計</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>当月</p></th>
              @forelse($activeTime['ToMonth']['ToMonthArea'] as $AreaTitle => $time)
                <td><p class="num">{{$time}}h</p></td>
              @empty
              @endforelse
            </tr>
            <tr>
              <th><p>当半期</p></th>
              @forelse($activeTime['HalfPeriod']['HalfPeriodArea'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @empty
              @endforelse
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- ! 社内 -->
    <div class="l" data-space="m-10">
      <div class="l_auto">
        <div class="c-table" data-option="style-box" data-ttl="社内">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>仕入作業</p></th>
              <th><p>事務作業</p></th>
              <th><p>累計</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>当月</p></th>
              @forelse($activeTime['ToMonth']['ToMonthOffice'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @empty
              @endforelse
            </tr>
            <tr>
              <th><p>当半期</p></th>
              @forelse($activeTime['HalfPeriod']['HalfPeriodOffice'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @empty
              @endforelse
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- ! 査定/訪問等 -->
    <div class="l" data-space="m-10">
      <div class="l_auto">
        <div class="c-table" data-option="style-box" data-ttl="査定/訪問等">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>Web商談</p></th>
              <th><p>査定・商談</p></th>
              <th><p>再商談</p></th>
              <th><p>累計</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>当月</p></th>
              @forelse($activeTime['ToMonth']['ToMonthOpportunity'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @empty
              @endforelse
            </tr>
            <tr>
              <th><p>当半期</p></th>
              @foreach($activeTime['HalfPeriod']['HalfPeriodOpportunity'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @endforeach
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- ! 事務
    作業 会議/研修 -->
    <div class="l" data-space="10">
      <div class="l_6">
        <div class="c-table" data-option="style-box" data-ttl="会議/研修">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>社内会議</p></th>
              <th><p>研修</p></th>
              <th><p>累計</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>当月</p></th>
              @foreach($activeTime['ToMonth']['ToMonthMeeting'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @endforeach
            </tr>
            <tr>
              <th><p>当半期</p></th>
              @foreach($activeTime['HalfPeriod']['HalfPeriodMeeting'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @endforeach
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- ! 販売行動 その他 -->
    <div class="l" data-space="10">
      <div class="l_6">
        <div class="c-table" data-option="style-box" data-ttl="販売行動">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>販売行動</p></th>
              <th><p>契約行動</p></th>
              <th><p>決済行動</p></th>
              <th><p>累計</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>当月</p></th>
              @foreach($activeTime['ToMonth']['ToMonthSale'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @endforeach
            </tr>
            <tr>
              <th><p>当半期</p></th>
              @foreach($activeTime['HalfPeriod']['HalfPeriodSale'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @endforeach
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="l_6">
        <div class="c-table" data-option="style-box" data-ttl="その他">
          <table class="table" data-option="style-grid">
            <thead>
            <tr>
              <th></th>
              <th><p>その他</p></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <th><p>当月</p></th>
              @foreach($activeTime['ToMonth']['ToMonthOther'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @endforeach
            </tr>
            <tr>
              <th><p>当半期</p></th>
              @foreach($activeTime['HalfPeriod']['HalfPeriodOther'] as $time)
                <td><p class="num">{{$time}}h</p></td>
              @endforeach
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>