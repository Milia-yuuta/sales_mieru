import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['re']['otherSalesOffice']['rate'];
  const ctx = document.getElementById("re_other_sales_office_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});