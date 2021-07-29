import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['re']['hp']['bar'];
  const ctx = document.getElementById('re_hp_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});