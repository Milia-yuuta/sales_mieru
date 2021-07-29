import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['pre']['tel']['bar'];
  const ctx = document.getElementById('pre_tel_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});