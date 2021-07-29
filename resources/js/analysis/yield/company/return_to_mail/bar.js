import {config} from "../../bar_chart";

$(document).ready(function () {
  const barReport = window.individualReport['company']['returnToMail']['bar'];
  const ctx = document.getElementById('company_return_to_email_bar').getContext("2d");
  ctx.canvas.width = 1000;
  new Chart(ctx, config(barReport));
});