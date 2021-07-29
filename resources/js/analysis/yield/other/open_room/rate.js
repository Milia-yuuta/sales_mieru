import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['other']['openRoom']['rate'];
  const ctx = document.getElementById("other_open_room_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});