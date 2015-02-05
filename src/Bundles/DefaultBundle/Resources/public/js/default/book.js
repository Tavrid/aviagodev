$(document).ready(function () {


    var masks = VALID_MASCS;
    
    $.mask.definitions["d"] = "[a-zA-Zа-яА-Я]";
    
    function createMask() {
        $('.citizen').each(function () {
            var val = $(this).val();
            var inputSelector = $(this).attr('mask-input');
            if (masks.hasOwnProperty(val)) {
                $('.' + inputSelector).mask(masks[val]);
            } else {
                $('.' + inputSelector).unmask();
            }
        });
    }
    createMask();
    $('.birthday').mask('99.99.9999');
    $('body').on('change', '.citizen', function () {
        createMask();
    });
    var validDate = moment.unix(VALID_DATE);

    $('body').on('change', '.birthday', function () {
        if ($(this).hasClass('child')) {
            validateChild($(this));
        }
    });
    function validateChild(input) {
        var val = moment(input.val(), "DD.MM.YYYY");
        
        var vd = validDate.clone();
        vd.year(vd.year() - 12);

        if (val.isBefore(vd)) {
            input.parent('div').addClass('has-warning');
        } else {
            input.parent('div').removeClass('has-warning');

        }
    }

    $(function () {
        $("#order-form").validate({
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });

    $('#order_phone').intlTelInput({
        'numberType': 'MOBILE',
        'defaultCountry': 'ua',
        'preferredCountries': ['ua', 'ru'],
        'utilsScript': '/bundles/bundlesdefault/lib/intl-tel-input-master/lib/libphonenumber/build/utils.js'
    });
});