'use strict'

var ClassCodeCtrl = function(NavigationService, ENV, $modal){
    $(window).width() < 1024 ? NavigationService.showMainNav() : NavigationService.menu(1);

    this.$modal = $modal;

    this.saveCustomer = function(status, response){
    };

    //this.hendler = StripeCheckout.configure({
    //    key: 'pk_test_neebAHr2yMhQXlM8SHMN0lk7',
    //    image: '/square-image.png',
    //    token: function(token, args) {
    //        // Use the token to create the charge with a server-side script.
    //        // You can access the token ID with `token.id`
    //    }
    //});
};

ClassCodeCtrl.prototype.buy = function(event){
    this.hendler.open({
        name: 'Demo Site',
        description: '2 widgets ($20.00)',
        amount: 2000
    });
    event.preventDefault();
};

ClassCodeCtrl.prototype.openHelpModal = function(){
    var self = this;

    var modalInstance = self.$modal.open({
        templateUrl: 'views/classcodeDetailModal.html',
        controller: 'classcodeDetailModalCtrl as c_classcodeDetail',
        backdrop:'static',
        size:'lg'
    });
}

ClassCodeCtrl.resolve ={
};

ClassCodeCtrl.$inject = ['NavigationService','ENV', '$modal'];
angular.module('classcode').controller('ClassCodeCtrl',ClassCodeCtrl);