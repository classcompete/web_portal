angular.module('header').animation('.showHeader',function(){

    var slideDown = function(element, done){
        element.animate({
            top:0
        },done);

    };

    var slideUp = function(element, done){
        element.animate({
            top:'-60px'
        },done);
    };

    return{
        enter:slideDown,
        leave:slideUp
    }
});
