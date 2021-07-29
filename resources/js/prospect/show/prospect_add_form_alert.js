$(function () {
  $('#prospect_action_log_submit').click(function(){
    return false;
  });

  $('#prospect_action_log_submit').click(function(){
    if ($('#ProspectActionLogStatus').val() === null){
      alert('ステータスが未入力です。');
      return false;
    }
    if (!$('#prospect_action_log_datepicker').datepicker('getDate')){
      alert('追客行動の日付が未入力です。');
      return false;
    }
    // if($('#prospect_action_log_datepicker').datepicker('getDate')){
    // if (
    //   document.getElementById('TEL_home').checked ||
    //       document.getElementById('send_letter').checked ||
    //       document.getElementById('local_letter').checked ||
    //       document.getElementById('visit').checked ||
    //       document.getElementById('email').checked ||
    //       document.getElementById('pursuit_other').checked ||
    //       document.getElementById('send_assessment_report').checked ||
    //       document.getElementById('assessment_report_email').checked ||
    //       document.getElementById('web_negotiation').checked ||
    //       document.getElementById('assessment_negotiation').checked ||
    //       document.getElementById('re-negotiation').checked ||
    //       document.getElementById('visit_caretaker').checked ||
    //       document.getElementById('TEL_caretaker').checked ||
    //       document.getElementById('on-site_check').checked ||
    //       document.getElementById('research_other').checked ||
    //       document.getElementById('re_TEL').checked ||
    //       document.getElementById('re_email').checked ||
    //       document.getElementById('re_letter').checked ||
    //       document.getElementById('re_hp').checked ||
    //       document.getElementById('re_site').checked ||
    //       document.getElementById('re_other').checked
    // ){}else {
    //   alert('アクションが未入力です。');
    //   return false;
    // }}
    const next_action_date = $('#next_prospect_datepicker').datepicker('getDate');
    const form = $('#ProspectActionLogEditForm');
    if (next_action_date){
      if(
          document.getElementById('next_TEL_home').checked ||
          document.getElementById('next_send_letter').checked ||
          document.getElementById('next_local_letter').checked ||
          document.getElementById('next_email').checked ||
          document.getElementById('next_visit').checked ||
          document.getElementById('next_pursuit_other').checked ||
          document.getElementById('next_send_assessment_report').checked ||
          document.getElementById('next_assessment_report_email').checked ||
          document.getElementById('next_web_negotiation').checked ||
          document.getElementById('next_assessment_negotiation').checked ||
          document.getElementById('next_re-negotiation').checked ||
          document.getElementById('next_visit_caretaker').checked ||
          document.getElementById('next_TEL_caretaker').checked ||
          document.getElementById('next_on-site_check').checked ||
          document.getElementById('next_research_other').checked
      ){
        form.submit();
      }else {
        alert('次回アクションが未入力です。');
      }
    }else if(
        document.getElementById('next_TEL_home').checked ||
        document.getElementById('next_send_letter').checked ||
        document.getElementById('next_local_letter').checked ||
        document.getElementById('next_email').checked ||
        document.getElementById('next_visit').checked ||
        document.getElementById('next_pursuit_other').checked ||
        document.getElementById('next_send_assessment_report').checked ||
        document.getElementById('next_assessment_report_email').checked ||
        document.getElementById('next_web_negotiation').checked ||
        document.getElementById('next_assessment_negotiation').checked ||
        document.getElementById('next_re-negotiation').checked ||
        document.getElementById('next_visit_caretaker').checked ||
        document.getElementById('next_TEL_caretaker').checked ||
        document.getElementById('next_on-site_check').checked ||
        document.getElementById('next_research_other').checked
    )
    {
      if (next_action_date == null){
        alert('次回アクション日付が未入力です。');
      }
    }
    else {
      confirmCheck(form);
    }
  });

  $('#next_action_clear').click(function (){
    $('#next_prospect_datepicker').datepicker("setDate", null);
    $('#next_TEL_home').prop('checked', false);
    $('#next_send_letter').prop('checked', false);
    $('#next_local_letter').prop('checked', false);
    $('#next_email').prop('checked', false);
    $('#next_visit').prop('checked', false);
    $('#next_pursuit_other').prop('checked', false);
    $('#next_send_assessment_report').prop('checked', false);
    $('#next_assessment_report_email').prop('checked', false);
    $('#next_web_negotiation').prop('checked', false);
    $('#next_assessment_negotiation').prop('checked', false);
    $('#next_re-negotiation').prop('checked', false);
    $('#next_visit_caretaker').prop('checked', false);
    $('#next_TEL_caretaker').prop('checked', false);
    $('#next_on-site_check').prop('checked', false);
    $('#next_research_other').prop('checked', false);
    $('#next_re_TEL').prop('checked', false);
    $('#next_re_email').prop('checked', false);
    $('#next_re_letter').prop('checked', false);
    $('#next_re_hp').prop('checked', false);
    $('#next_re_site').prop('checked', false);
    $('#next_re_other').prop('checked', false);
    return false;
  })
});

function confirmCheck(form){
  const confirmResult = window.confirm('次回アクションが入力されていません。このまま登録しますか？');
  if (confirmResult){
    form.submit();
  }
}