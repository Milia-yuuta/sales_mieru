$('.js-week-sub-button').on('click', function(e) {
  e.preventDefault();
  const def = $(this).data('date');
  const office = $('#office_select').val();
  $.ajax({
    url: `/dailyReport`,
    method: 'GET',
    data: {
      'weekType' : 'sub',
      'setDate': def,
      'office': office
    },
    dataType: 'html',
  })
      //通信成功した時の処理
      .done(function(data) {
        var bodyInnerHTML = $('body', $(data)).html();
        $('body').html('');
        $('body').html(data);
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('false');
      });
})

$('.js-week-add-button').on('click', function(e) {
  e.preventDefault();
  const def = $(this).data('date');
  const office = $('#office_select').val();
  $.ajax({
    url: `/dailyReport`,
    method: 'GET',
    data: {
      'weekType':'add',
      'setDate': def,
      'office': office
    },
    dataType: 'html',
  })
      //通信成功した時の処理
      .done(function(data) {
        var bodyInnerHTML = $('body', $(data)).html();
        $('body').html('');
        $('body').html(data);
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('false');
      });
})