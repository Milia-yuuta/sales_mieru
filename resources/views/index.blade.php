@extends('layouts.default')

@section('title', 'TOP')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="l" data-space="40">
      <div class="l_fix" data-width="260">
        <div class="box" data-box-option="space_min">
          <div class="head_box">
            <p class="ttl h4">営業活動</p>
          </div>
          <div class="body_box" style="width: 190px">
            <ul class="c-list_nav" data-option="style-sales">
              <li>
                <article>
                  <a href="{{ route('prospect') }}"></a>
                  <p>見込リスト</p>
                </article>
              </li>
              <li style="margin-top: 45px">
                <article>
                  <a href="{{ route('property') }}"></a>
                  <p class="mansion">顧客リスト</p>
                </article>
              </li>
              <li style="margin-top: 45px">
                <article>
                  <a href="{{ route('dailyReport') }}"></a>
                  <p class="report">日報</p>
                </article>
              </li>
            </ul>
          </div>
        </div>
      </div>
      @if(!empty($dailyReport))
        <div class="l_fix" data-width="240">
          <div class="head_box" style="margin-bottom: 20px">
            <p class="ttl h4">今日の予定</p>
          </div>
          <div class="area_schedule" style="width: 200px; height: 450px">
            <div id="calendar" style="height: 700px;"></div>
          </div>
        </div>
      @else
        <div class="l_fix" data-width="240">
          <div class="head_box" style="margin-bottom: 45px">
            <p class="ttl h4">今日の予定</p>
          </div>
          <div><p>予定が未登録のため<br>日報画面から作成して下さい。</p></div>
        </div>
      @endif
      @if(!empty($TodayStock))
        <div class="l_auto">
          <div class="box" data-box-option="space_min">
            <div class="head_box">
              <p class="ttl h4">今日のストック</p>
            </div>
            <div class="body_box display_scrollbar_hidden" style="display: flex; overflow: auto;">
              @forelse($TodayStock as $stock)
                <div class="c-stock"  style="width: 100%">
                  <div class="head_stock">
                    <p class="ttl">{{$stock['analysis']['OfficeName']}}営業所/{{$stock['analysis']['area_name']}}</p>
                    <p class="person">{{$stock['analysis']['sale_name']}} / {{$stock['analysis']['hat_name']}}</p>
                  </div>
                  @if($stock['analysis']['totalCount'] !== 0)
                    <div class="body_stock">
                      <div class="area_chart">
                        <div class="p-chart_stock">
                            <?php
                            $total = $stock['analysis']['totalCount'];
                            //特別TEL無しグラフの設定
                            if ($stock['analysis']['DiscriminationNoTELCount'] == 0) {
                                $graph_1 = 0;
                                $graph_height_1 = 0;
                            } else {
                                $graph_1 = $stock['analysis']['DiscriminationNoTELCount'];
                                $graph_height_1 = ($graph_1 / $total * 100);
                            }

                            //特別TEL有グラフの設定
                            if ($stock['analysis']['DiscriminationTELCount'] == 0) {
                                $graph_2 = 0;
                                $graph_height_2 = 0;
                                $graph_px_2 = (168 * $graph_1 / $total);
                            } else {
                                $graph_2 = $stock['analysis']['DiscriminationTELCount'];
                                $graph_height_2 = ($graph_2 / $total * 100);
                                $graph_px_2 = (168 * $graph_1 / $total);
                            }

                            //潜在短期
                            if ($stock['analysis']['ShortLatentCount'] == 0){
                                $graph_3 = 0;
                                $graph_height_3 =0;
                                $graph_px_3 = ((168 * $graph_2 / $total) + $graph_px_2);
                            }else{
                                $graph_3 = $stock['analysis']['ShortLatentCount'];
                                $graph_height_3 = ($graph_3 / $total * 100);
                                $graph_px_3 = ((168 * $graph_2 / $total) + $graph_px_2);
                            }

                            //顕在今期
                            if ($stock['analysis']['ActualThisOvertCount'] == 0){
                                $graph_4 = 0;
                                $graph_height_4 = 0;
                                $graph_px_4 = ((168 * $graph_3 / $total) + $graph_px_3);
                            }else{
                                $graph_4 = $stock['analysis']['ActualThisOvertCount'];
                                $graph_height_4 = ($graph_4 / $total * 100);
                                $graph_px_4 = ((168 * $graph_3 / $total) + $graph_px_3);
                            }

                            //顕在月内
                            if ($stock['analysis']['OvertMonthCount'] == 0){
                                $graph_5 = 0;
                                $graph_height_5 =0;
                                $graph_px_5 = ((168 * $graph_4 / $total) + $graph_px_4);
                            }else{
                                $graph_5 = $stock['analysis']['OvertMonthCount'];
                                $graph_height_5 = ($graph_5 / $total * 100);
                                $graph_px_5 = ((168 * $graph_4 / $total) + $graph_px_4);
                            }
                            ?>
                          <ul class="list_chart_stock" data-option="row_6" style='height: 230px'>
                            <li>
                              <div class="body">
                                <span class="c-count start" id="{{$stock['analysis']['id']}}" data-status="DiscriminationNoTELCount" data-option="discrimination" data-num="{{$stock['analysis']['DiscriminationNoTELCount']}}" style="height: <?=168 * $graph_height_1 / 100?>px"></span>
                              </div>
                              <div class="foot">
                                <p class="ttl">判別<br />TEL無</p>
                              </div>
                            </li>
                            <li>
                              <div class="body">
                                <span class="c-count start" id="{{$stock['analysis']['id']}}" data-status="DiscriminationTELCount" data-option="discrimination" data-num="{{$stock['analysis']['DiscriminationTELCount']}}" style="height: <?=168 * $graph_height_2 / 100?>px; transform: translate(0,<?='-'.$graph_px_2.'px';?>);"></span>
                              </div>
                              <div class="foot">
                                <p class="ttl">判別<br />TEL有</p>
                              </div>
                            </li>
                            <li>
                              <div class="body">
                                <span class="c-count start" id="{{$stock['analysis']['id']}}" data-status="ShortLatentCount" data-option="latent" data-num="{{$stock['analysis']['ShortLatentCount']}}" style="height: <?=168 * $graph_height_3 / 100?>px;transform: translate(0,<?='-'.$graph_px_3.'px';?>);"></span>
                              </div>
                              <div class="foot">
                                <p class="ttl">潜在<br />短期</p>
                              </div>
                            </li>
                            <li>
                              <div class="body">
                                <span class="c-count start" id="{{$stock['analysis']['id']}}" data-status="ActualThisOvertCount" data-option="overt" data-num="{{$stock['analysis']['ActualThisOvertCount']}}" style="height: <?=168 * $graph_height_4 / 100?>px; transform: translate(0,<?='-'.$graph_px_4.'px';?>);"></span>
                              </div>
                              <div class="foot">
                                <p class="ttl">顕在<br />今期</p>
                              </div>
                            </li>
                            <li>
                              <div class="body">
                                <span class="c-count start" id="{{$stock['analysis']['id']}}" data-status="OvertMonthCount" data-option="overt" data-num="{{$stock['analysis']['OvertMonthCount']}}" style="height: <?=168 * $graph_height_5 / 100?>px; transform: translate(0,<?='-'.$graph_px_5.'px';?>);"></span>
                              </div>
                              <div class="foot">
                                <p class="ttl">顕在<br />月内</p>
                              </div>
                            </li>
                            <li class="bigger">
                              <div class="body">
                                <span class="c-count start" data-option="total" data-num="{{$stock['analysis']['totalCount']}}" style="height: 168px !important;"></span>
                              </div>
                              <div class="foot">
                                <p class="ttl">合計</p>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="body_stock" style="height: 215px; text-align: center; margin-bottom: 30px">
                      <div class="area_chart">
                        <div class="p-chart_stock">
                          <p style="line-height: 140px">該当する見込データが未登録です。</p>
                        </div>
                      </div>
                    </div>
                  @endif
                  <div class="foot_stock" style="width: 450px">
                    <div class="l">
                      <div class="l_fix">
                        <ul class="c-list">
                          <li>
                            <div class="head">
                              <p class="ttl">判別手段無</p>
                            </div>
                            <div class="cnt">
                              <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="DiscriminationNoMeansCount" data-option="discrimination">{{$stock['analysis']['DiscriminationNoMeansCount']}}</span>
                            </div>
                          </li>
                          <li>
                            <div class="head">
                              <p class="ttl">潜在長期</p>
                            </div>
                            <div class="cnt">
                              <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="LongLatentCount" data-option="latent">{{$stock['analysis']['LongLatentCount']}}</span>
                            </div>
                          </li>
                          <li>
                            <div class="head">
                              <p class="ttl">潜在MA</p>
                            </div>
                            <div class="cnt">
                              <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="ActualThisLatentCount" data-option="latent">{{$stock['analysis']['ActualThisLatentCount']}}</span>
                            </div>
                          </li>
                          <li>
                            <div class="head">
                              <p class="ttl">顕在来期</p>
                            </div>
                            <div class="cnt">
                              <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="OvertNextSeasonCount" data-option="overt">{{$stock['analysis']['OvertNextSeasonCount']}}</span>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="l_auto" data-option="line-left">
                        <div class="l" data-space="20">
                          <div class="l_fix" data-flex="align-center">
                            <p class="ttl">今月</p>
                          </div>
                          <div class="l_auto">
                            <ul class="list_count" data-optoin="style-double">
                              <li>
                                <div class="head">
                                  <p class="ttl">専任</p>
                                </div>
                                <div class="cnt">
                                  <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="FullServiceCount" data-option="style-square mediation">{{$stock['analysis']['FullServiceCount']}}</span>
                                </div>
                              </li>
                              <li>
                                <div class="head">
                                  <p class="ttl">売主</p>
                                </div>
                                <div class="cnt">
                                  <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="sellerCount" data-option="style-square mediation">{{$stock['analysis']['sellerCount']}}</span>
                                </div>
                              </li>
                              <li>
                                <div class="head">
                                  <p class="ttl">一般</p>
                                </div>
                                <div class="cnt">
                                  <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="panpyCount" data-option="style-square mediation">{{$stock['analysis']['panpyCount']}}</span>
                                </div>
                              </li>
                              <li>
                                <div class="head">
                                  <p class="ttl">専属</p>
                                </div>
                                <div class="cnt">
                                  <span class="c-count" id="{{$stock['analysis']['id']}}" data-status="exclusiveCount" data-option="style-square mediation">{{$stock['analysis']['exclusiveCount']}}</span>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @if($loop->count !== 1)
                  @if($loop->last)
                    <div class="top_graph_scroll" style=" height: 450px;text-align: center; margin: 0 15px;padding-top: 215px; cursor: pointer"><img style="height: 20px; max-width: 15px" src="{{asset("img/ico/return_arrow.png")}}"></div>
                  @else
                    <div class="top_graph_scroll" data-position="{{$loop->last ? 0 :$loop->iteration}}" style=" height: 450px;text-align: center; margin: 0 10px"><a class="arrow_s"  style="height: 100%; color:#3B96DD"></a></div>
                  @endif
                @endif
              @empty
              @endforelse
            </div>
          </div>
        </div>
        <script>
          $(document).ready(function (){
            $('.top_graph_scroll').click(function() {
              const count = $(this).data('position') * 483;
              $('.body_box').animate({
                scrollLeft: count
              }, 300, 'swing');
            });
          });
        </script>
      @else
        <div class="l_fix" data-width="300">
          <div class="head_box">
            <p class="ttl h4">今日のストック(調整中)</p>
          </div>
          <div><p></p></div>
        </div>
      @endif
    </div>
    <div class="l" style="margin-top: 15px">
      <div class="l_auto">
        <div class="box" data-box-option="space_min">
          <div class="head_box">
            <p class="ttl h4">分析一覧</p>
          </div>
          <div class="body_box">
            @include('element.footer_analysis_index')
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ! 該当顧客 ============================== -->
  <div class="p-stock_detail">
    <div class="head"><p class="ttl">該当顧客</p></div>
    <div class="body">
      <ul class="list_room">
      </ul>
    </div>
  </div>

  <!-- ! ストックグラフ ============================== -->
  <script>
    let baseData = [
      { label: '判別TEL無', value: 20 },
      { label: '判別TEL有', value: 5 },
      { label: '潜在短期', value: 5 },
      { label: '顕在今期', value: 12 },
      { label: '顕在月内', value: 18 }
    ];

    const labels = baseData.map(o => o.label).concat('合計');
    const data = [];
    let total = 0;
    for (let i = 0; i < baseData.length; i++) {
      const vStart = total;
      total += baseData[i].value;
      data.push([vStart, total]);
    }
    data.push(total);
    const backgroundColors = data.map((o, i) => 'rgba(255, 99, 132, ' + (i + (11 - data.length)) * 0.1 + ')');

    new Chart('waterfall', {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: [
            '#3B96DD',
            '#3B96DD',
            '#F2D073',
            '#F1A372',
            '#F1A372',
            '#9BA7B1'
          ],
          barPercentage: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        tooltips: {
          callbacks: {
            label: (tooltipItem, data) => {
              const v = data.datasets[0].data[tooltipItem.index];
              return Array.isArray(v) ? v[1] - v[0] : v;
            }
          }
        },
        scales: {
          xAxes: [{
            display: true,
            stacked: false,
            gridLines: {
              display: false
            },
            ticks: {
              callback: function(val){
                if(val.length > 2){
                  return [val.substr(0, 2), val.substr(2)]
                }else{
                  return val;
                }
              },
              fontColor: "#5E6B76",
              fontStyle: "bold",
            },
            barPercentage: 0.7,
          }],
          yAxes: [{
            stacked: false,
            ticks: {
              maxTicksLimit: 1,
              display: false
            },
            gridLines: {
              drawBorder: false,
            },
          }]
        },
        plugins: {
          datalabels: { // 共通の設定はここ
            font: {
              size: 14,
              weight: 'bold',
              family: 'Work Sans'
            },
            color: [
              '#042F52',
              '#042F52',
              '#7E6521',
              '#893500',
              '#893500',
              '#485865'
            ],
            formatter: function(value, context) {
              return context.chart.data.label;
            }
          }
        }
      }
    });
    $('.list_chart_stock .c-count').delay(700).queue(function(next){
      $(this).removeClass('start');
      next();
    });
  </script>
  @if(!empty($dailyReport))
    @include('element._report_plan_add')
    <script>
      const PlanTimeList = @json($PlanTimeList);
    </script>
    <script src="{{ asset('js/home/index.js') }}" defer></script>
  @endif
@endsection
