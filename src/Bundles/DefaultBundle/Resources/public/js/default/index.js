$(function() {
    alert(1);
    //$( "#search-form" ).sisyphus({timeout: 2});
    $('#search-form').on('submit',function(){
        var routeParams = {};
        $.each($(this).serializeArray(),function(k,v){
            var name  = v.name.replace(/.*\[(.+)\].*/g,"$1");
            if(name != "city_from" && name != "city_to" && v.value){
                routeParams[name] = v.value;
            }
        });
        if(routeParams['best_price'] === undefined){
            routeParams['best_price'] = 0;
        }
        window.location = Routing.generate('bundles_default_api_list',routeParams);
        return false;
    });

    $('body').on('click','.calendar-item',function(){
        _GlobalAppObject.loadingStart();
        $.get($(this).attr('href'),{},function(data){
            _GlobalAppObject.loadingStop();
            $('#calendar-popup').html(data);
            $('#calendar-popup #calendar-modal').modal('show');
        });
        return false;
    });
    if(!parseInt($('#search_form_return_way input[type=radio]:checked').val())){
        $('#search_form_date_to').parents('.form-group ').hide();
        //$('#search_form_date_to').val('');
    }
    $('#search_form_return_way').on('click','input[type=radio]',function(){
        var val = $('#search_form_return_way input[type=radio]:checked').val();
        var sel = $('#search_form_date_to').parents('.form-group ');
        if(!parseInt(val)){
            sel.hide();
            $('#search_form_date_to').val('');
        } else {
            sel.show();
        }
    });

    $( "#search_form_date_from" ).datepicker({
        defaultDate: "+1w",
        minDate: "d",
        lang: 'ru',
        dateFormat: 'yy-mm-dd',
        //changeMonth: true,

        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#search_form_date_to" ).datepicker( "option", "minDate", selectedDate );

            if($( "#search_form_date_to").is(':visible')){
                $( "#search_form_date_to").datepicker('show');
            }
        }
    });
    $( "#search_form_date_to" ).datepicker({
        //defaultDate: "+1w",
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#search_form_date_from" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
    
    $('body').on('click','#reverse-city',function(){
        var cityFrom = $( "#search_form_city_from" ).val();
        var cityFromCode = $( "#search_form_city_from_code").val();
        $( "#search_form_city_from" ).val($( "#search_form_city_to" ).val());
        $( "#search_form_city_from_code" ).val($( "#search_form_city_to_code" ).val());
        
        $( "#search_form_city_to" ).val(cityFrom);
        $( "#search_form_city_to_code" ).val(cityFromCode);
        
    });

    $('body').on('click','#filter-time-btn',function(){

        $('#filter-time-popup').popup(
            {
                popup: {
                    'z-index': 450
                },
                overlay : {
                    background: 'none',
                    'z-index': 400
                },
                overlaySelector : '#overlay-filter',
                closeOnClickOverlay: true

            }
        ).openWithOutOffsets();
    });

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
                hiddenInput.val(ui.item['data-value']);
            }
        });
    }
    autocomplete($( "#search_form_city_from" ),$( "#search_form_city_from_code"));
    autocomplete($( "#search_form_city_to" ),$( "#search_form_city_to_code"));

});