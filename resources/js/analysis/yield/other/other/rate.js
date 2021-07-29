import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['other']['other']['rate'];
  const ctx = document.getElementById("other_other_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});