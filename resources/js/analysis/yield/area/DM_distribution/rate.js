import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['DM']['rate'];
  const ctx = document.getElementById("area_DM_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});