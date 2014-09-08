var _GlobalAppObject = (function ($) {
//    $(document).ready(function(){
    var loadSel = null;
    $(document).ready(function(){
        loadSel= $('#loader').popup()
    });
    var loadStart = function () {
        loadSel.open();
    };
    var loadStop = function () {
        loadSel.close();
    };
    return new function () {
        this.loadingStart = loadStart;
        this.loadingStop = loadStop;
    };
//    });
})(jQuery);

