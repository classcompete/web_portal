'use strict'

var ShopDetailModalCtrl = function($modalInstance, description, title, price){
    this.title = title;
    this.description = description;
    this.price = price;

    this.cancel = function(){
        $modalInstance.dismiss();
    };

    this.selectStudent = function(){
        $modalInstance.close();
    };
};

ShopDetailModalCtrl.$inject = ['$modalInstance','description','title','price'];
angular.module('shop').controller('ShopDetailModalCtrl',ShopDetailModalCtrl);