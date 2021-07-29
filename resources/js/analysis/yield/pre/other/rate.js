import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['pre']['other']['rate'];
  const ctx = document.getElementById("pre_other_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});