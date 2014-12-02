'use strict'

var classcodeDetailModalCtrl = function($modalInstance){
    this.cancel = function(){
        $modalInstance.dismiss();
    };
};

classcodeDetailModalCtrl.$inject = ['$modalInstance'];
angular.module('classcode').controller('classcodeDetailModalCtrl',classcodeDetailModalCtrl);