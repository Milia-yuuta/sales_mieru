import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['flyer']['rate'];
  const ctx = document.getElementById("company_flyer_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});