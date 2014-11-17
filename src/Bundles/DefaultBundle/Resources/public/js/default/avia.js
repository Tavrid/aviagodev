$(document).ready(function($) {

	$("#ui-id-1").prependTo(".city_from");
	$("#ui-id-2").prependTo(".city_to");

	$('.form-search-index select').selectbox();
	$('#search-form select').selectbox();
	$('#filter-form select').selectbox();

	$('.clear_input').each(function() {
		$(this).click(function(event) {
			$(this).parent().find('input[type="text"]').val('');
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

});