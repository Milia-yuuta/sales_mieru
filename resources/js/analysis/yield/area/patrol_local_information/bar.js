import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['area']['PatrolLocalInformation']['bar'];
  const ctx = document.getElementById('area_patrol_local_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});