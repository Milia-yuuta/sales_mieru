$(function(){
    $('.multiple_wareki_target').each(function(i, elem) {
        const target_class = $(elem).text();
        const date = new Date(target_class);
        const options = {era: 'short', year: 'numeric', month: 'long'};
    
        const wareki = generateWareki(date, options);
        $(this).next().text(wareki);
    });     
});

function generateWareki(date, options){
    const warekiTemp = ' ' + '(' + new Intl.DateTimeFormat('ja-JP-u-ca-japanese', options).format(date) + ')';
    return warekiTemp;
}