'use strict'

var NavigationService = function(){
    var self = this;
    this.open = null;
    // param 0 - close 1 - open
    this.menu = function(param){
        if(param){
            self.open = 1;
            $('.main-nav').animate({'left':'0'});
            $('body').animate({'padding-left':'170px'});
            $('.main-nav ul').animate({'left':'0'});
            $('.main-nav-trigger').html('Close menu');
        }else{
            self.open = 0;
            $('body').animate({'padding-left':'0'});
            $('.main-nav ul').animate({'left':'-170px'});
            $('.main-nav-trigger').html('Open menu');
        }


    };

    this.menuLogout = function(){
        $('.main-nav').animate({'left':'-170px'});
        $('body').animate({'padding-left':'0'});
        $('.main-nav ul').animate({'left':'-170px'});
    };

    this.showMainNav = function(){
        $('.main-nav').animate({'left':'0'});
    };

};
angular.module('navigationService',[]).service('NavigationService', NavigationService);