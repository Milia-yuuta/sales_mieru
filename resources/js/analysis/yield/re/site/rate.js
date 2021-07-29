import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['re']['site']['rate'];
  const ctx = document.getElementById("re_site_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});