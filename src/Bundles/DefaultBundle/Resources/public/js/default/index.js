$(function() {


    $('#search-form').on('submit',function(){
        var routeParams = {};
        $.each($(this).serializeArray(),function(k,v){
            var name  = v.name.replace(/.*\[(.+)\].*/g,"$1");
            if(name != "city_from" && name != "city_to" && v.value){
                routeParams[name] = v.value;
            }
        });

        var r = Routing.generate('bundles_default_api_list',routeParams);
        window.location = r;
        //_GlobalAppObject.loadingStart();
        //$.post($(this).attr('action'),$(this).serialize(),function(data){
        //    window.location = data.url;
//            _GlobalAppObject.loadingStop();
//            $('#result').html(data);
//        }).error(function(r){
//            _GlobalAppObject.loadingStop();
//        });
        return false;
    });
    if(!parseInt($('#SearchForm_return_way input[type=radio]:checked').val())){
        $('#SearchForm_date_to').parents('.form-group ').hide();
        $('#SearchForm_date_to').val('');
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
    $( "#SearchForm_date_from" ).datepicker({
        defaultDate: "+1w",
        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy',
        onClose: function( selectedDate ) {
            $( "#SearchForm_date_to" ).datepicker( "option", "minDate", selectedDate );
//            $( "#SearchForm_date_to" ).datepicker( "show");
        }
    });
    $( "#SearchForm_date_to" ).datepicker({
        defaultDate: "+1w",
        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy',
        onClose: function( selectedDate ) {
            $( "#SearchForm_date_from" ).datepicker( "option", "maxDate", selectedDate );
        }
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
                hiddenInput.val(ui.item['data-value'])
            }
        });
    }
    autocomplete($( "#SearchForm_city_from" ),$( "#SearchForm_city_from_code"));
    autocomplete($( "#SearchForm_city_to" ),$( "#SearchForm_city_to_code"));

});