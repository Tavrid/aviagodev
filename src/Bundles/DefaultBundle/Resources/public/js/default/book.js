$(document).ready(function(){
    $.mask.definitions["d"] = "[a-zA_Z0-9]";
    //CC DDDDDD ukraine
    $('.passport-mask').mask("99 99 999999");
    $('#order_phone').intlTelInput({
        'numberType' : 'MOBILE',
        'defaultCountry' : 'ua',
        'preferredCountries' :['ua','ru'],
        'utilsScript' : '/bundles/bundlesdefault/lib/intl-tel-input-master/lib/libphonenumber/build/utils.js'
    });
});