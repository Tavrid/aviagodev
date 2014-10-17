$(document).ready(function () {

    var masks = {
        'RU': '99 99 999999',
        'UA': 'dd 999999'
    };
    $.mask.definitions["d"] = "[a-zA-Zа-яА-Я]";
    $.validator.setDefaults({
        ignore: []
                // any other default options and/or rules
    });
    $.validator.addMethod("date_range", function (value, element) {
        var val = moment(value, "DD.MM.YYYY");
        var minDate = $(element).attr('mindate');
        var maxDate =  $(element).attr('maxdate');
        if(minDate !== undefined && maxDate !== undefined){
            minDate = moment(minDate, "DD.MM.YYYY");
            maxDate = moment(maxDate, "DD.MM.YYYY");
            return val.isAfter(minDate) && val.isBefore(maxDate);
        } else if(minDate !== undefined){
            minDate = moment(minDate, "DD.MM.YYYY");
            return val.isAfter(minDate);
        } else if (maxDate !== undefined){
            maxDate = moment(maxDate, "DD.MM.YYYY");
            return val.isBefore(maxDate);
        } 
    }, "Please don't insert numbers.");

    $.validator.addClassRules({
        'date-validator': {
            date_range: true
        }
    });
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