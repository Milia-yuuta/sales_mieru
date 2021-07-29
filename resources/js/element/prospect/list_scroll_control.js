$(function () {
    $('#scroll_head_box').scroll(function() {
    $('#scroll_body_box').scrollLeft($(this).scrollLeft());
  });
    $('#scroll_body_box').scroll(function() {
    $('#scroll_head_box').scrollLeft($(this).scrollLeft());
  });
});