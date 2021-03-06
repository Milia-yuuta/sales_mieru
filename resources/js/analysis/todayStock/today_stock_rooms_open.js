const LOCAL_CACHE = new Map()

$(document).ready(function () {
  ajax(storeOptions('rooms'));
  $('.unit').click(function () {
  })

  $('.list_chart_stock .c-count').delay(700).queue(function (next) {
    $(this).removeClass('start');
    next();
  });

  $(document).on('click', '.c-count', function () {
    let This = $(this),
        tag = $('.p-stock_detail'),
        left = This.offset().left,
        right = $(window).width() - This.offset().left + 20,
        top = This.offset().top;
    $('.p-stock_detail').removeAttr('style');
    $('.p-stock_detail').removeClass('open');
    if (left > right) {
      tag.css('left', left + 'px');
      tag.css('transform', 'translate(-90%, 10px)');
    } else {
      tag.css('right', right + 'px');
      tag.css('transform', 'translate(110%, 10px)');
    }
    tag.css('top', top + 'px');
    tag.addClass('open');

    if (LOCAL_CACHE.get('rooms') != null) {
      $('.loader').removeClass('loader');
      roomExpand(This);
      return;
    }

    let timer = setInterval(() => {
      if (LOCAL_CACHE.get('rooms') != null) {
        $('.loader').removeClass('loader');
        roomExpand(This);
        clearInterval(timer)
      }
    }, 1000)

  });

  $(document).click(function (event) {
    if ($(event.target).closest('.c-count, .p-stock_detail').length) {
    } else {
      $('.p-stock_detail').removeClass('open');
    }

    if ($(event.target).closest('.c-count-none').length) {
      $('.p-stock_detail').removeClass('open');
    }
    ;
  });
});

function roomExpand(This) {
  const id = Number(This.attr('id'));
  const status = This.data('status');
  $('.list_room').empty();
  $.each(LOCAL_CACHE.get('rooms')[id][status], function (index, prospect) {
    $('.list_room').append(`
       <a href="/prospect/${prospect['id']}" target="_blank" id="${prospect['id']}" class="list_room_li">
       <p class="loader" style="width: 10px; height: 10px;"></p>
          <p class="ttl"></p>
          <p class="num"></p>
       </a>
    `)
  });
  $.each($('.list_room_li'), function (i, val) {
    const prospect_id = $(val).attr('id');
    propertyNameAjax(prospect_id);
  });
}

function ajax(callback) {
  const office_id = $('#select2_office_id').val();
  //ajax??????????????????
  $.ajax({
    url: `/analysis/todayStock/getRooms/${office_id}`, //?????????????????????????????????URL???????????????????????????????????????
    method: 'GET', //HTTP??????????????????????????????????????????1.9.0??????????????????type:????????????
    dataType: 'json'
  })
      //??????????????????????????????
      .done(callback)
      //??????????????????????????????
      .fail(function () {
        console.log('ajaxFalse');
      });
}

function storeOptions(key) {
  return function (value) {
    LOCAL_CACHE.set(key, value);
  }
}

function propertyNameAjax(prospect_id) {
  //ajax??????????????????
  $.ajax({
    url: `/analysis/todayStock/getRooms/show/${prospect_id}`,
    method: 'GET',
    dataType: 'json'
  })
      //??????????????????????????????
      .done(function (property) {
        const parent_class = $('.list_room').find(`#${property['id']}`)
        parent_class.find('.loader').remove();
        parent_class.find('.ttl').text(property['propertyName'])
        parent_class.find('.num').text(property['roomName'])
      })
      //??????????????????????????????
      .fail(function () {
        console.log('propertyNameAjaxFalse');
      });
}
