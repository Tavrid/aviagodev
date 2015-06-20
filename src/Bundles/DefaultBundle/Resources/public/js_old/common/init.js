var $ = jQuery = require('./../lib/jquery/dist/jquery.min');
require('./../lib/jquery-ui/jquery-ui.min');
require('./../lib/jquery-validation/dist/jquery.validate.min');

$(function () {
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
            'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.regional['ua'] = {clearText: 'Очистити', clearStatus: '',
        closeText: 'Закрити', closeStatus: '',
        prevText: '&lt;&lt;', prevStatus: '',
        nextText: '&gt;&gt;', nextStatus: '',
        currentText: 'Сьогодні', currentStatus: '',
        monthNames: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень',
            'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
        monthNamesShort: ['Січ', 'Лют', 'Бер', 'Кві', 'Тра', 'Чер',
            'Лип', 'Сер', 'Вер', 'Жов', 'Лис', 'Гру'],
        monthStatus: '', yearStatus: '',
        weekHeader: 'Не', weekStatus: '',
        dayNames: ['неділя', 'понеділок', 'вівторок', 'середа', 'четвер', 'пятниця', 'суббота'],
        dayNamesShort: ['нед', 'пнд', 'вів', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        dayStatus: 'DD', dateStatus: 'D, M d',
        dateFormat: 'dd.mm.yy', firstDay: 1,
        initStatus: '', isRTL: false
    };

    $('body').on('click', '.lang', function () {
        $.post(Routing.generate('bundles_default_change_locale', {
            '_locale': $(this).attr('data-value')
        }), function () {
            window.location.reload();
        });
    });

    $.validator.setDefaults({
        ignore: []
    });
    $.validator.addMethod("date_range", function (value, element) {
        var dateFormat = $(element).attr('date-format');
        if(dateFormat === undefined){
            dateFormat = 'DD.MM.YYYY';
        }
        var val = moment(value, dateFormat);
        if(!val.isValid()){
            return false;
        }
        var minDate = $(element).attr('mindate');
        var maxDate =  $(element).attr('maxdate');
        if(minDate !== undefined && maxDate !== undefined){
            minDate = moment(minDate, dateFormat);
            maxDate = moment(maxDate, dateFormat);
            return val.isAfter(minDate) && val.isBefore(maxDate);
        } else if(minDate !== undefined){
            minDate = moment(minDate, dateFormat);
            return val.isAfter(minDate);
        } else if (maxDate !== undefined){
            maxDate = moment(maxDate, dateFormat);
            return val.isBefore(maxDate);
        }
    },'Error date');

    $.validator.addClassRules({
        'date-validator': {
            date_range: true
        }
    });
});