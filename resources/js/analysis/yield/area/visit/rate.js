import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['visit']['rate'];
  const ctx = document.getElementById("excavation_percent_visit").getContext('2d');
  new Chart(ctx,  config(rateReport));
});