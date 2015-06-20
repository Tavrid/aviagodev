///* Открытие блока */
//var openBlock = function(el){
//	var e = $('.'+el);
//	if(e.is(':visible')){
//		e.hide();
//		$('.open-block').removeClass('open-block');
//	} else {
//		e.show();
//		$('.additional-text a').addClass('open-block');
//	}
//};
//
//$(document).ready(function($) {
//
//	/* Табы */
//	var tabs = function(link){
//		var hrefAttr = link.attr('href');
//		$('.act-tab').removeClass('act-tab');
//		$('.act-link').removeClass('act-link');
//		$(hrefAttr).addClass('act-tab');
//		link.addClass('act-link');
//	}
//
//	$('.tabs-services a').bind('click', function(event) {
//		tabs($(this));
//	});
//
//	/* Выбор перелета */
//	$('.tab-direction label').bind('click', function(event) {
//		$('#down-avia').removeAttr('disabled');
//		$('.complex-search-avia').hide();
//		$('.simple-search').hide();
//		if($(this).attr('for') == 'one-direction'){
//			$('#down-avia').attr('disabled', 'disabled');
//			$('.simple-search').show();
//			$('.date-simple').show();
//		} else if($(this).attr('for') == 'multiple-direction'){
//			$('.complex-search-avia').show();
//			$('.date-simple').hide();
//		} else {
//			$('.simple-search').show();
//			$('.date-simple').show();
//		}
//	});
//
//	var changeChilde = function(){
//		var colChild = $('select[name="children"]').val();
//		var colInfant = $('select[name="infant"]').val();
//		var total = parseInt(colChild) + parseInt(colInfant);
//		if(total == 0){
//			$('.age-rule-link').hide();
//		} else {
//			$('.age-rule-link').show();
//		}
//	}
//
//	$('select[name="children"], select[name="infant"]').change(function(event) {
//		changeChilde();
//	});
//
//	$('.lang-name-block').click(function(event) {
//		if($('.select-lang-currency').is(':visible')){
//			$('.lang-wrap').removeClass('open-currency-lang');
//		} else {
//			$('.lang-wrap').addClass('open-currency-lang');
//		}
//	});
//
//	$('.select-lang-currency').blur(function(event) {
//		$('.lang-wrap').removeClass('open-currency-lang');
//	});
//
//	$('body').click(function(event) {
//		if (!$(event.target).closest('.lang-wrap').length) {
//			$('.lang-wrap').removeClass('open-currency-lang');
//		}
//	});
//
//});