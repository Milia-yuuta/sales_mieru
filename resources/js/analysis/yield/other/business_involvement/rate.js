import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['other']['businessInvolvement']['rate'];
  const ctx = document.getElementById("other_business_involvement_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});