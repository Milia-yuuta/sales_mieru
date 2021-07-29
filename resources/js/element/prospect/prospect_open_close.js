$(function () {
  //open
  $(document).on('click', '.open_btn', function (){
    let id = $(this).attr('id');
    window.open(`/prospect/${id}`);
  });

  //close
  $('.close_tab').click(function (){
    window.close();
  });
});