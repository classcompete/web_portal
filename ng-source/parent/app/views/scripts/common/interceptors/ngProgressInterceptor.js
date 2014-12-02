angular.module("ngProgressInterceptor", ["ngProgress"])
    .config(["$httpProvider",  function($httpProvider){
        $httpProvider.responseInterceptors.push('HttpProgressInterceptor');
    }])
    .provider("HttpProgressInterceptor", function HttpProgressInterceptor(){
        this.$get = ["$injector", "$q", function($injector, $q){
            var my = this;
            var ngProgress;

            this.getNgProgress = function() {       //returns the progress bar at a later point
                ngProgress = ngProgress || $injector.get("ngProgress");
                return ngProgress;
            }

            return function(promise){
                ngProgress = my.getNgProgress();        //lazily load the progress bar
                ngProgress.reset();
                ngProgress.start();
                return promise
                    .then(
                    function(response){
                        ngProgress.complete();
                        return response;
                    },
                    function(response){
                        ngProgress.complete();
                        return $q.reject(response);
                    }
                )
            }
        }]
    });