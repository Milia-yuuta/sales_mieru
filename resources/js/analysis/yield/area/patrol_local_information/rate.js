import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['area']['PatrolLocalInformation']['rate'];
  const ctx = document.getElementById("area_patrol_local_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});