import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['flyer']['rate'];
  const ctx = document.getElementById("area_flyer_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});