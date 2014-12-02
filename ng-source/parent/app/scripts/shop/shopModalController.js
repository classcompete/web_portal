var ShopModalCtrl = function($scope, $modalInstance, students, selectedClass, cart, ShoppingCartItem){

    $scope.students = students;
    $scope.class = selectedClass;

    if(cart != null){
        $scope.cart = cart;
    }else{
        $scope.cart = new ShoppingCartItem.add(selectedClass.classId, selectedClass.name, 0 , selectedClass.price);
    }

    $scope.$watch('cart.student', function(oldVal, newVal){
        $scope.cart.quantity = $scope.cart.student.length;
    });

    $scope.backToShop = function(){
        $modalInstance.close({cartItem:$scope.cart,checkout:false});
    };

    $scope.gotToCheckout = function(){
        $modalInstance.close({cartItem:$scope.cart,checkout:true})
    };

    $scope.cancel = function(){
        $modalInstance.dismiss();
    }

};

ShopModalCtrl.$inject = ['$scope','$modalInstance','students','selectedClass','cart','ShoppingCartItem'];
angular.module('shop').controller('ShopModalCtrl',ShopModalCtrl);