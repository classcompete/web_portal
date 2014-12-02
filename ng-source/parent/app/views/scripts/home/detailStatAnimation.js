angular.module('home').animation('.show-details-animation',function(){

    var slideDown = function(element, done){
        element.css('display','none').stop().slideDown(500,done);
    };

    var slideUp = function(element, done){

        element.stop().slideUp(500,done);
    };

    return{
        enter:slideDown,
        leave:slideUp
    }
});