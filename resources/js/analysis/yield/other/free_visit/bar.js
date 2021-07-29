import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['other']['freeVisit']['bar'];
  const ctx = document.getElementById('other_free_visit_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});