import '../../element/period/select_validation'
import '../../element/aleart/report_information'
import './area/area'
import {lazy_load_script} from "../../element/load/lazy_load_script";

$(document).ready(function (){
  lazy_load_script('/js/company.js');
  lazy_load_script('/js/other.js');
  lazy_load_script('/js/pre.js');
  lazy_load_script('/js/re.js');

  // <!-- ! 歩留まり集計 ============================== -->
  // <!-- 媒介率表示 -->
  $('.list_chart_yield .c-percent').hover(function() {
    let Tag = $('.detail',this);
    Tag.addClass('open');
  }, function() {
    $('.list_chart_yield .c-percent .detail').removeClass('open');
  });

  $('.list_chart_yield .c-count').delay(700).queue(function(next){
    $(this).removeClass('start');
    next();
  });
});