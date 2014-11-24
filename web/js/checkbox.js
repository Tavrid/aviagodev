$(document).ready(function($) {

jQuery(".checkbox-dop").mousedown(
/* при клике на чекбоксе меняем его вид и значение */
function() {

     changeCheck(jQuery(this));
     
});


jQuery(".checkbox-dop").each(
/* при загрузке страницы нужно проверить какое значение имеет чекбокс и в соответствии с ним выставить вид */
function() {
     
     changeCheckStart(jQuery(this));
     
});

function changeCheck(el)
/* 
    функция смены вида и значения чекбокса
    el - span контейнер дял обычного чекбокса
    input - чекбокс
*/
{
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

function changeCheckStart(el)
/* 
    если установлен атрибут checked, меняем вид чекбокса
*/
{
var el = el,
        input = el.find("input").eq(0);
      if(input.attr("checked")) {
        el.css("background-position","0 -20px");    
        el.addClass('act');
        }
     return true;
}
 
});