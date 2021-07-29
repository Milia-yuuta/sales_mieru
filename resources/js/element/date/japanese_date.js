$(function(){
    const target_class = $('.wareki_target').text()
    const date = new Date(target_class);
    const options = {era: 'short', year: 'numeric', month: 'long'};

    const wareki = generateWareki(date, options);
    $('.wareki_insert').text(wareki);
});

function generateWareki(date, options){
    const warekiTemp = ' ' + '(' + new Intl.DateTimeFormat('ja-JP-u-ca-japanese', options).format(date) + ')';
    return warekiTemp;
}