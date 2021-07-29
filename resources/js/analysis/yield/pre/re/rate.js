import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['pre']['re']['rate'];
  const ctx = document.getElementById("pre_re_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});