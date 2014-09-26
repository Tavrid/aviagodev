$(function() {

    $( "#search-form" ).sisyphus({timeout: 5});
    $('#search-form').on('submit',function(){
        var routeParams = {};
        $.each($(this).serializeArray(),function(k,v){
            var name  = v.name.replace(/.*\[(.+)\].*/g,"$1");
            if(name != "city_from" && name != "city_to" && v.value){
                routeParams[name] = v.value;
            }
        });

        window.location = Routing.generate('bundles_default_api_list',routeParams);
        return false;
    });
    if(!parseInt($('#SearchForm_return_way input[type=radio]:checked').val())){
        $('#SearchForm_date_to').parents('.form-group ').hide();
        //$('#SearchForm_date_to').val('');
    }
    $('#SearchForm_return_way').on('click','input[type=radio]',function(){
        var val = $('#SearchForm_return_way input[type=radio]:checked').val();
        var sel = $('#SearchForm_date_to').parents('.form-group ');
        if(!parseInt(val)){
            sel.hide();
            $('#SearchForm_date_to').val('');
        } else {
            sel.show();
        }
    });
    $( "#SearchForm_date_from" ).datetimepicker({
        language: 'ru',
        'format' :'YY-MM-D'
    });
    $('#SearchForm_date_to').datetimepicker({
        language: 'ru',
        'format' :'YY-MM-D'
    });

    $("#SearchForm_date_from").on("dp.change",function (e) {
        //$(this).date('hide');
        $('#SearchForm_date_to').data("DateTimePicker").setMinDate(e.date);
    });
    $("#SearchForm_date_to").on("dp.change",function (e) {
        $('#SearchForm_date_from').data("DateTimePicker").setMaxDate(e.date);
    });
    //$( "#SearchForm_date_from" ).datetimepicker({
    //    lang: "ru",
    //    timepicker: false,
    //    format: 'Y-m-d',
    //    closeOnDateSelect: true,
    //    minDate: new Date(),
    //    onSelectDate: function(){
    //        setTimeout(function () {
    //
    //            if($('#SearchForm_date_from').val().length){
    //                $("#SearchForm_date_to").val('');
    //                $("#SearchForm_date_to").datetimepicker('show');
    //            }
    //        },100);
    //    }
    //});
    //$( "#SearchForm_date_to" ).datetimepicker({
    //    lang: "ru",
    //    timepicker: false,
    //    format: 'Y-m-d',
    //    closeOnDateSelect: true,
    //    onShow:function( ct ){
    //        var from_date = $('#SearchForm_date_from').val();
    //        this.setOptions({
    //            minDate: from_date,
    //            startDate: from_date
    //        });
    //    }
    //});

    function autocomplete(input,hiddenInput){
        input.autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: _GlobalAppObject.searchUrl,
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {
                        var arr = [];
                        $.each(data, function(key, val) {
                            arr.push({
                                value: val.name,
                                'data-value': val.id
                            });
                        });

                        response(arr.slice(0, 10));
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                hiddenInput.val(ui.item['data-value'])
            }
        });
    }
    autocomplete($( "#SearchForm_city_from" ),$( "#SearchForm_city_from_code"));
    autocomplete($( "#SearchForm_city_to" ),$( "#SearchForm_city_to_code"));

});