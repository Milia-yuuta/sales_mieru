import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['area']['flyer']['bar'];
  const ctx = document.getElementById('area_flyer_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});