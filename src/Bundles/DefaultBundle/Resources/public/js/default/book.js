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
        });
    }
    createMask();
    $('.birthday').mask('99.99.9999');
    $('body').on('change','.citizen',function(){
        createMask();
    });
    var validDate = moment.unix(VALID_DATE);
    
    $('body').on('change','.birthday',function(){
        if($(this).hasClass('child')){
            validateChild($(this));
        }
    });
    function validateChild(input){
        var maxBirthday = moment();
        maxBirthday.year(maxBirthday.year() -12);
        var minBirhtday = moment();
        minBirhtday.year(minBirhtday.year() -2);
        console.log(minBirhtday.format('DD.MM.YYYY'));
        var val = moment(input.val(), "DD.MM.YYYY");
        console.log(val.isBefore(minBirhtday));
        if(val.isBefore(minBirhtday) && val.isAfter(maxBirthday)){
            input.parent('div').removeClass('has-error');
        } else {
            input.parent('div').addClass('has-error');
            return;
        }
        var vd = validDate.clone();
        vd.year(vd.year() - 12);
        
        if(val.isBefore(vd)){
            input.parent('div').addClass('has-warning');
        } else {
            input.parent('div').removeClass('has-warning');
            
        }
        
        
    }

    $('#order_phone').intlTelInput({
        'numberType' : 'MOBILE',
        'defaultCountry' : 'ua',
        'preferredCountries' :['ua','ru'],
        'utilsScript' : '/bundles/bundlesdefault/lib/intl-tel-input-master/lib/libphonenumber/build/utils.js'
    });
});