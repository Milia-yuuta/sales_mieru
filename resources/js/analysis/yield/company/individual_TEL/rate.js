import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['individualTEL']['rate'];
  const ctx = document.getElementById("company_individual_tel_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});