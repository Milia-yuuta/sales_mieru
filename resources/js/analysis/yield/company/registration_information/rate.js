import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['registerInformation']['rate'];
  const ctx = document.getElementById("company_registration_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});