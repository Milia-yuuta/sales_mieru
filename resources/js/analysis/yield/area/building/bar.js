import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['area']['building']['bar'];
  const ctx = document.getElementById('area_building_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});
