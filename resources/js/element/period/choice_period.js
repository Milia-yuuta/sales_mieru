$('.js-drop-choice-period').on('click', function(){
    $('.analysis_display_modal').toggleClass('open');
})

$('#analysis_last_year').on('click', function() {
    $('#last_year_elem').css('opacity', '1');
    $('#old_elem').css('opacity', '.3');
    $('#all_elem').css('opacity', '.3');
    const startPeriod = $(this).data('start');
    const endPeriod = $(this).data('end');
    $('#start_period').val(startPeriod);
    $('#end_period').val(endPeriod);
})
$('#analysis_old').on('click', function() {
    $('#old_elem').css('opacity', '1');
    $('#last_year_elem').css('opacity', '.3');
    $('#all_elem').css('opacity', '.3');
    const startPeriod = $(this).data('start');
    const endPeriod = $(this).data('end');
    $('#start_period').val(startPeriod);
    $('#end_period').val(endPeriod);
})
$('#analysis_all').on('click', function() {
    $('#all_elem').css('opacity', '1');
    $('#old_elem').css('opacity', '.3');
    $('#last_year_elem').css('opacity', '.3');
    const startPeriod = $(this).data('start');
    const endPeriod = $(this).data('end');
    $('#start_period').val(startPeriod);
    $('#end_period').val(endPeriod);
})

