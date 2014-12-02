'use strict';

var HomeCtrl = function(globalStatistic, IMG, StatisticListFactory, NavigationService){

    $(window).width() < 1024 ? NavigationService.showMainNav() : NavigationService.menu(1);

    this.imageUrl = IMG.url;
    this.globalStatistic = globalStatistic;
    this.statisticList = StatisticListFactory;
    this.detailsStat = null;
    this.showDetailsIndex = null;

};

HomeCtrl.prototype.getDetails = function(student, showDetailsIndex){
    var self = this;
    if(this.showDetailsIndex === showDetailsIndex){
        this.showDetailsIndex = null;
        return;
    }
    this.statisticList.get({id:student.studentId}).$promise.then(function(r){
        self.detailsStat = r.response;
        self.showDetailsIndex = showDetailsIndex;
    });
};

HomeCtrl.resolve ={
    globalStatistic: ['$q','StatisticFactory',  function($q, StatisticFactory){
        var deferred = $q.defer();
        StatisticFactory.query().$promise.then(function(r){
            deferred.resolve(r);
        });
        return deferred.promise;
    }]
};

HomeCtrl.$inject = ['globalStatistic','IMG','StatisticListFactory','NavigationService'];
angular.module('home').controller('HomeCtrl', HomeCtrl);