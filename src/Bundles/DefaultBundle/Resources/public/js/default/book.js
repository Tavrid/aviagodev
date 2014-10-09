$(document).ready(function(){
    $('#order_passengers_ADT_1_Document_Number').mask("99/99/9999");
    $.mask.definitions["d"] = "[0-9]";
    $('#order_phone').intlTelInput({
        'numberType' : 'MOBILE',
        'defaultCountry' : 'ua',
        'preferredCountries' :['ua','ru'],
        'utilsScript' : '/bundles/bundlesdefault/lib/intl-tel-input-master/lib/libphonenumber/build/utils.js'
    });
});