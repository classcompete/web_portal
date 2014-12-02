'use strict';


var NotificationService = function(){

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp"
    };
    var _toastr = null

    /**
     * Show error notification
     * @param title
     * @param mesage
     */
    this.error = function(mesage, title){
        this.clearLast();
       _toastr =  toastr.error(mesage, title || '');
    };

    /**
     * Show success notification
     * @param title
     * @param message
     */
    this.success = function(message, title){
        this.clearLast();
        toastr.success(message, title || '');
    };

    /**
     * Show info message
     * @param title
     * @param message
     */
    this.info = function(message, title){
        this.clearLast();
        toastr.info(message, title || '');
    };

    /**
     * Show warning message
     * @param title
     * @param message
     */
    this.warning = function(message, title){
        toastr.warning(message, title || '');
    };

    /**
     * Clear notification messages
     */
    this.clear = function(){
        toastr.clear();
    };

    /**
     * Clear last notification message
     */
    this.clearLast = function(){
        toastr.clear(_toastr)
    };

    this.showMessage = function(message, title, type){
        var str = '';
        if(angular.isArray(message)){
            var i = 0, messageLength = message.length;
            for(i; i < messageLength; i++){
                str += message[i].message + '</br>';
            }
        }else if(angular.isObject(message)){
            for(var property in message){
                str += message[property] + '</br>';
            }
        }else{
            str = message;
        }

        if(typeof this[type] == 'function'){
            this[type](str, title);
        }
    };
};

NotificationService.$inject = [];
angular.module('ccompparentApp').service('NotificationService',NotificationService);
