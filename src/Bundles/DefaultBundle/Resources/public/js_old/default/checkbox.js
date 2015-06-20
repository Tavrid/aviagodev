$(document).ready(function($) {

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
 
});