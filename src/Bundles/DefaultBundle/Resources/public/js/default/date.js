$(document).ready(function($) {

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

	$('dateavia').blur(function(event) {
		$(this).hide();
	});

	$('.close').click(function(event) {
		$(".popup-date").hide();
		event.preventDefault();
	});

	$(".dateavia").datepicker({
		minDate: 0,
		numberOfMonths: 2,
		beforeShowDay: function(date) {
			$.datepicker.regional['ru'] = {
			    dateFormat: 'yy-mm-dd',
			};
			$.datepicker.setDefaults($.datepicker.regional['ru']);
			var date1 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#search_form_date_from").val());
			var date2 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#search_form_date_to").val());
			return [true, date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)) ? "dp-highlight" : ""];
		},
		onSelect: function(dateText, inst) {
			$.datepicker.regional['ru'] = {
			    dateFormat: 'yy-mm-dd',
			};
		  	$.datepicker.setDefaults($.datepicker.regional['ru']);
			var date1 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#search_form_date_from").val());
			var date2 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#search_form_date_to").val());
            var selectedDate = $.datepicker.parseDate($.datepicker._defaults.dateFormat, dateText);
            if (!date1 || date2) {
				$("#search_form_date_from").val(dateText);
				$("#search_form_date_to").val("");
                   $(this).datepicker();
            } else if( selectedDate < date1 ) {
                   $("#search_form_date_to").val( $("#search_form_date_from").val() );
                   $("#search_form_date_from").val( dateText );
                   $(this).datepicker();
            } else {
				$("#search_form_date_to").val(dateText);
                   $(this).datepicker();
			}
		}
	});

});