$(document).ready(function($) {

	$("#ui-id-1").prependTo(".city_from");
	$("#ui-id-2").prependTo(".city_to");

	$('.avia select').selectbox();
	$('.currency select').selectbox();
	$('.klass select').selectbox();
	$('.vozrast select').selectbox();

	$(".return_way input[type='radio']").each(function() {
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
	});

	$('.clear_input').each(function() {
		$(this).click(function(event) {
			$(this).parent().find('input[type="text"]').val('');
			event.preventDefault();
		});
	});

});