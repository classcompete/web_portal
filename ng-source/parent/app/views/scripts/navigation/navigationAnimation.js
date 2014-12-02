angular.module('navigation').animation('.navigation',function(){

    var showNav = function(element, done){

//        element.animate({
//            left:0
//        },done);
//
//        $('body').css('padding-left','0').animate({
//            'padding-left':'170px'
//        },done);
    };
    var closeNav = function(element, done){

//        element.animate({
//            left:'-170px'
//        },done);
//
//        $('body').css('padding-left','170px').animate({
//            'padding-left':'0px'
//        },done);
    };

    return{
        beforeAddClass:showNav,
        removeClass:closeNav
    }
});