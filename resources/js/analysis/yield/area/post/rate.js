import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['post']['rate'];
  const ctx = document.getElementById("excavation_percent_post").getContext('2d');
  new Chart(ctx,  config(rateReport));
});