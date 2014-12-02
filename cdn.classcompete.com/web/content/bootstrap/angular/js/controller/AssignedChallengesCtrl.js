angular.module('ccomp').controller('AssignedChallengesCtrl', function($scope, $rootScope, $location, $modal,$filter, AssignedChallengesResource, ClassroomResource){

    $rootScope.mainLoading = true;
    $scope.searchCollapsed = true;
    $scope.filterCollapsed = true;
    $scope.sortingOrder = 'challenge_name';
    $scope.reverse = false;
    $scope.filteredChallenges = [];
    $scope.groupedChallenges = [];
    $scope.viewPerPage = [{per_page:15},{per_page:30},{per_page:45}];
    $scope.selectedItemsPerPage = $scope.viewPerPage[0];
    $scope.challengesPerPage = 15;
    $scope.pagedChallenges = [];
    $scope.currentPage = 0;
    $scope.query_challenges = '';


    AssignedChallengesResource.getAll().$promise.then(function(data){
        $scope.challenges = data.challenges;
        $scope.search();
        $rootScope.mainLoading = false;
    });

    ClassroomResource.get().$promise.then(function(data){
        $scope.classrooms = data.class_list;
    });


    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(page){
        $scope.filteredChallenges = $filter('filter')($scope.challenges, function(item){
                if(searchMatch(item['challenge_name'], $scope.query_challenges)){
                    return true;
                }
        });

        if($scope.sortingOrder !== ''){
            $scope.filteredChallenges = $filter('orderBy')($scope.filteredChallenges, $scope.sortingOrder, $scope.reverse);
        }

        if(page !== angular.undefined){
            $scope.currentPage = page;
        }else
            $scope.currentPage = 0;

        $scope.groupToPages();
    };

    $scope.groupToPages = function(){
        $scope.pagedChallenges = [];
        for(var i = 0; i < $scope.filteredChallenges.length; i++){
            if(i % $scope.challengesPerPage === 0){
                $scope.pagedChallenges[Math.floor(i/$scope.challengesPerPage)] = [$scope.filteredChallenges[i]];
            }else{
                $scope.pagedChallenges[Math.floor(i/$scope.challengesPerPage)].push($scope.filteredChallenges[i]);
            }
        }
    };
    $scope.range = function(start, end){
        var ret = [];
        if(!end){
            end = start;
            start = 0;
        }
        for(var i = start; i < end; i++){
            ret.push(i);
        }
        return ret;
    };

    $scope.prevPage = function(){
        if($scope.currentPage > 0){
            $scope.currentPage--;
        }
    };

    $scope.nextPage = function(){
        if($scope.currentPage < $scope.pagedChallenges.length - 1){
            $scope.currentPage++;
        }
    };

    $scope.setPage = function(){
        $scope.currentPage = this.n;
    };

    $scope.changeItemPerPage = function(itemsPerPage){
        $scope.challengesPerPage = itemsPerPage.per_page;
        $scope.search();
    };
    $scope.getChallenges = function(item){
      if(item === null){
          AssignedChallengesResource.getAll().$promise.then(function(data){
              $scope.challenges = data.challenges;
              $scope.search();
          });
      }else{
          AssignedChallengesResource.get({id:item.class_id}).$promise.then(function(data){
              $scope.challenges = data.challenges;
              $scope.search();
          });
      }
    };

    $scope.remove = function(index,challenge){
        var removeModal = $modal.open({
            templateUrl:'partials/modals/yes_no.html',
            controller:'RemoveAssignedChallengeCtrl',
            windowClass:'classmodal',
            backdrop:'static',
            resolve:{
                title:function(){
                    return 'Remove challenge';
                },
                message:function(){
                    return 'Are you sure you want to remove this challenge?'
                }
            }
        });

        removeModal.result.then(function(){
            AssignedChallengesResource.delete({challclass:challenge}).$promise.then(function(){
                toastr.success($scope.pagedChallenges[$scope.currentPage][index].challenge_name,'Challenge is deleted from class');
                $scope.pagedChallenges[$scope.currentPage].splice(index,1);

                AssignedChallengesResource.getAll().$promise.then(function(data){
                    $scope.challenges = data.challenges;
                });
            });
        });
    };

    $scope.edit = function(index){
        var editModal = $modal.open({
            templateUrl:'partials/modals/edit_challenge.html',
            controller:'EditChallengeCtrl',
            windowClass:'classmodal',
            backdrop:'static',
            resolve:{
                challenge: function(){
                    return $scope.pagedChallenges[$scope.currentPage][index];
                }
            }
        });

        editModal.result.then(function(edited_challenge){
            AssignedChallengesResource.getAll().$promise.then(function(data){
                $scope.challenges = data.challenges;
                $scope.search($scope.currentPage);
                toastr.success($scope.pagedChallenges[$scope.currentPage][index].challenge_name,'Challenge data is updated!');
            });
        });
    };

    $scope.questions = function(challenge){
        $location.path('/question/challenge/'+challenge);
    };

    $scope.collapseFilters = function(type){
        switch (type){
            case 'search':
                $scope.searchCollapsed = !$scope.searchCollapsed;
                $scope.filterCollapsed = true;
                break;
            case 'filter':
                $scope.searchCollapsed = true;
                $scope.filterCollapsed = !$scope.filterCollapsed;
                break;
        }
    };
});
angular.module('ccomp').controller('RemoveAssignedChallengeCtrl', function($scope,$modalInstance, title,message){

    $scope.title = title;
    $scope.message = message;

    $scope.ok = function(){
        $modalInstance.close();
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('close');
    };

});
angular.module('ccomp').controller('EditChallengeCtrl',function($scope,$modalInstance,challenge,SubjectResource, ChallengeResource, SkillResource, TopicResource, GameResource, GradeResource,ErrorService){

    $scope.ErrorService = ErrorService;

    ChallengeResource.get({id:challenge.challenge_id}).$promise.then(function(data){
        $scope.challenge = data;

        SkillResource.get({id:$scope.challenge.subject_id}).$promise.then(function(data){
            $scope.skills = data;
        });

        TopicResource.get({id:$scope.challenge.skill_id}).$promise.then(function(data){
            $scope.topics = data;
        });
        SubjectResource.get().$promise.then(function(data){
            $scope.subjects = data;
        });

        GameResource.get().$promise.then(function(data){
            $scope.games = data;
        });

        GradeResource.get().$promise.then(function(data){
            $scope.grades = data;
        });
    });

    $scope.changeSubject = function(new_subject){
        $scope.disableTopic = true;
        $scope.challenge.skill_id = null;
        $scope.challenge.topic_id = null;
        $scope.topics = {};
        SkillResource.get({id:new_subject}).$promise.then(function(data){
            $scope.skills = data;
        });
    };

    $scope.changeTopic = function(new_skill){
        TopicResource.get({id:new_skill}).$promise.then(function(data){
            $scope.topics = data;
        });
        $scope.disableTopic = false;
    };

    $scope.ok = function(form){

        var $my_form = $('#'+form.$name);
        $my_form.validate(function($form, e){
            if(angular.isDefined(e)){
                ChallengeResource.edit($scope.challenge).then(function(data){
                    $modalInstance.close($scope.challenge);
                });
            }
        });
    };

    $scope.cancel = function(){
        ErrorService.clearError();
        $modalInstance.dismiss('close');
    };

});