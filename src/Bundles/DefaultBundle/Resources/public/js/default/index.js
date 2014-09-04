$(function() {


    $('#search-form').on('submit',function(){

        $.post($(this).attr('action'),$(this).serialize(),function(){

        });
        return false;
    });
    $( "#SearchForm_date_from" ).datepicker({
        defaultDate: "+1w",
        numberOfMonths: 2,
        dateFormat: 'dd-mm-yy',
        onClose: function( selectedDate ) {
            $( "#SearchForm_date_to" ).datepicker( "option", "minDate", selectedDate );
            $( "#SearchForm_date_to" ).datepicker( "show");
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