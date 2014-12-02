angular.module('setupstudent').animation('.studentForm',function(){

    var showNav = function(element, done){

        element.animate({
            opacity:0,
            display: 'hidden'
        },done);
    };
    var closeNav = function(element, done){

        element.animate({
            opacity:1,
            display: 'block'
        },done);

    };

    return{
        beforeAddClass:showNav,
        removeClass:closeNav
    }
});