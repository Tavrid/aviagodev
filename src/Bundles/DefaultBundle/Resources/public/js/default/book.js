$(document).ready(function(){

    var masks = {
        'RU' : '99 99 999999',
        'UA' :'dd 999999'
    };
    $.mask.definitions["d"] = "[a-zA-Zа-яА-Я]";

    function createMask(){
        $('.citizen').each(function(){
            var val = $(this).val();
            var inputSelector = $(this).attr('mask-input');
            if(masks.hasOwnProperty(val)){
                $('.'+inputSelector).mask(masks[val])
            } else {
                $('.'+inputSelector).unmask();
            }
        })
    }
    $('body').on('change','.citizen',function(){
        createMask();
    });
    createMask();

    $('#order_phone').intlTelInput({
        'numberType' : 'MOBILE',
        'defaultCountry' : 'ua',
        'preferredCountries' :['ua','ru'],
        'utilsScript' : '/bundles/bundlesdefault/lib/intl-tel-input-master/lib/libphonenumber/build/utils.js'
    });
});