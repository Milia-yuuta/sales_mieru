import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['returnToMail']['rate'];
  const ctx = document.getElementById("company_return_to_email_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});