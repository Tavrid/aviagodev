$(document).ready(function () {

    $(function () {

        var target = $('#fileupload');
        target.fileupload({
            url: target.attr('data-url'),
            dataType: 'json',
            add: function (e, data) {
                var t = $('<li></li>', {'class': 'load-box loader'});
                $('#files').append(t);

                var reader = new FileReader();
                var $img = $('<img>', {
                    src: URL.createObjectURL(data.files[0]),
                    style: 'opacity:0.2;width:120px;height:120px;position:absolute'

                });
                t.html($img);

                var jqXHR = data.submit().complete(function (result, textStatus, jqXHR) {
                    t.append(result.responseText);
                    var $rImg = t.find('.thumbnail-close').find('img');
                    $rImg.on('load',function(){
                        $img.remove();
                        t.removeClass('loader');
                    });
                });
            }
        });
        $('body').on('click', '.delete_link', function () {
            var self = this;
            var url = $(self).attr('data-url');
            $(self).parents('li').fadeOut(300);
            $.post(url, null, function (result) {
                if (result.status === 'success') {
                    setTimeout(function () {
                        $(self).parents('li').remove();
                    }, 300);
                }
            }, 'json');
            return false;
        });
        $('body').on('click', '.avatar', function (e) {
            e.stopPropagation();
            if ($(this).hasClass('active')) {
                return true;
            }
            var self = this;
            var url = $(self).attr('data-url');
            $('.avatar.active').removeClass('active');
            $.post(url, null, function (result) {
                if (result) {
                    $(self).addClass('active');
                }
            }, 'json');
        });

        $('.fancybox').fancybox({
            afterLoad : function() {
                var id = this.element.attr('data-id');
                var inner = $('#'+id+'-etalon')
                    .clone()
                    .attr('id','')
                    .show();
                this.inner.parent('div').append(inner);
            }
        });
    });
});
