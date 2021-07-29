$(document).ready(function () {
  $('.assessment_check').click(function (e){
    e.stopPropagation();
    const thisBtn = $(this).parents('.prospect_list').find('.ProspectActionLogBtn');
    $('.property_room_modal').empty();
    $('.property_room_modal').append(
        $(`
        <p class="ttl" style="margin-top: 10px">商談</p>
        <ul class="list_room" style="overflow: hidden;">
          <li><a class="num assessment_negotiation" target="_blank" style="width: 120px">査定・商談</a></li>
        </ul>
        `)
    )
    $('.assessment_negotiation').click(function (){
      thisBtn.trigger('click');
      $('#assessment_negotiation').prop('checked', true)
    })
  });

  $('.reaction_check').click(function (e){
    e.stopPropagation();
    const thisBtn = $(this).parents('.prospect_list').find('.ProspectActionLogBtn');
    $('.property_room_modal').empty();
    $('.property_room_modal').append(
        $(`
        <p class="ttl" style="margin-top: 10px">追客</p>
        <ul class="list_room" style="overflow: hidden;">
          <li><a class="num Tel" target="_blank" style="width: 120px">見込TEL</a></li>
          <li><a class="num visit" target="_blank" style="width: 120px">戸別訪問在宅</a></li>
        </ul>
        <p class="ttl" style="margin-top: 10px">お客様より</p>
        <ul class="list_room" style="overflow: hidden; max-height: 200px">
          <li><a class="num reTel" target="_blank" style="width: 120px">TEL</a></li>
          <li><a class="num reMail" target="_blank" style="width: 120px">メール</a></li>
          <li><a class="num reLetter" target="_blank" style="width: 120px">手紙・FAX</a></li>
          <li><a class="num reHp" target="_blank" style="width: 120px">当社HP反響</a></li>
          <li><a class="num reSite" target="_blank" style="width: 120px"> 査定サイト </a></li>
          <li><a class="num reOther" target="_blank" style="width: 120px"> その他 </a></li>
        </ul>
        `)
    )

    $('.Tel').click(function (){
      thisBtn.trigger('click');
      $('#TEL_home').prop('checked', true)
    })

    $('.visit').click(function (){
      thisBtn.trigger('click');
      $('#visit').prop('checked', true)
    })

    $('.reTel').click(function (){
      thisBtn.trigger('click');
      $('#re_TEL').prop('checked', true)
    })

    $('.reMail').click(function (){
      thisBtn.trigger('click');
      $('#re_email').prop('checked', true)
    })

    $('.reLetter').click(function (){
      thisBtn.trigger('click');
      $('#re_letter').prop('checked', true)
    })

    $('.reHp').click(function (){
      thisBtn.trigger('click');
      $('#re_hp').prop('checked', true)
    })

    $('.reSite').click(function (){
      thisBtn.trigger('click');
      $('#re_site').prop('checked', true)
    })

    $('.reOther').click(function (){
      thisBtn.trigger('click');
      $('#re_other').prop('checked', true)
    })
  });
})