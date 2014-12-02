angular.module('ccomp').controller('ContentBuilderCtrl',function($scope, $rootScope, $location,$filter,$modal,ContentBuilderResource, ModalService){

    $rootScope.mainLoading = true;
    $scope.searchCollapsed = true;
    $scope.filterCollapsed = true;
    $scope.sortingOrder = 'challenge_name';
    $scope.reverse = false;
    $scope.filteredChallenges = [];
    $scope.groupedChallenges = [];
    $scope.viewPerPage = [{per_page:20},{per_page:30},{per_page:40}];
    $scope.selectedItemsPerPage = $scope.viewPerPage[0];
    $scope.challengesPerPage = 20;
    $scope.pagedChallenges = [];
    $scope.currentPage = 0;
    $scope.query_challenges = '';

    ContentBuilderResource.get().$promise.then(function(data){
        $scope.challenges = data.challenges;
        $scope.search();
        $rootScope.mainLoading = false;
    });

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(page){
        $scope.pagedChallenges = [];
        $scope.filteredChallenges = $filter('filter')($scope.challenges, function(item){
            if(searchMatch(item['challenge_name'], $scope.query_challenges)){
                return true;
            }
        });

        if($scope.sortingOrder !== ''){
            $scope.filteredChallenges = $filter('orderBy')($scope.filteredChallenges, $scope.sortingOrder, $scope.reverse);
        }

        if(page === angular.undefined)
            $scope.currentPage = 0;
        else
            $scope.currentPage = page;
        $scope.groupToPages();
    };

    $scope.groupToPages = function(){
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

    $scope.editChallenge = function(index){
        console.warn($scope.currentPage);
        console.warn($scope.challengesPerPage);
        console.warn(index);
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
            ContentBuilderResource.singleGet({id:$scope.pagedChallenges[$scope.currentPage][index].challenge_id}).$promise.then(function(data){
                $scope.pagedChallenges[$scope.currentPage][index] = data.challenge
                $scope.challenges[($scope.currentPage * $scope.challengesPerPage) + index] = data.challenge;
                toastr.success($scope.pagedChallenges[$scope.currentPage][index].challenge_name,'Challenge data is updated!');
            });
        });

    };
    $scope.installChallenge = function(index){

        var modalRemoveInstance = $modal.open({
            templateUrl:'partials/modals/install_challenge.html',
            controller:'AddChallengeController',
            windowClass:'classmodal',
            backdrop:'static',
            resolve:{
                challenge: function(){
                    return $scope.pagedChallenges[$scope.currentPage][index].challenge_id;
                }
            }
        });

        modalRemoveInstance.result.then(function(){
            toastr.success($scope.pagedChallenges[$scope.currentPage][index].challenge_name,'Challenge successfully installed in class!');
        });
    };

    $scope.addNewChallenge = function(){

        var modalCreateNewChallenge = $modal.open({
            templateUrl:'partials/modals/content_builder.html',
            controller:'CreateNewChallenge',
            windowClass:'classmodal modal_wide modal_top',
            backdrop:'static',
            resolve:{}
        });

        modalCreateNewChallenge.result.then(function(challenge, challenge_name){
            $location.path('/question/challenge/'+challenge);
            toastr.success(challenge_name, 'Challenge is successfully created!');
        });
    };

    $scope.questions = function(index){
        $location.path('question/challenge/'+$scope.pagedChallenges[$scope.currentPage][index].challenge_id);
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
angular.module('ccomp').controller('AddChallengeController',function($scope, $modalInstance, challenge, ClassroomResource, ChallengeResource,ErrorService){

    $scope.ErrorService  = ErrorService;
    $scope.class = {};

    ClassroomResource.getAvailable({id:challenge}).$promise.then(function(data){
        if(data.class_list){
            $scope.classes = data.class_list;
        }else{
            $scope.no_classes = true;
        }

    });

    $scope.ok = function(form){

        var $my_form = $('#'+form.$name);
        $my_form.validate(function($form, e){
            if(angular.isDefined(e)){
                ChallengeResource.install({challenge:challenge, class:$scope.class.class_id}).$promise.then(function(){
                    $modalInstance.close();
                });
            }
        });
    };

    $scope.cancel = function(){
        ErrorService.clearError();
        $modalInstance.dismiss('close');
    };

});
angular.module('ccomp').controller('CreateNewChallenge', function($scope, $rootScope, $modal, $modalInstance, SubjectResource, SkillResource, TopicResource, GradeResource, GameResource, ContentBuilderResource, ErrorService, ModalService){

    $scope.ErrorService = ErrorService;

    $scope.current_tab = [true,false,false,false];
    $scope.show_content = ['challenge','question_type','question','marketplace'];
    $scope.active_tab = 0;
    $scope.selectedEnvironment = null;
    $scope.challenge = {};
    $scope.question = [];

    $scope.$watch('ErrorService.errorMessage', function(){
        if(ErrorService.errorMessage !== null){
            if(angular.isDefined(ErrorService.errorMessage.challenge)){
                $scope.changeTab(0);
                angular.forEach(ErrorService.errorMessage.challenge,function(val,key){
                    toastr.error(val);
                });
            }else if(angular.isDefined(ErrorService.errorMessage.question)){
                $scope.changeTab(2);
                angular.forEach(ErrorService.errorMessage.question,function(val,key){
                    toastr.error(val);
                });
            }
        }
    });


    $scope.calculateBarWidth = function(){
        return {width:(($scope.active_tab + 1) / $scope.current_tab.length) * 100 + '%'};
    };

    $scope.barWidth = {width: $scope.calculateBarWidth()};

    SubjectResource.get().$promise.then(function(data){
        $scope.subjects = data;
    });

    GradeResource.get().$promise.then(function(data){
        $scope.grades = data;
    });

    GameResource.get().$promise.then(function(data){
        $scope.games = data;
    });

    $scope.selectSubject = function(subject){
        SkillResource.get({id:subject}).$promise.then(function(data){
            $scope.skills = data;
        });
    };

    $scope.selectSkill = function(skill){
        TopicResource.get({id:skill}).$promise.then(function(data){
            $scope.topics = data;
        });
    };


    $scope.changeTab = function(set_tab,form,question_type){

        $scope.selectedEnvironment = $scope.challenge.game_code;
        if(angular.isDefined(form) && form !== null ){
            var $my_form = $('#'+form.$name);

            $my_form.validate(function($form, e){
                if(angular.isUndefined(e)){
                    angular.forEach($form,function(val,key){
                        toastr.error(val.message);
                    })
                }else{
                    $scope.$apply(function(){
                        $scope.current_tab[$scope.active_tab] = false;
                        $scope.current_tab[set_tab] = true;
                        $scope.active_tab = set_tab;
                        $scope.selectedTab = $scope.show_content[set_tab];
                        $scope.calculateBarWidth();

                        if(angular.isDefined(question_type)){
                            $scope.question.question_type = question_type;
                        }
                    });
                }
            });
        }else{
            $scope.current_tab[$scope.active_tab] = false;
            $scope.current_tab[set_tab] = true;
            $scope.active_tab = set_tab;
            $scope.selectedTab = $scope.show_content[set_tab];
            $scope.calculateBarWidth();

            if(angular.isDefined(question_type)){
                $scope.question.question_type = question_type;
            }
        }

        console.info($scope.challenge);
        console.info($scope.question);
    };

    $scope.setImage = function(question_type_image, created_image, created_image_url, display_size){

        if(display_size === 'big_size'){
            var editModal = $modal.open({
                templateUrl:'partials/modals/image_cropper_big.html',
                controller:'ImageCropperCtrl',
                windowClass:'classmodal modal_semiwide',
                backdrop:'static',
                resolve:{
                    image_url: function(){
                        return $scope.question[created_image_url];
                    },
                    image_name: function(){
                        return $scope.question[created_image];
                    }
                }
            });
        }else{
            var editModal = $modal.open({
                templateUrl:'partials/modals/image_cropper_small.html',
                controller:'ImageCropperCtrl',
                windowClass:'classmodal modal_semiwide',
                backdrop:'static',
                resolve:{
                    image_url: function(){
                        return $scope.question[created_image_url];
                    },
                    image_name: function(){
                        return $scope.question[created_image];
                    }
                }
            });
        }

        editModal.result.then(function(new_created_image){
            $scope.question[question_type_image] = new_created_image;
            $scope.question[created_image] = new_created_image;
            $scope.question[created_image_url] = $rootScope.images_upload_url + new_created_image;
        });
    };

    $scope.saveClose = function(){
        $scope.data ={};
        $.extend( $scope.challenge,$scope.question);
        ContentBuilderResource.save($scope.challenge).$promise.then(function(response){
            $modalInstance.close(response.challenge, $scope.challenge.challenge_name);
        });
    };

    $scope.saveAddQuestion = function(){
        $scope.data ={};
        $.extend( $scope.challenge,$scope.question);
        ContentBuilderResource.save($scope.challenge).$promise.then(function(response){
            ModalService.add('add_new_question');
            $modalInstance.close(response.challenge, $scope.challenge.challenge_name);
        });
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('dismiss');
    };

});