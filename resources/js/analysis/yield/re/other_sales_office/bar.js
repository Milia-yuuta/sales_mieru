import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['re']['otherSalesOffice']['bar'];
  const ctx = document.getElementById('re_other_sales_office_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});