$(document).ready(function (){
  $('.select2').select2(
      {
        language: {"noResults": function(){ return "該当がありません。";}},
        escapeMarkup: function (markup) { return markup; }
      }
  );
});