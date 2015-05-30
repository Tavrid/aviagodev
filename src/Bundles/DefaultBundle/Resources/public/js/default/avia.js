$(document).ready(function($) {


	/*$('#search_form_return_way').on('click','input[type=radio]',function(){
        var val = $('#search_form_return_way input[type=radio]:checked').val();
        var sel = $('#search_form_date_to').parents('.date-to');
        if(!parseInt(val)){
            sel.hide();
            $('#search_form_date_to').val('');
        } else {
            sel.show();
        }
    });*/

	$('.list-passenjers li').each(function() {
		var linkTab = $(this).find('.show-form-pass');
		var contentTab = $(this).find('.form-pass');
		linkTab.bind('click', function(event) {
			$('.list-passenjers li').slideUp().removeClass('active');
			$(this).parent().slideDown().addClass('active');
		});
	});

	$("#ui-id-1").prependTo(".city-from");
	$("#ui-id-2").prependTo(".city-to");

	/*$('.form-search-index select').selectbox();
	$('#search-form select').selectbox();
	$('#filter-form select').selectbox();*/

	$('.button-close').each(function() {
		$(this).click(function(event) {
			$(this).parent().parent().find('input[type="text"]').val('');
			event.preventDefault();
		});
	});

	$("#search_form_date_from").datepicker("destroy");
	$("#search_form_date_to").datepicker("destroy");

	$('.date_to .controls').click(function() {
		$('#search_form_date_to').focus();
	});

	$('#search_form_date_from, .date_from .controls').click(function(event) {
		$(".popup-date").show();
		event.preventDefault();
	});
	$('#search_form_date_to, .date_to .controls').click(function(event) {
		$(".popup-date").show();
		event.preventDefault();
	});

	$('.popup-date').blur(function(event) {
		$(this).hide();
	});

	$('.close').click(function(event) {
		$(".popup-date").hide();
		event.preventDefault();
	});

	$("#search_form_date_from").datepicker({
		minDate: 0,
		numberOfMonths: 3,
		dateFormat: 'yy-mm-dd',
		showAnim: "slideDown",
		beforeShow: function(){
			var aid = $(this).attr('id');
			$('#ui-datepicker-div').removeClass('search_form_date_to');
			$('#ui-datepicker-div').addClass(aid);
		},
		beforeShowDay: function (date){
			var from = $.datepicker.parseDate( "yy-mm-dd", $('#search_form_date_from').val() );
			var to = $.datepicker.parseDate( "yy-mm-dd", $('#search_form_date_to').val() );
			return [true, from && ((date.getTime() == from.getTime()) || (to && date >= from && date <= to)) ? (to && (date.getTime() === to.getTime()) ? "last-date" : "sel-date") : ""];
        },
        onClose: function(selectedDate){
			var aid = $(this).attr('id');
			$("#search_form_date_to").datepicker( "option", "minDate", selectedDate);
		}
	});

	$("#search_form_date_to").datepicker({
		minDate: 0,
		numberOfMonths: 3,
		dateFormat: 'yy-mm-dd',
		showAnim: "slideDown",
		beforeShow: function(){
			var aid = $(this).attr('id');
			$('#ui-datepicker-div').removeClass('search_form_date_from');
			$('#ui-datepicker-div').addClass(aid);
		},
		beforeShowDay: function (date){
			var from = $.datepicker.parseDate( "yy-mm-dd", $('#search_form_date_from').val() );
			var to = $.datepicker.parseDate( "yy-mm-dd", $('#search_form_date_to').val() );
			return [true, from && ((date.getTime() == from.getTime()) || (to && date >= from && date <= to)) ? (from && (date.getTime() === from.getTime()) ? "first-date" : "sel-date") : ""];
        },
        onClose: function(selectedDate){
			$("#search_form_date_from").datepicker( "option", "maxDate", selectedDate);		
		}
	});

	$('.date-from-icon').bind('click', function() {
		$("#search_form_date_from").datepicker('show');
	});

	$('.date-to-icon').bind('click', function() {
		$("#search_form_date_to").datepicker('show');
	});
	

	/*$(".return_way input[type='radio']").each(function() {
        $(this).wrap("<span class='niceRadio'></span>");
        var check = $(this).attr('checked')
        if(check=='checked'){
            $(this).parent().addClass('act-radio');
        }
        $(this).parent().click(function(event) {
            if(!$(this).hasClass('act-radio')){
            	$(".return_way .niceRadio").removeClass('act-radio');
            	$(this).addClass('act-radio');
        	}
    	});
    });*/
        
    $(".checkbox-dop").mousedown(function() {
        changeCheck($(this)); 
    });

    $(".checkbox-dop").each(function() {
         changeCheckStart($(this));
    });

    function changeCheck(el){
        var el = el,
        input = el.find("input").eq(0);
        if(!input.attr("checked")) {
            el.css("background-position","0 -20px");    
            el.addClass('act');
            input.attr("checked", true)
        } else {
            el.removeClass('act');
            el.css("background-position","0 0");    
            input.attr("checked", false)
        }
        return true;
    }

    function changeCheckStart(el){
        var el = el,
        input = el.find("input").eq(0);
        if(input.attr("checked")) {
            el.css("background-position","0 -20px");    
            el.addClass('act');
        }
        return true;
    }

    $('.btn-transplant').popover({
    	html: true
    });
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    //$('span').tooltip();
    //$('button').tooltip();
});