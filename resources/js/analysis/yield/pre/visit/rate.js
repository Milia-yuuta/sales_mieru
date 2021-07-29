import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['pre']['visit']['rate'];
  const ctx = document.getElementById("pre_visit_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});