import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['company']['rentalInformation']['rate'];
  const ctx = document.getElementById("company_rental_information_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});