$(document).ready(function () {
  $('.button_sort').on('click', function () {
    //ASC=1 DESC=2
    if ($(this).next().attr('class') == 'sort_value up'){
      $(this).next().val(2);
    }else{
      $(this).next().val(1);
    }
    $('.SortForm').submit();
  })
});