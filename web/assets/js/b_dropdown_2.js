+function(g){var e=".dropdown-backdrop";var b="[data-toggle=dropdown]";var a=function(i){var h=g(i).on("click.bs.dropdown",this.toggle)};a.prototype.toggle=function(k){var j=g(this);if(j.is(".disabled, :disabled")){return}var i=f(j);var h=i.hasClass("open");d();if(!h){if("ontouchstart" in document.documentElement&&!i.closest(".navbar-nav").length){g('<div class="dropdown-backdrop"/>').insertAfter(g(this)).on("click",d)}i.trigger(k=g.Event("show.bs.dropdown"));if(k.isDefaultPrevented()){return}i.toggleClass("open").trigger("shown.bs.dropdown");j.focus()}return false};a.prototype.keydown=function(l){if(!/(38|40|27)/.test(l.keyCode)){return}var k=g(this);l.preventDefault();l.stopPropagation();if(k.is(".disabled, :disabled")){return}var j=f(k);var i=j.hasClass("open");if(!i||(i&&l.keyCode==27)){if(l.which==27){j.find(b).focus()}return k.click()}var m=g("[role=menu] li:not(.divider):visible a",j);if(!m.length){return}var h=m.index(m.filter(":focus"));if(l.keyCode==38&&h>0){h--}if(l.keyCode==40&&h<m.length-1){h++}if(!~h){h=0}m.eq(h).focus()};function d(){g(e).remove();g(b).each(function(i){var h=f(g(this));if(!h.hasClass("open")){return}h.trigger(i=g.Event("hide.bs.dropdown"));if(i.isDefaultPrevented()){return}h.removeClass("open").trigger("hidden.bs.dropdown")})}function f(j){var h=j.attr("data-target");if(!h){h=j.attr("href");h=h&&/#/.test(h)&&h.replace(/.*(?=#[^\s]*$)/,"")}var i=h&&g(h);return i&&i.length?i:j.parent()}var c=g.fn.dropdown;g.fn.dropdown=function(h){return this.each(function(){var j=g(this);var i=j.data("dropdown");if(!i){j.data("dropdown",(i=new a(this)))}if(typeof h=="string"){i[h].call(j)}})};g.fn.dropdown.Constructor=a;g.fn.dropdown.noConflict=function(){g.fn.dropdown=c;return this};g(document).on("click.bs.dropdown.data-api",d).on("click.bs.dropdown.data-api",".dropdown form",function(h){h.stopPropagation()}).on("click.bs.dropdown.data-api",b,a.prototype.toggle).on("keydown.bs.dropdown.data-api",b+", [role=menu]",a.prototype.keydown)}(window.jQuery);