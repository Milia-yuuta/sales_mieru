import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['building']['rate'];
  const ctx = document.getElementById("area_building_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});