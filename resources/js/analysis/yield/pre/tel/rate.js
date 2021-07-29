import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['pre']['tel']['rate'];
  const ctx = document.getElementById("pre_tel_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});