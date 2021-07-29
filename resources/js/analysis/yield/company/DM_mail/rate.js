import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['DM']['rate'];
  const ctx = document.getElementById("company_DM_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});