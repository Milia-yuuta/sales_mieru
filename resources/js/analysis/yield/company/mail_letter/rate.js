import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['letter']['rate'];
  const ctx = document.getElementById("company_mail_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});