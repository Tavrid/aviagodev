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

        if($('#SearchForm_best_price').is(':checked')){

            var filterForm = $('#filter-form').serializeArray();
            var searchForm = $('#search-form').serializeArray();
            var data = searchForm.concat(filterForm);
            var url =  Routing.generate('bundles_default_api_calendar');
            $.post(url,data,function(data){
                $('#avia-calendar-box').html(data);
            })
        }
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
        _GlobalAppObject.loadingStart();
        $.post($(this).attr('action'),$(this).serialize(),function(data){
            window.location = data.url;
        }).error(function(){
            _GlobalAppObject.loadingStop();
        });
        return false;
    });
});