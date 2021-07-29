import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['other']['freeVisit']['rate'];
  const ctx = document.getElementById("other_free_visit_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});