import {config} from "../../one_rate";

$(document).ready(function (){
  const rateReport =  window.individualReport['re']['otherGroupCompany']['rate'];
  const ctx = document.getElementById("re_other_group_company_rate").getContext('2d');
  new Chart(ctx,  config(rateReport));
});