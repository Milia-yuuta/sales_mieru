import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['letter']['rate'];
  const ctx = document.getElementById("area_letter_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});