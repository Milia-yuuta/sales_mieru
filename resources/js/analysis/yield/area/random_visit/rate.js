import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['randomVisit']['rate'];
  const ctx = document.getElementById("area_random_visit_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});