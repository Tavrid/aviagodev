$(function() {
    $(document).ready(function(){

        var p = 1;
        function getItems(page,res){
            _GlobalAppObject.loadingStart();
            var filterForm = $('#filter-form').serializeArray();
            var searchForm = $('#search-form').serializeArray();
            var data = searchForm.concat(filterForm);
            var url =  Routing.generate('bundles_default_api_flights_items',{'page': page});
            $.post(url,data,function(data){
                if(!data.hasNext){
                    $('#get-next').addClass('hidden');
                } else {
                    $('#get-next').removeClass('hidden');
                }
                res(data);

                _GlobalAppObject.loadingStop();
            }).error(function(){
                _GlobalAppObject.loadingStop();
            });
        }
        setTimeout(function(){
            getItems(p,function(data){
                $('#result-box').html(data.html);
                $('#search-result-box').html(data.filter_form)
            });
        },100);
        $('body').on('change','#filter-form',function(){
            p = 1;
            getItems(p,function(data){
                $('#result-box').html(data.html);
            });

        });
        $('body').on('click','#get-next',function(){
            p ++;
            getItems(p,function(data){
                $('#result-box').append(data.html);
            });

        });
        $('body').on('submit','.book-form',function(){
            $.post($(this).attr('action'),$(this).serialize(),function(data){
                window.location = data.url;
            });
            return false;
        });
    });

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