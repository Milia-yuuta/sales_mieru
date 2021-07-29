import {config} from "../../rate_chart";

$(document).ready(function (){
  const rateReport =  window.individualReport['pre']['selfDiscovery']['rate'];
  const ctx = document.getElementById("pre_self_discovery_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});