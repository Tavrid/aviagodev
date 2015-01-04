$(function() {


    $("#search-form").validate({
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
        },
        submitHandler: function (form) {
            var routeParams = {};
            $.each($(form).serializeArray(),function(k,v){
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
        },
        ignore: ":hidden"
    });



    $('body').on('click','.calendar-item',function(){
        _GlobalAppObject.loadingStart();
        $.get($(this).attr('href'),{},function(data){
            _GlobalAppObject.loadingStop();
            $('#calendar-popup').html(data);
            $('#calendar-popup #calendar-modal').modal('show');
        }).error(function(){
            _GlobalAppObject.loadingStop();
        });
        return false;
    });

    $('.return-way-inner #search_form_return_way label').after('<div class="clear"></div>');


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



});