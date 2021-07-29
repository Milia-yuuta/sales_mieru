import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['company']['buildingInformation']['bar'];
  const ctx = document.getElementById('company_building_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});