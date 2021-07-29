import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['re']['hp']['rate'];
  const ctx = document.getElementById("re_hp_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});