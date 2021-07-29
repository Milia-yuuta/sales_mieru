import{config} from "../../bar_chart";

$(document).ready(function (){
  const barReport = window.individualReport['area']['post']['bar'];
  const ctx = document.getElementById('excavation_number_post').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});