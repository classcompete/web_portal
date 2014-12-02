angular.module('ccomp').controller('QuestionCtrl', function($scope, $rootScope, $location, $filter, $routeParams, $modal, QuestionResource, ChallengeResource, ModalService){

    $rootScope.mainLoading = true;
    $scope.sortingOrder = 'question_name';
    $scope.reverse = false;
    $scope.searchCollapsed = true;
    $scope.filterCollapsed = true;
    $scope.filteredQuestions = [];
    $scope.groupedQuestions = [];
    $scope.viewPerPage = [{per_page:15},{per_page:30},{per_page:45}];
    $scope.selectedItemsPerPage = $scope.viewPerPage[0];
    $scope.questionsPerPage = 15;
    $scope.pagedQuestions = [];
    $scope.currentPage = 0;
    $scope.query_questions = '';


    QuestionResource.get({id:$routeParams.id}).$promise.then(function(data){
        $scope.questions = data.questions;
        $scope.search();
        $rootScope.mainLoading = false;

        var open_add_question_modal = ModalService.get();
        if(open_add_question_modal === 'add_new_question'){
            $scope.addNewQuestion();
            ModalService.remove();
        }
    });

    ChallengeResource.get({id:$routeParams.id}).$promise.then(function(response){
        $scope.challenge = response;
    });

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(page){
        $scope.filteredQuestions = $filter('filter')($scope.questions, function(item){
            if(searchMatch(item['question_name'], $scope.query_questions)){
                return true;
            }
        });

        if($scope.sortingOrder !== ''){
            $scope.filteredQuestions = $filter('orderBy')($scope.filteredQuestions, $scope.sortingOrder, $scope.reverse);
        }

        if(page !== angular.undefined){
            $scope.currentPage = page;
        }else
            $scope.currentPage = 0;

        $scope.groupToPages();
    };

    $scope.groupToPages = function(){
        $scope.pagedQuestions = [];
        for(var i = 0; i < $scope.filteredQuestions.length; i++){
            if(i % $scope.questionsPerPage === 0){
                $scope.pagedQuestions[Math.floor(i/$scope.questionsPerPage)] = [$scope.filteredQuestions[i]];
            }else{
                $scope.pagedQuestions[Math.floor(i/$scope.questionsPerPage)].push($scope.filteredQuestions[i]);
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
        if($scope.currentPage < $scope.pagedQuestions.length - 1){
            $scope.currentPage++;
        }
    };

    $scope.setPage = function(){
        $scope.currentPage = this.n;
    };

    $scope.changeItemPerPage = function(itemsPerPage){
        $scope.questionsPerPage = itemsPerPage.per_page;
        $scope.search();
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

    $scope.deleteQuestion = function(quesiton){
        var deleteQuestionModal = $modal.open({
            templateUrl:'partials/modals/yes_no.html',
            controller:'RemoveQuestionController',
            windowClass:'classmodal',
            backdrop:'static',
            resolve:{
                title:function(){
                    return 'Remove question';
                },
                message:function(){
                    return 'Are you sure you want to remove this question?'
                }
            }
        });

        deleteQuestionModal.result.then(function(){
            QuestionResource.delete({id:quesiton.question_id}).$promise.then(function(){
                toastr.success(quesiton.text,'Question has been deleted from class');
            });
        });
    };

    $scope.editQuestion = function(question){

        var editQuestionModal = $modal.open({
            templateUrl:'partials/modals/edit_question.html',
            controller:'EditQuestionController',
            windowClass:'classmodal modal_wide modal_top ',
            backdrop:'static',
            resolve: {
                question: function(){
                    return question.question_id;
                },
                challenge: function(){
                    return $scope.challenge;
                }
            }
        });

        editQuestionModal.result.then(function(){
            QuestionResource.get({id:$routeParams.id}).$promise.then(function(data){
                $scope.questions = data.questions;
                $scope.search();
                $rootScope.mainLoading = false;
                toastr.success('Question successfully edited');
            });
        });
    };

    $scope.addNewQuestion = function (){

        var addNewQuestionModal = $modal.open({
            templateUrl:'partials/modals/add_new_question.html',
            controller:'AddQuestionController',
            windowClass:'classmodal modal_wide modal_top',
            backdrop:'static',
            resolve:{
                challenge: function(){
                    return $scope.challenge;
                },
                parentScope: function(){
                    return $scope;
                }
            }
        });

        addNewQuestionModal.result.then(function(){
            QuestionResource.get({id:$routeParams.id}).$promise.then(function(data){
                $scope.questions = data.questions;
                $scope.search();
            });
            toastr.success('New question has been added!');
        });

    };
});
angular.module('ccomp').controller('RemoveQuestionController', function($scope, $modalInstance, title, message){

    $scope.title = title;
    $scope.message = message;

    $scope.ok = function(){
        $modalInstance.close();
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('close');
    };

});
angular.module('ccomp').controller('EditQuestionController', function ($scope,$rootScope, $modalInstance, $modal, question, challenge, QuestionResource){


    QuestionResource.getSingle({id:question}).$promise.then(function(response){
        $scope.question = response.question;
        console.log($scope.question);
    });

    $scope.new_question = {};

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

    $scope.edit = function(form){
        var $my_form = $('#'+form.$name);

        $my_form.validate(function($form, e){
            if(angular.isUndefined(e)){
                angular.forEach($form,function(val,key){
                    toastr.error(val.message);
                })
            }else{
               $scope.question.game_code = challenge.challenge_type;
               $scope.question.question_id = question;
               $scope.question.challenge = challenge.challenge_id;
               QuestionResource.edit($scope.question).$promise.then(function(response){
                   console.log('Response from put:');
                   console.log(response);
                   $modalInstance.close();
               });

               console.log($scope.question);
            }
        });
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('close');
    };

});

angular.module('ccomp').controller('AddQuestionController', function($scope, $rootScope, $modal, $modalInstance, challenge, parentScope,  QuestionResource){

    $scope.challenge_type = challenge.challenge_type;
    $scope.current_tab = [true,false];
    $scope.show_content = ['question_type','question'];
    $scope.active_tab = 0;
    $scope.question = {};

    $scope.changeTab = function(set_tab, question_type){
        $scope.current_tab[$scope.active_tab] = false;
        $scope.current_tab[set_tab] = true;
        $scope.active_tab = set_tab;
        $scope.selectedTab = $scope.show_content[set_tab];

        if(angular.isDefined(question_type)){
            $scope.question.question_type = question_type;
        }
    };

    $scope.saveClose = function(form){
        var $my_form = $('#'+form.$name);

        $my_form.validate(function($form, e){
            if(angular.isUndefined(e)){
                angular.forEach($form,function(val,key){
                    toastr.error(val.message);
                })
            }else{
                $scope.question.challenge = challenge.challenge_id;
                $scope.question.game_code = challenge.challenge_type;
                QuestionResource.save($scope.question).$promise.then(function(response){
                    $modalInstance.close();
                });
            }
        });
    };

    $scope.saveAddNewQuestion = function(form){
        var $my_form = $('#'+form.$name);

        console.log(form.$name);
        $my_form.validate(function($form, e){
            console.log($form);
            console.log(e);
            if(angular.isUndefined(e)){
                angular.forEach($form, function(val,key){
                    toastr.error(val.message)
                });
            }else{
                $scope.question.challenge = challenge.challenge_id;
                $scope.question.game_code = challenge.challenge_type;
                QuestionResource.save($scope.question).$promise.then(function(response){
                    $scope.question = {};
                    $scope.current_tab[$scope.active_tab] = false;
                    $scope.current_tab[0] = true;
                    $scope.active_tab = 0;
                    $scope.selectedTab = $scope.show_content[0];

                    QuestionResource.get({id:challenge.challenge_id}).$promise.then(function(data){
                        parentScope.questions = data.questions;
                        parentScope.search();
                    });

                    toastr.success('New question has been added!');
                });
            }
        });
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

    $scope.cancel = function(){
        $modalInstance.dismiss('close');
    };

});