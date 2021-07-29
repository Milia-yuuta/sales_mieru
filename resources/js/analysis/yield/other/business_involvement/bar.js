import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['other']['businessInvolvement']['bar'];
  const ctx = document.getElementById('other_business_involvement_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});