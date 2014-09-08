$.fn.popup = function(o) {
    var self = this;
    defaults = {
        popup : {
            position : 'absolute',
            display: 'none',
            'z-index': 1000
        },
        overlay : {
            background: 'none repeat scroll 0 0 #000000',
            display: 'none',
            height: '100%',
            left: 0,
            opacity: 0.3,
            position: 'fixed',
            top: 0,
            width: '100%',
            'z-index': 500
        },
        overlaySelector : '#overlay',
        closeSelectors : [],
        onOpen: function(){

        }

    };
    self.options = $.extend(true, defaults, o || {});
    self.open = function (element,options){
        open_pop_up(element,options);
    };

    self.openWithOutOffsets = function(){
        $(self).show();
        $(self.options.overlaySelector).show();
        self.options.onOpen(self);
    };
    self.close = function(){
        self.onClose();
        close_pop_up();
    };

    self.openByHashTag = function(){
        var hash = parseHash();
        if(hash.popup !== undefined && self.attr('id') == hash.popup){
            setTimeout(function(){
                self.openWithOutOffsets();
            },300);
        }
    };
    function parseHash(){
        var ret = {};
        if(window.location.hash){
            var hash = window.location.hash.split('&');
            $.each(hash,function(k,v){
                var param = v.split('=');
                ret[param[0].replace('#','')] = param[1].replace('#','');
            });
        }
        return ret;
    }

    self.init = function(){
        return self;
    };

    self.onClose = function(){

    };

    self.onOpen = function(){

    };


    function open_pop_up(element,options) {
        var css = {};
        if(element !== undefined){
//            element.offset()
            if(options.left !== undefined){
                css['left'] = element.offset().left + options.left;
            }

            if(options.right !== undefined){
                css['left'] = (element.offset().left  + element.width()) - options.right - $(self).width();
//                css['right'] = element.offset().right;
            }

            if(options.top !== undefined){
                css['top'] = element.offset().top + element.height() + options.top;
            }

            if(options.bottom !== undefined){
                css['top'] = element.offset().top + options.bottom  - element.height() - $(self).height();
            }
        } else {
            css['left'] = ($(window).width() - $(self).width()) / 2 + $(window).scrollLeft();
            css['top'] = ($(window).height() - $(self).height()) / 2 + $(window).scrollTop();
        }
        $(self).css(css).show();
        $(self.options.overlaySelector).show();
    }

    function close_pop_up() {
        $(self).hide();
        $(self.options.overlaySelector).hide();
        self.onClose();
    }

    $(function() {
        $(self).css(self.options.popup);
        if($(self.options.overlaySelector).length == 0){
            $('body').append('<div id="'+self.options.overlaySelector.replace('#','')+'"></div>')
        }
        $(self.options.overlaySelector).css(self.options.overlay);

        self.options.closeSelectors.push(self.options.overlaySelector);
        $('body').on('click',self.options.closeSelectors.join(', '),function(){
            close_pop_up();
        });
    });
    return self.init();
};


