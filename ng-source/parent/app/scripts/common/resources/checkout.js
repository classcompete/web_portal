'use strict'
angular.module('resources.checkout',['ngResource']);

var Checkout = function($resource, ENV){

    var Checkout = $resource(ENV.url + '/checkout');


    return Checkout;
};

Checkout.$inject = ['$resource','ENV'];
angular.module('resources.checkout').factory('CheckoutFactory', Checkout);