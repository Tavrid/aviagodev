+function(b){var c=function(e,d){this.$element=b(e);this.options=b.extend({},c.DEFAULTS,d);this.transitioning=null;if(this.options.parent){this.$parent=b(this.options.parent)}if(this.options.toggle){this.toggle()}};c.DEFAULTS={toggle:true};c.prototype.dimension=function(){var d=this.$element.hasClass("width");return d?"width":"height"};c.prototype.show=function(){if(this.transitioning||this.$element.hasClass("in")){return}var e=b.Event("show.bs.collapse");this.$element.trigger(e);if(e.isDefaultPrevented()){return}var h=this.$parent&&this.$parent.find("> .panel > .in");if(h&&h.length){var f=h.data("bs.collapse");if(f&&f.transitioning){return}h.collapse("hide");f||h.data("bs.collapse",null)}var i=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[i](0);this.transitioning=1;var d=function(){this.$element.removeClass("collapsing").addClass("in")[i]("auto");this.transitioning=0;this.$element.trigger("shown.bs.collapse")};if(!b.support.transition){return d.call(this)}var g=b.camelCase(["scroll",i].join("-"));this.$element.one(b.support.transition.end,b.proxy(d,this)).emulateTransitionEnd(350)[i](this.$element[0][g])};c.prototype.hide=function(){if(this.transitioning||!this.$element.hasClass("in")){return}var e=b.Event("hide.bs.collapse");this.$element.trigger(e);if(e.isDefaultPrevented()){return}var f=this.dimension();this.$element[f](this.$element[f]())[0].offsetHeight;this.$element.addClass("collapsing").removeClass("collapse").removeClass("in");this.transitioning=1;var d=function(){this.transitioning=0;this.$element.trigger("hidden.bs.collapse").removeClass("collapsing").addClass("collapse")};if(!b.support.transition){return d.call(this)}this.$element[f](0).one(b.support.transition.end,b.proxy(d,this)).emulateTransitionEnd(350)};c.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()};var a=b.fn.collapse;b.fn.collapse=function(d){return this.each(function(){var g=b(this);var f=g.data("bs.collapse");var e=b.extend({},c.DEFAULTS,g.data(),typeof d=="object"&&d);if(!f){g.data("bs.collapse",(f=new c(this,e)))}if(typeof d=="string"){f[d]()}})};b.fn.collapse.Constructor=c;b.fn.collapse.noConflict=function(){b.fn.collapse=a;return this};b(document).on("click.bs.collapse.data-api","[data-toggle=collapse]",function(j){var l=b(this),d;var k=l.attr("data-target")||j.preventDefault()||(d=l.attr("href"))&&d.replace(/.*(?=#[^\s]+$)/,"");var f=b(k);var h=f.data("bs.collapse");var i=h?"toggle":l.data();var m=l.attr("data-parent");var g=m&&b(m);if(!h||!h.transitioning){if(g){g.find('[data-toggle=collapse][data-parent="'+m+'"]').not(l).addClass("collapsed")}l[f.hasClass("in")?"addClass":"removeClass"]("collapsed")}f.collapse(i)})}(window.jQuery);