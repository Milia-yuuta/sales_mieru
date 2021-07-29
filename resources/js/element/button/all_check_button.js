function allCheck(e) {
  const parent = document.getElementById('all_check')
  const checks = document.querySelectorAll('input[type=checkbox][name^=room]')
  checks.forEach(check => check.checked = parent.checked)
}


document.addEventListener('DOMContentLoaded', () => {
  document.querySelector('input#all_check').addEventListener('change', e => {
    const checks = document.querySelectorAll('input[type=checkbox][name^=room]')
    checks.forEach(check => check.checked = e.target.checked)
  })
})