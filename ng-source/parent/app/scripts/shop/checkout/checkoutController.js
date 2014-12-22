'use strict'

var CheckoutCtrl = function(NavigationService, STRIPE, $location, ShoppingCart, ShoppingCartItem, Security, CheckoutFactory, NotificationService, students){
    $(window).width() < 1024 ? NavigationService.showMainNav() : NavigationService.menu(1);

    var self = this;
    this.students = students;
    this.cart = ShoppingCart;
    this.totalPrice = ShoppingCart.getTotalCardPrice();
    this.$location = $location;

    if(this.cart.items.length === 0){
        $location.path('/shop')
    }

    this.hendler = StripeCheckout.configure({
        name: 'Class Compete',
        allowRememberMe: false,
        zipCode: true,
        key: STRIPE.key,
        image: 'images/logo128.png',
        currency:'USD',
        email:Security.getEmail(),
        token: function(token, args) {
            // Use the token to create the charge with a server-side script.
            // You can access the token ID with `token.id`
            console.log(token); console.log(args);
            CheckoutFactory.save({token:token, args:args, cart:self.cart.items}).$promise.then(function(data){
                NotificationService.showMessage(data,'Success payment','success');
                self.cart.clearCart();
                $location.path('/shop');
            });

        }
    });
};

CheckoutCtrl.prototype.getStudent = function(id){
    for(var i = 0; i < this.students.length; i++){
        if(parseInt(id) === this.students[i].studentId){;
            return this.students[i].firstName + ' ' + this.students[i].lastName;
        }
    }
};

CheckoutCtrl.prototype.removeStudent = function(item, studentId){
    item.student.slice(item.student.indexOf(studentId),1);
    for(var i =  item.student.length -1; i >=0;i--){
        if(item.student[i] == studentId){
            item.student.splice(i,1);
            item.quantity--;
        }

    }

    if(item.quantity === 0){
        this.cart.items.splice(this.cart.items.indexOf(item),1);
    }

    this.totalPrice = this.cart.getTotalCardPrice();

    if(this.cart.items.length === 0){
        this.$location.path('/shop');
    }
};

CheckoutCtrl.prototype.buy = function($event){
    var self = this;
    this.hendler.open({
        description: self.cart.getTotalQuantity() + ' classes',
        amount: Math.round(self.cart.getTotalCardPrice()* 100)
    });
    $event.preventDefault();
};

CheckoutCtrl.resolve = {
    students:['$q','StudentsFactory', function($q, StudentsFactory){
        var def = $q.defer();

        StudentsFactory.query().$promise.then(function(r){
            def.resolve(r);
        });
        return def.promise;
    }]
}



CheckoutCtrl.$inject = ['NavigationService','STRIPE','$location','ShoppingCart','ShoppingCartItem','Security','CheckoutFactory','NotificationService','students'];
angular.module('checkout').controller('CheckoutCtrl',CheckoutCtrl);