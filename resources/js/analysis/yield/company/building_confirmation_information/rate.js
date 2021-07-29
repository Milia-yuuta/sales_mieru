import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['buildingInformation']['rate'];
  const ctx = document.getElementById("company_building_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});