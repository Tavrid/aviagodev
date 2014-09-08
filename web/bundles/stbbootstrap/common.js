var _stbBootstrapBundle = (function(){
    var defaultPostParams = {
        url: null,
        data: {}
    };
    return new function(){
        var $base = this;
        $base.addRequestParam = function(key,val){
            defaultPostParams['data'][key] = val;
        };
        this.create = function(){
            return new function(){
                this.onInit = function(e){};
                this.onLoad = function(e){};
                this.onComplete = function(res,e){};
                this.onError = function(res,e){};
                this.onSuccess = function(res,e){};
                this.confirm = true;

                this.addElement = function(e,param){
                    var cloneEl = e.clone();
                    var $this = this;
                    var data = param.data;
                    this.onInit(e);
                    e.on('click',function(){
                        var cf = function(){
                            $this.onLoad(cloneEl);
                            $.post(param.url,data,function(res){
                                $this.onComplete(res,cloneEl);
                                $this.onSuccess(res,cloneEl);
                            }).error(function(res){
                                $this.onComplete(res,cloneEl);
                                $this.onError(res,cloneEl);
                            });
                        };
                        if(typeof $this.confirm == 'function'){
                            if($this.confirm()){
                                cf();
                            }
                        } else {
                            cf();
                        }
                    });
                };
            };
        };
    };
})();