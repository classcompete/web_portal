'use strict'

var ShoppingCartItem = function(){

    ShoppingCartItem.add = function (classId, className, quantity, price){
        this.classId = classId;
        this.className = className;
        this.quantity = quantity;
        this.price = Math.round(price * 100)/100;
        this.student = [];
    };

    return ShoppingCartItem;

};
angular.module('ccompparentApp').factory('ShoppingCartItem',ShoppingCartItem );