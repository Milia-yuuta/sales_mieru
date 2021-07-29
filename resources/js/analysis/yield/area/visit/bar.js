import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['area']['visit']['bar'];
  const ctx = document.getElementById('excavation_number_visit').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});