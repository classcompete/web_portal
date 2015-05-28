'use strict';

var ShopCtrl = function(NavigationService, ENV, classes, UnusedStudentsFactory, ShoppingCart, $modal, $location){
    $(window).width() < 1024 ? NavigationService.showMainNav() : NavigationService.menu(1);

    this.$location = $location;
    this.classes = classes;
    this.$modal = $modal;
    this.selectedClass = null;
    this.students = null;
    this.UnusedStudentsFactory = UnusedStudentsFactory;
    this.cart = ShoppingCart;
};

ShopCtrl.prototype.openShopModal = function(_selectedClass){
    var self = this;
    this.selectedClass = _selectedClass;

    var modalInstance = self.$modal.open({
        templateUrl: 'views/shop/modal.html',
        controller: ShopModalCtrl,
        size: 'lg',
        backdrop:'static',
        resolve: {
            students: function(){
                return self.UnusedStudentsFactory.query({classId:_selectedClass.classId});
            },
            selectedClass: function(){
                return angular.copy(_selectedClass);
            },
            cart: function(){
                var _cart_len = self.cart.items.length, i, _cartItems = self.cart.items;
                for(i = 0; i < _cart_len ; i++){
                    if(_cartItems[i].classId === _selectedClass.classId)
                        return _cartItems[i];
                }
                return null;
            }
        }
    });

    modalInstance.result.then(
        function (result) {
            if(result.cartItem.student.length > 0){
                self.cart.addItem(result.cartItem);
            }
            if(result.checkout)self.$location.path('/checkout');

        },
        function () {
        }
    );
};

ShopCtrl.prototype.openDetailModal = function(_selectedClass){
    var self = this;
    this.selectedClass = _selectedClass;

    var modalInstance = self.$modal.open({
        templateUrl:'views/shop/detailModal.html',
        controller:'ShopDetailModalCtrl as c_shopDetail',
        size:'lg',
        resolve:{
            description: function(){
                return _selectedClass.details.description;
            },
            title: function(){
                return _selectedClass.name;
            },
            price: function(){
                return _selectedClass.price;
            }
        }

    });

    modalInstance.result.then(
        function(result){
            self.openShopModal(_selectedClass);
        },
        function(result){

        }
    );
}

ShopCtrl.prototype.openConnectionModal = function(_selectedClass){
    var self = this;
    var modalInstance = self.$modal.open({
        templateUrl: 'views/shop/connectionModal.html',
        controller: ConnectionModalCtrl,
        size: 'lg',
        backdrop:'static',
        resolve: {
            students: function(){
                return self.UnusedStudentsFactory.query({classId:_selectedClass.classId});
            },
            selectedClass: function(){
                return angular.copy(_selectedClass);
            }
        }
    });

    modalInstance.result.then(
        function (result) {
            _selectedClass.quantity -= result.length;
        },
        function () {

        }
    );
    this.selectedClass = _selectedClass;
};

ShopCtrl.resolve = {
    classes: ['$q','ClassesFactory', function($q, ClassesFactory){
        var def = $q.defer();
        ClassesFactory.query().$promise.then(function(data){
            def.resolve(data);
        });
        return def.promise;
    }]
};

ShopCtrl.$inject = ['NavigationService','ENV','classes','UnusedStudentsFactory','ShoppingCart','$modal','$location'];
angular.module('shop').controller('ShopCtrl',ShopCtrl);