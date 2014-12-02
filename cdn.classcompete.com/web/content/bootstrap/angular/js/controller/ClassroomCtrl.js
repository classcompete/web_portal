angular.module('ccomp').controller('ClassroomCtrl',function($scope, $rootScope, $location, $modal,$q, ClassroomResource,StudentResource, ClassScoreResource){

    $rootScope.mainLoading = true;

    ClassroomResource.getAll().$promise.then(function(response){
        $scope.classrooms   =  response.class_list;
        $rootScope.mainLoading = false;
    });

    ClassScoreResource.getClassAmountScore().$promise.then(function(response){
        $scope.class_statistic = response.class_statistic;
    });

    $scope.getStudents = function(class_id, event){
        if(event !== angular.undefined){
            event.stopPropagation();
        }
        StudentResource.getStudents({class:class_id}).$promise.then(function(data){
            $scope.students = data.students;
            $scope.number_of_students = data.students_count;
        });
    };

    $scope.getStudentStatChallenges = function(class_id, event){
        if(angular.isUndefined(event))event.stopPropagation();

        var studentModalChallengeInformation = $modal.open({
            templateUrl:'partials/modals/student_challenge_class_information.html',
            controller:'ModalStudentChallengeClassInfo',
            windowClass:'modal_wide classmodal',
            resolve:{
                class_id:function(){
                    return class_id;
                }
            }
        });
    };

    $scope.changePassword = function(index,student){
        var modalChangeStudentPwdCtrl = $modal.open({
            templateUrl:'partials/modals/change_password.html',
            controller:'ModalChangeStudentPwdController',
            windowClass:'classmodal',
            backdrop:'static',
            resolve:{
                id:function(){
                    return $scope.students[index].student_id;
                }
            }
        });

        modalChangeStudentPwdCtrl.result.then(function(){
            toastr.success($scope.students[index].first_name + ' ' + $scope.students[index].last_name,'Password is changed!');
        });
    };

    $scope.removeStudent = function(class_id, student_index){
        var modalRemoveInstance = $modal.open({
            templateUrl:'partials/modals/yes_no.html',
            controller:'ModalRemoveController',
            windowClass:'classmodal',
            resolve:{
                title: function(){
                    return "Remove student";
                },
                message: function(){
                    return "Are you sure you want to remove student from class?";
                }
            }
        });

        modalRemoveInstance.result.then(function(){
            StudentResource.deleteStudent({id:$scope.students[student_index].student_id},{class:class_id}).$promise.then(function(){
                toastr.success($scope.students[student_index].first_name + ' ' + $scope.students[student_index].last_name, 'Successfully deleted from class!');
                $scope.students.splice(student_index,1);
                $scope.number_of_students --;
            });
        });
    };

    $scope.addEditClass = function(index, event){
        event.stopPropagation();
        var modalInstance = $modal.open({
            templateUrl: 'partials/modals/add_edit_class.html',
            controller: 'ModalAddEditClassController',
            windowClass:'classmodal',
            persist:true,
            backdrop:'static',
            resolve: {
                classroom: function(){
                    if(index === angular.undefined){
                        return null;
                    }else{
                        return angular.copy($scope.classrooms[index]);
                    }
                },
                title: function(){
                    if(index === null){
                        return 'Add new Class';
                    }else{
                        return 'Edit Class';
                    }
                }
            }
        });

        modalInstance.result.then(function(new_classroom){
            if(index === null){
                    $scope.classrooms.push(new_classroom);
                    toastr.success(new_classroom.name, "New class is created!");
            }
            else{
                $scope.classrooms[index] = new_classroom;
                toastr.success(new_classroom.name, "Class data is updated!");
            }
        });
    };

    $scope.studentInformation = function(class_id, student_id){
        var studentModalInformation = $modal.open({
            templateUrl:'partials/modals/student_information.html',
            controller:'ModalStudentInformation',
            resolve:{
                classroom: function(){
                    return class_id;
                },
                student: function(){
                    return student_id;
                }
            }
        });
    };
});

angular.module('ccomp').controller('ModalAddEditClassController', function($scope, $modalInstance, title, classroom, ClassroomCodeResource,ClassroomResource,ErrorService){

    $scope.ErrorService = ErrorService;
    $scope.title = title;
    if(classroom === angular.undefined){
        $scope.new_class = {};
        ClassroomCodeResource.get().$promise.then(function(data){
            $scope.new_class.class_code =  data.class_code;
        });
    }
    else $scope.new_class = classroom;

    $scope.add = function(form){
        var $my_form = $('#'+form.$name);
        $my_form.validate(function($form, e){
           if(angular.isDefined(e)){
                ClassroomResource.save($scope.new_class).$promise.then(function(data){
                    $modalInstance.close(data)
                });
           }
        });
    };

    $scope.cancel = function(){
        ErrorService.clearError();
        $modalInstance.dismiss('cancel');
    };
});
angular.module('ccomp').controller('ModalChangeStudentPwdController', function($scope, $modalInstance, StudentResource, ErrorService, id){

    $scope.ErrorService = ErrorService;
    $scope.student = {};
    $scope.student.id = id;

    $scope.ok = function(){
        StudentResource.edit(this.student).$promise.then(function(data){
            $modalInstance.close();
        });
    };

    $scope.cancel = function (){
        ErrorService.clearError();
        $modalInstance.dismiss('close')
    };

});
angular.module('ccomp').controller('ModalRemoveController', function($scope,$modalInstance,title, message){
    $scope.title    = title
    $scope.message  = message;

    $scope.ok = function(){
        $modalInstance.close();
    };
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };
});
angular.module('ccomp').controller('ModalStudentInformation',function($scope,$filter, $modalInstance, StudentResource, ClassScoreResource, classroom, student){

    $scope.sortingOrder = 'date';
    $scope.reverse = false;
    $scope.filteredData = [];
    $scope.groupedDate = [];
    $scope.itemsPerPage = 5;
    $scope.viewPerPage = [{per_page:5},{per_page:10},{per_page:15}];
    $scope.selectedItemsPerPage = $scope.viewPerPage[0];
    $scope.pagedData = [];
    $scope.currentPage = 0;
    $scope.query = '';

    StudentResource.getStudentData({id:student}).$promise.then(function(data){
        $scope.student_info   =   data.student_info;
    });

    ClassScoreResource.getChallengeScore({student_id:student, class_id:classroom}).$promise.then(function(data){
        $scope.table_info       = data.stats;
        $scope.search();
    });

    ClassScoreResource.getChallengeGlobalScore({student_id:student, class_id:classroom}).$promise.then(function(data){
        $scope.chartData = data.chart_data;
    });

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(){
        $scope.filteredData = $filter('filter')($scope.table_info, function(item){
            for(var attr in item){
                if(searchMatch(item[attr], $scope.query)){
                    return true;
                }
            }
            return false;
        });

        if($scope.sortingOrder !== ''){
            $scope.filteredData = $filter('orderBy')($scope.filteredData, $scope.sortingOrder, $scope.reverse);
        }

        $scope.currentPage = 0;
        $scope.groupToPages();
    };

    $scope.groupToPages = function(){
      $scope.pagedData = [];
      for(var i = 0; i < $scope.filteredData.length; i++){
          if(i % $scope.itemsPerPage === 0){
              $scope.pagedData[Math.floor(i/$scope.itemsPerPage)] = [$scope.filteredData[i]];
          }else{
              $scope.pagedData[Math.floor(i/$scope.itemsPerPage)].push($scope.filteredData[i]);
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
        if($scope.currentPage < $scope.pagedData.length - 1){
            $scope.currentPage++;
        }
    };

    $scope.setPage = function(){
      $scope.currentPage = this.n;
    };

    $scope.sort_by = function(newSortOrder){
        if($scope.sortingOrder == newSortOrder){
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortingOrder = newSortOrder;
        $scope.search();

        $('th').each(function(){
            $(this).removeClass('sorting_desc sorting_asc').addClass('sorting');
        });
        if($scope.reverse){
            $('th.'+newSortOrder).removeClass('sorting sorting_asc').addClass('sorting_desc');
        }else{
            $('th.'+newSortOrder).removeClass('sorting sorting_desc').addClass('sorting_asc');
        }
    };

    $scope.changeItemPerPage = function(itemsPerPage){
        $scope.itemsPerPage = itemsPerPage.per_page;
        $scope.search();
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    }
});
angular.module('ccomp').controller('ModalStudentChallengeClassInfo', function($scope,$modalInstance, class_id, ChallengeScoreResource){

    ChallengeScoreResource.getStudentsScoreChallengesByClass({class_id:class_id}).$promise.then(function(response){
        $scope.chartData = response.chart_data;
        console.log($scope.chartData);
    });


    $scope.cancel = function(){
        $modalInstance.dismiss('dismiss');
    };
});