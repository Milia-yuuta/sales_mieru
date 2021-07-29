<div class="p-chart_yield">
  <div class="head">
    <p class="ttl">営業所全体</p>
    <div data-flex="align-center justify-end">
      <p data-label="style-square">見込発生数</p>
      <p data-label="style-square color-pink">媒介数</p>
      <p data-label="style-round color-pink">媒介率</p>
    </div>
  </div>
  <div class="body">
    <div class="l" data-space="10">
      <div class="l_fix" data-width="50" style="padding-top: 50px">
        <ul class="list_ticks" data-option="style-line cut-6">
          <li><p>{{$officeReport['ActionMax'] === 0 ? '' : $officeReport['ActionMax']}}</p></li>
          <li>
            <p></p>
          </li>
          <li>
            <p></p>
          </li>
          <li>
            <p></p>
          </li>
          <li>
            <p></p>
          </li>
          <li><p>0</p></li>
        </ul>
      </div>
      <div class="l_auto">
        <div class="chart_line" style="padding-top: 50px">
          <div class="line_6"></div>
          <div class="line_5"></div>
          <div class="line_4"></div>
          <div class="line_3"></div>
          <div class="line_2"></div>
          <div class="line_1"></div>
        </div>
          <?php
          $max = $officeReport['ActionMax'];
          ?>
        <ul class="list_chart_yield" style="padding-top: 55px" data-ttl="エリア発掘">
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['CaretakerVisitActionCount'];?>"
                    style="height: <?php $officeReport['area']['CaretakerVisitActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['CaretakerVisitActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['CaretakerVisitMediation'];?>"
                    style="height: <?php $officeReport['area']['CaretakerVisitMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['CaretakerVisitMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['CaretakerVisitRate'];?>"
                   style="bottom: <?php $officeReport['area']['CaretakerVisitRate'] == 0 ? $height = 0 : $height = $officeReport['area']['CaretakerVisitRate']; echo $height . '%'?>">
                <div class="detail" style="z-index: auto">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['area']['CaretakerVisitRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">管理人訪問</p>
            </div>
          </li>
{{--          <li>--}}
{{--            <div class="body">--}}
{{--              <span class="c-count bar_count start" data-option="color-blue"--}}
{{--                    data-num="<?=$officeReport['area']['PersonalVisitActionCount'];?>"--}}
{{--                    style="height: <?php $officeReport['area']['PersonalVisitActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['PersonalVisitActionCount'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <span class="c-count bar_count start" data-option="color-pink"--}}
{{--                    data-num="<?=$officeReport['area']['PersonalVisitMediation'];?>"--}}
{{--                    style="height: <?php $officeReport['area']['PersonalVisitMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['PersonalVisitMediation'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <div class="c-percent" data-optin="color-pink"--}}
{{--                   data-num="<?=$officeReport['area']['PersonalVisitRate'];?>"--}}
{{--                   style="bottom: <?php $officeReport['area']['PersonalVisitRate'] == 0 ? $height = 0 : $height = $officeReport['area']['PersonalVisitRate']; echo $height . '%'?>">--}}
{{--                <div class="detail" style="z-index: 1">--}}
{{--                  <p class="ttl">媒介率</p>--}}
{{--                  <p class="num" data-after="%"><?=$officeReport['area']['PersonalVisitRate'];?></p>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="foot">--}}
{{--              <p class="ttl">個人訪問</p>--}}
{{--            </div>--}}
{{--          </li>--}}
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['PostCheckActionCount'];?>"
                    style="height: <?php $officeReport['area']['PostCheckActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['PostCheckActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['PostCheckMediation'];?>"
                    style="height: <?php $officeReport['area']['PostCheckMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['PostCheckMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['PostCheckRate'];?>"
                   style="bottom: <?php $officeReport['area']['PostCheckRate'] == 0 ? $height = 0 : $height = $officeReport['area']['PostCheckRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['area']['PostCheckRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">ポストC</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['CheckTheBuildingActionCount'];?>"
                    style="height: <?php $officeReport['area']['CheckTheBuildingActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['CheckTheBuildingActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['CheckTheBuildingMediation'];?>"
                    style="height: <?php $officeReport['area']['CheckTheBuildingMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['CheckTheBuildingMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['CheckTheBuildingRate'];?>"
                   style="bottom: <?php $officeReport['area']['CheckTheBuildingRate'] == 0 ? $height = 0 : $height = $officeReport['area']['CheckTheBuildingRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['area']['CheckTheBuildingRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">一棟C</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['PatrolLocalInformationActionCount'];?>"
                    style="height: <?php $officeReport['area']['PatrolLocalInformationActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['PatrolLocalInformationActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['PatrolLocalInformationMediation'];?>"
                    style="height: <?php $officeReport['area']['PatrolLocalInformationMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['PatrolLocalInformationMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['PatrolLocalInformationRate'];?>"
                   style="bottom: <?php $officeReport['area']['PatrolLocalInformationRate'] == 0 ? $height = 0 : $height = $officeReport['area']['PatrolLocalInformationRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['area']['PatrolLocalInformationRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">巡回現地情報</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['DMActionCount'];?>"
                    style="height: <?php $officeReport['area']['DMActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['DMActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['DMMediation'];?>"
                    style="height: <?php $officeReport['area']['DMMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['DMMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['DMRate'];?>"
                   style="bottom: <?php $officeReport['area']['DMRate'] == 0 ? $height = 0 : $height = $officeReport['area']['DMRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['area']['DMRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">DM</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['FlyerActionCount'];?>"
                    style="height: <?php $officeReport['area']['FlyerActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['FlyerActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['FlyerMediation'];?>"
                    style="height: <?php $officeReport['area']['FlyerMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['FlyerMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['FlyerRate'];?>"
                   style="bottom: <?php $officeReport['area']['FlyerRate'] == 0 ? $height = 0 : $height = $officeReport['area']['FlyerRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['area']['FlyerRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">チラシ手まき</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['LatterActionCount'];?>"
                    style="height: <?php $officeReport['area']['LatterActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['LatterActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['LatterMediation'];?>"
                    style="height: <?php $officeReport['area']['LatterMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['LatterMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['LatterActionRate'];?>"
                   style="bottom: <?php $officeReport['area']['LatterActionRate'] == 0 ? $height = 0 : $height = $officeReport['area']['LatterActionRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['area']['LatterActionRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">限定手紙・封書手まき</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['area']['RandomActionCount'];?>"
                    style="height: <?php $officeReport['area']['RandomActionCount'] == 0 ? $height = 0 : $height = $officeReport['area']['RandomActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['area']['RandomMediation'];?>"
                    style="height: <?php $officeReport['area']['RandomMediation'] == 0 ? $height = 0 : $height = $officeReport['area']['RandomMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['area']['RandomActionRate'];?>"
                   style="bottom: <?php $officeReport['area']['RandomActionRate'] == 0 ? $height = 0 : $height = $officeReport['area']['RandomActionRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['area']['RandomActionRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">ランダム戸別訪問</p>
            </div>
          </li>
        </ul>
        <ul class="list_chart_yield" style="padding-top: 55px" data-ttl="社内発掘">
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['CaretakerTelActionCount'];?>"
                    style="height: <?php $officeReport['company']['CaretakerTelActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['CaretakerTelActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['CaretakerTelMediation'];?>"
                    style="height: <?php $officeReport['company']['CaretakerTelMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['CaretakerTelMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['CaretakerTelRate'];?>"
                   style="bottom: <?php $officeReport['company']['CaretakerTelRate'] == 0 ? $height = 0 : $height = $officeReport['company']['CaretakerTelRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['company']['CaretakerTelRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">管理人TEL</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['RandomTelActionCount'];?>"
                    style="height: <?php $officeReport['company']['RandomTelActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['RandomTelActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['RandomTelMediation'];?>"
                    style="height: <?php $officeReport['company']['RandomTelMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['RandomTelMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['RandomTelRate'];?>"
                   style="bottom: <?php $officeReport['company']['RandomTelRate'] == 0 ? $height = 0 : $height = $officeReport['company']['RandomTelRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['company']['RandomTelRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">ランダムTEL</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['LatterActionCount'];?>"
                    style="height: <?php $officeReport['company']['LatterActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['LatterActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['LatterMediation'];?>"
                    style="height: <?php $officeReport['company']['LatterMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['LatterMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['LatterRate'];?>"
                   style="bottom: <?php $officeReport['company']['LatterRate'] == 0 ? $height = 0 : $height = $officeReport['company']['LatterRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['company']['LatterRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">限定手紙・封書郵送</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['FlyerActionCount'];?>"
                    style="height: <?php $officeReport['company']['FlyerActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['FlyerActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['FlyerMediation'];?>"
                    style="height: <?php $officeReport['company']['FlyerMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['FlyerMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['FlyerRate'];?>"
                   style="bottom: <?php $officeReport['company']['FlyerRate'] == 0 ? $height = 0 : $height = $officeReport['company']['FlyerRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['company']['FlyerRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">チラシ宅配依頼</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['DMActionCount'];?>"
                    style="height: <?php $officeReport['company']['DMActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['DMActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['DMMediation'];?>"
                    style="height: <?php $officeReport['company']['DMMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['DMMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['DMRate'];?>"
                   style="bottom: <?php $officeReport['company']['DMRate'] == 0 ? $height = 0 : $height = $officeReport['company']['DMRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['company']['DMRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">DM郵送</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['RentalInformationActionCount'];?>"
                    style="height: <?php $officeReport['company']['RentalInformationActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['RentalInformationActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['RentalInformationMediation'];?>"
                    style="height: <?php $officeReport['company']['RentalInformationMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['RentalInformationMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['RentalInformationRate'];?>"
                   style="bottom: <?php $officeReport['company']['RentalInformationRate'] == 0 ? $height = 0 : $height = $officeReport['company']['RentalInformationRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['company']['RentalInformationRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">賃貸情報</p>
            </div>
          </li>
{{--          <li>--}}
{{--            <div class="body">--}}
{{--             <span class="c-count bar_count start" data-option="color-blue"--}}
{{--                   data-num="<?=$officeReport['company']['ReturnByMailActionCount'];?>"--}}
{{--                   style="height: <?php $officeReport['company']['ReturnByMailActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['ReturnByMailActionCount'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <span class="c-count bar_count start" data-option="color-pink"--}}
{{--                    data-num="<?=$officeReport['company']['ReturnByMailMediation'];?>"--}}
{{--                    style="height: <?php $officeReport['company']['ReturnByMailMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['ReturnByMailMediation'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <div class="c-percent" data-optin="color-pink"--}}
{{--                   data-num="<?=$officeReport['company']['ReturnByMailRate'];?>"--}}
{{--                   style="bottom: <?php $officeReport['company']['ReturnByMailRate'] == 0 ? $height = 0 : $height = $officeReport['company']['ReturnByMailRate']; echo $height . '%'?>">--}}
{{--                <div class="detail">--}}
{{--                  <p class="ttl">媒介率</p>--}}
{{--                  <p class="num" data-after="%"><?=$officeReport['company']['ReturnByMailRate'];?></p>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="foot">--}}
{{--              <p class="ttl">郵送物戻り</p>--}}
{{--            </div>--}}
{{--          </li>--}}
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['RegistrationInformationActionCount'];?>"
                    style="height: <?php $officeReport['company']['RegistrationInformationActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['RegistrationInformationActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['RegistrationInformationMediation'];?>"
                    style="height: <?php $officeReport['company']['RegistrationInformationMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['RegistrationInformationMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['RegistrationInformationRate'];?>"
                   style="bottom: <?php $officeReport['company']['RegistrationInformationRate'] == 0 ? $height = 0 : $height = $officeReport['company']['RegistrationInformationRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['company']['RegistrationInformationRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">登記情報</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['company']['BuildingConfirmationInformationActionCount'];?>"
                    style="height: <?php $officeReport['company']['BuildingConfirmationInformationActionCount'] == 0 ? $height = 0 : $height = $officeReport['company']['BuildingConfirmationInformationActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['company']['BuildingConfirmationInformationMediation'];?>"
                    style="height: <?php $officeReport['company']['BuildingConfirmationInformationMediation'] == 0 ? $height = 0 : $height = $officeReport['company']['BuildingConfirmationInformationMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['company']['BuildingConfirmationInformationRate'];?>"
                   style="bottom: <?php $officeReport['company']['BuildingConfirmationInformationRate'] == 0 ? $height = 0 : $height = $officeReport['company']['BuildingConfirmationInformationRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['company']['BuildingConfirmationInformationRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">建築確認情報</p>
            </div>
          </li>
        </ul>
        <ul class="list_chart_yield" style="padding-top: 55px" data-ttl="反響">
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['response']['HpActionCount'];?>"
                    style="height: <?php $officeReport['response']['HpActionCount'] == 0 ? $height = 0 : $height = $officeReport['response']['HpActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['response']['HpMediation'];?>"
                    style="height: <?php $officeReport['response']['HpMediation'] == 0 ? $height = 0 : $height = $officeReport['response']['HpMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['response']['HpRate'];?>"
                   style="bottom: <?php $officeReport['response']['HpRate'] == 0 ? $height = 0 : $height = $officeReport['response']['HpRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['response']['HpRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">当社HP</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['response']['SiteActionCount'];?>"
                    style="height: <?php $officeReport['response']['SiteActionCount'] == 0 ? $height = 0 : $height = $officeReport['response']['SiteActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['response']['SiteMediation'];?>"
                    style="height: <?php $officeReport['response']['SiteMediation'] == 0 ? $height = 0 : $height = $officeReport['response']['SiteMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['response']['SiteRate'];?>"
                   style="bottom: <?php $officeReport['response']['SiteRate'] == 0 ? $height = 0 : $height = $officeReport['response']['SiteRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['response']['SiteRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">一括査定サイト</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['response']['IntroductionOfficeActionCount'];?>"
                    style="height: <?php $officeReport['response']['IntroductionOfficeActionCount'] == 0 ? $height = 0 : $height = $officeReport['response']['IntroductionOfficeActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['response']['IntroductionOfficeMediation'];?>"
                    style="height: <?php $officeReport['response']['IntroductionOfficeMediation'] == 0 ? $height = 0 : $height = $officeReport['response']['IntroductionOfficeMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['response']['IntroductionOfficeRate'];?>"
                   style="bottom: <?php $officeReport['response']['IntroductionOfficeRate'] == 0 ? $height = 0 : $height = $officeReport['response']['IntroductionOfficeRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['response']['IntroductionOfficeRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">他営業所紹介</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['response']['IntroductionHeadOfficeActionCount'];?>"
                    style="height: <?php $officeReport['response']['IntroductionHeadOfficeActionCount'] == 0 ? $height = 0 : $height = $officeReport['response']['IntroductionHeadOfficeActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['response']['IntroductionHeadOfficeMediation'];?>"
                    style="height: <?php $officeReport['response']['IntroductionHeadOfficeMediation'] == 0 ? $height = 0 : $height = $officeReport['response']['IntroductionHeadOfficeMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['response']['IntroductionHeadOfficeRate'];?>"
                   style="bottom: <?php $officeReport['response']['IntroductionHeadOfficeRate'] == 0 ? $height = 0 : $height = $officeReport['response']['IntroductionHeadOfficeRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['response']['IntroductionHeadOfficeRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">本社・グループ会社紹介</p>
            </div>
          </li>
        </ul>
{{--        <ul class="list_chart_yield" style="padding-top: 55px" data-ttl="前取">--}}
{{--          <li>--}}
{{--            <div class="body">--}}
{{--              <span class="c-count bar_count start" data-option="color-blue"--}}
{{--                    data-num="<?=$officeReport['pre']['PreVisitActionCount'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreVisitActionCount'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreVisitActionCount'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <span class="c-count bar_count start" data-option="color-pink"--}}
{{--                    data-num="<?=$officeReport['pre']['PreVisitMediation'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreVisitMediation'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreVisitMediation'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <div class="c-percent" data-optin="color-pink"--}}
{{--                   data-num="<?=$officeReport['pre']['PreVisitRate'];?>"--}}
{{--                   style="bottom: <?php $officeReport['pre']['PreVisitRate'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreVisitRate']; echo $height . '%'?>">--}}
{{--                <div class="detail">--}}
{{--                  <p class="ttl">媒介率</p>--}}
{{--                  <p class="num" data-after="%"><?=$officeReport['pre']['PreVisitRate'];?></p>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="foot">--}}
{{--              <p class="ttl">前取訪問</p>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--          <li>--}}
{{--            <div class="body">--}}
{{--              <span class="c-count bar_count start" data-option="color-blue"--}}
{{--                    data-num="<?=$officeReport['pre']['PreTelActionCount'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreTelActionCount'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreTelActionCount'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <span class="c-count bar_count start" data-option="color-pink"--}}
{{--                    data-num="<?=$officeReport['pre']['PreTelMediation'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreTelMediation'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreTelMediation'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <div class="c-percent" data-optin="color-pink"--}}
{{--                   data-num="<?=$officeReport['pre']['PreTelRate'];?>"--}}
{{--                   style="bottom: <?php $officeReport['pre']['PreTelRate'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreTelRate'] / $max; echo $height . '%'?>">--}}
{{--                <div class="detail">--}}
{{--                  <p class="ttl">媒介率</p>--}}
{{--                  <p class="num" data-after="%"><?=$officeReport['pre']['PreVisitRate'];?></p>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="foot">--}}
{{--              <p class="ttl">前取TEL</p>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--          <li>--}}
{{--            <div class="body">--}}
{{--              <span class="c-count bar_count start" data-option="color-blue"--}}
{{--                    data-num="<?=$officeReport['pre']['PreSelfDiscoveryActionCount'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreSelfDiscoveryActionCount'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreSelfDiscoveryActionCount'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <span class="c-count bar_count start" data-option="color-pink"--}}
{{--                    data-num="<?=$officeReport['pre']['PreSelfDiscoveryMediation'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreSelfDiscoveryMediation'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreSelfDiscoveryMediation'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <div class="c-percent" data-optin="color-pink"--}}
{{--                   data-num="<?=$officeReport['pre']['PreSelfDiscoveryRate'];?>"--}}
{{--                   style="bottom: <?php $officeReport['pre']['PreSelfDiscoveryRate'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreSelfDiscoveryRate']; echo $height . '%'?>">--}}
{{--                <div class="detail">--}}
{{--                  <p class="ttl">媒介率</p>--}}
{{--                  <p class="num" data-after="%"><?=$officeReport['pre']['PreSelfDiscoveryRate'];?></p>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="foot">--}}
{{--              <p class="ttl">前取自己発見</p>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--          <li>--}}
{{--            <div class="body">--}}
{{--             <span class="c-count bar_count start" data-option="color-blue"--}}
{{--                   data-num="<?=$officeReport['pre']['PreResponseActionCount'];?>"--}}
{{--                   style="height: <?php $officeReport['pre']['PreResponseActionCount'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreResponseActionCount'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <span class="c-count bar_count start" data-option="color-pink"--}}
{{--                    data-num="<?=$officeReport['pre']['PreResponseMediation'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreResponseMediation'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreResponseMediation'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <div class="c-percent" data-optin="color-pink"--}}
{{--                   data-num="<?=$officeReport['pre']['PreResponseRate'];?>"--}}
{{--                   style="bottom: <?php $officeReport['pre']['PreResponseRate'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreResponseRate']; echo $height . '%'?>">--}}
{{--                <div class="detail">--}}
{{--                  <p class="ttl">媒介率</p>--}}
{{--                  <p class="num" data-after="%"><?=$officeReport['pre']['PreResponseRate'];?></p>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="foot">--}}
{{--              <p class="ttl">前取反響</p>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--          <li>--}}
{{--            <div class="body">--}}
{{--                 <span class="c-count bar_count start" data-option="color-blue"--}}
{{--                       data-num="<?=$officeReport['pre']['PreOtherActionCount'];?>"--}}
{{--                       style="height: <?php $officeReport['pre']['PreOtherActionCount'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreOtherActionCount'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <span class="c-count bar_count start" data-option="color-pink"--}}
{{--                    data-num="<?=$officeReport['pre']['PreOtherMediation'];?>"--}}
{{--                    style="height: <?php $officeReport['pre']['PreOtherMediation'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreOtherMediation'] / $max * 100; echo $height . '%'?>"></span>--}}
{{--              <div class="c-percent" data-optin="color-pink"--}}
{{--                   data-num="<?=$officeReport['pre']['PreOtherRate'];?>"--}}
{{--                   style="bottom: <?php $officeReport['pre']['PreOtherRate'] == 0 ? $height = 0 : $height = $officeReport['pre']['PreOtherRate']; echo $height . '%'?>">--}}
{{--                <div class="detail">--}}
{{--                  <p class="ttl">媒介率</p>--}}
{{--                  <p class="num" data-after="%"><?=$officeReport['pre']['PreOtherRate'];?></p>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="foot">--}}
{{--              <p class="ttl">前取その他</p>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--        </ul>--}}
        <ul class="list_chart_yield" style="padding-top: 55px" data-ttl="その他">
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['other']['BusinessInvolvementActionCount'];?>"
                    style="height: <?php $officeReport['other']['BusinessInvolvementActionCount'] == 0 ? $height = 0 : $height = $officeReport['other']['BusinessInvolvementActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['other']['BusinessInvolvementMediation'];?>"
                    style="height: <?php $officeReport['other']['BusinessInvolvementMediation'] == 0 ? $height = 0 : $height = $officeReport['other']['BusinessInvolvementMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['other']['BusinessInvolvementRate'];?>"
                   style="bottom: <?php $officeReport['other']['BusinessInvolvementRate'] == 0 ? $height = 0 : $height = $officeReport['other']['BusinessInvolvementRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['other']['BusinessInvolvementRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">業者関与</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['other']['OpenRoomActionCount'];?>"
                    style="height: <?php $officeReport['other']['OpenRoomActionCount'] == 0 ? $height = 0 : $height = $officeReport['other']['OpenRoomActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['other']['OpenRoomMediation'];?>"
                    style="height: <?php $officeReport['other']['OpenRoomMediation'] == 0 ? $height = 0 : $height = $officeReport['other']['OpenRoomMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['other']['OpenRoomRate'];?>"
                   style="bottom: <?php $officeReport['other']['OpenRoomRate'] == 0 ? $height = 0 : $height = $officeReport['other']['OpenRoomRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num"
                     data-after="%"><?=$officeReport['other']['OpenRoomRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">オープンルーム</p>
            </div>
          </li>
          <li>
            <div class="body">
              <span class="c-count bar_count start" data-option="color-blue"
                    data-num="<?=$officeReport['other']['FreeVisitActionCount'];?>"
                    style="height: <?php $officeReport['other']['FreeVisitActionCount'] == 0 ? $height = 0 : $height = $officeReport['other']['FreeVisitActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['other']['FreeVisitMediation'];?>"
                    style="height: <?php $officeReport['other']['FreeVisitMediation'] == 0 ? $height = 0 : $height = $officeReport['other']['FreeVisitMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['other']['FreeVisitRate'];?>"
                   style="bottom: <?php $officeReport['other']['FreeVisitRate'] == 0 ? $height = 0 : $height = $officeReport['other']['FreeVisitRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['other']['FreeVisitRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">フリー来社</p>
            </div>
          </li>
          <li>
            <div class="body">
             <span class="c-count bar_count start" data-option="color-blue"
                   data-num="<?=$officeReport['other']['OtherActionCount'];?>"
                   style="height: <?php $officeReport['other']['OtherActionCount'] == 0 ? $height = 0 : $height = $officeReport['other']['OtherActionCount'] / $max * 100; echo $height . '%'?>"></span>
              <span class="c-count bar_count start" data-option="color-pink"
                    data-num="<?=$officeReport['other']['OtherMediation'];?>"
                    style="height: <?php $officeReport['other']['OtherMediation'] == 0 ? $height = 0 : $height = $officeReport['other']['OtherMediation'] / $max * 100; echo $height . '%'?>"></span>
              <div class="c-percent" data-optin="color-pink"
                   data-num="<?=$officeReport['other']['OtherRate'];?>"
                   style="bottom: <?php $officeReport['other']['OtherRate'] == 0 ? $height = 0 : $height = $officeReport['other']['OtherRate']; echo $height . '%'?>">
                <div class="detail">
                  <p class="ttl">媒介率</p>
                  <p class="num" data-after="%"><?=$officeReport['other']['OtherRate'];?></p>
                </div>
              </div>
            </div>
            <div class="foot">
              <p class="ttl">その他</p>
            </div>
          </li>
        </ul>
      </div>
      <div class="l_fix" data-width="50" style="padding-top: 50px">
        <ul class="list_ticks" data-option="style-line cut-6 position-right">
          <li><p data-after="%">{{$officeReport['RateMax'] > 100 ? $officeReport['RateMax'] : 100}}</p></li>
          <li>
{{--            <p>{{$officeReport['RateMax'] == 0 ? '' : $officeReport['RateMax'] / 5 * 4}}%</p>--}}
          </li>
          <li>
{{--            <p>{{$officeReport['RateMax'] == 0 ? '' : $officeReport['RateMax'] / 5 * 3}}%</p>--}}
          </li>
          <li>
{{--            <p>{{$officeReport['RateMax'] == 0 ? '' : $officeReport['RateMax'] / 5 * 2}}%</p>--}}
          </li>
          <li>
{{--            <p>{{$officeReport['RateMax'] == 0 ? '' : $officeReport['RateMax'] / 5 * 1}}%</p>--}}
          </li>
          <li><p data-after="%">0</p></li>
        </ul>
      </div>
    </div>
  </div>
</div>