'use strict'

var ShoppingCart = function(){
    this.items = [];
    this.loadItems();
};

ShoppingCart.prototype.loadItems = function(){

};

ShoppingCart.prototype.addItem = function(_item){
    for(var i = 0; i < this.items.length; i++){
        if(this.items[i].classId === _item.classId)return;
    }

    this.items.push(_item);
};

ShoppingCart.prototype.getTotalQuantity = function(){
    var i, _items_length = this.items.length, _totalQuantity = 0;

    for(i = 0; i < _items_length; i++){
        var _item = this.items[i];
        _totalQuantity += _item.quantity;
    }

    return _totalQuantity
};

ShoppingCart.prototype.getTotalItemPrice = function(item){
    return parseFloat(item.price * item.quantity).toFixed(2);
};

ShoppingCart.prototype.getTotalCardPrice = function(){
    var i, _itemsLength = this.items.length, _totalPrice = 0.00;

    for(i = 0; i < _itemsLength; i++){
        var _item = this.items[i];
        _totalPrice += Math.round(_item.price * _item.quantity * 100)/100;
    }

    return _totalPrice;
};

ShoppingCart.prototype.clearCart = function(){
    this.items = [];
};

angular.module('ccompparentApp').service('ShoppingCart',ShoppingCart);