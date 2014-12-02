angular.module('ccomp').controller('StatisticReportCtrl', function ($scope, $location){

});
angular.module('ccomp').controller('StudentStatClassChallenge',function($scope, $filter, ClassroomResource, StudentResource, StudentStatResource){

    $scope.sortingOrder = 'challenge_name';
    $scope.reverse = false;
    $scope.filteredAverageChallenges = [];
    $scope.groupedAverageChallenges = [];
    $scope.viewPerPage = [{per_page:5},{per_page:10},{per_page:15}];
    $scope.selectedAverageChallengePerPage = $scope.viewPerPage[0];
    $scope.averageChallengesPerPage = $scope.viewPerPage[0].per_page;
    $scope.pagedAverageChallenges = [];
    $scope.currentPage = 0;
    $scope.query_averageChallenges = '';
    $scope.searchCollapsed = true;
    $scope.filterCollapsed = true;

    ClassroomResource.getAll().$promise.then(function(response){
        $scope.classrooms = response.class_list;
        $scope.selectedClassroom = $scope.classrooms[0];

        StudentResource.getStudents({class:$scope.selectedClassroom.class_id}).$promise.then(function(response){
            $scope.students = response.students;
            $scope.selectedStudent = $scope.students[0];

            StudentStatResource.getStudentStatDetailChallenge({class_id:$scope.selectedClassroom.class_id,student_id:$scope.selectedStudent.student_id}).$promise.then(function(response){
                $scope.average_challenges = response.average_data;

                $scope.search();
            });
        });
    });

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(page){
        $scope.filteredAverageChallenges = $filter('filter')($scope.average_challenges, function(item){
            if(searchMatch(item['challenge_name'], $scope.query_averageChallenges)){
                return true;
            }
        });

        if($scope.sortingOrder !== ''){
            $scope.filteredAverageChallenges = $filter('orderBy')($scope.filteredAverageChallenges, $scope.sortingOrder, $scope.reverse);
        }

        if(page !== angular.undefined){
            $scope.currentPage = page;
        }else
            $scope.currentPage = 0;

        $scope.groupToPages();
    };

    $scope.groupToPages = function(){
        $scope.pagedAverageChallenges = [];
        for(var i = 0; i < $scope.filteredAverageChallenges.length; i++){
            if(i % $scope.averageChallengesPerPage === 0){
                $scope.pagedAverageChallenges[Math.floor(i/$scope.averageChallengesPerPage)] = [$scope.filteredAverageChallenges[i]];
            }else{
                $scope.pagedAverageChallenges[Math.floor(i/$scope.averageChallengesPerPage)].push($scope.filteredAverageChallenges[i]);
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
        if($scope.currentPage < $scope.pagedAverageChallenges.length - 1){
            $scope.currentPage++;
        }
    };

    $scope.setPage = function(){
        $scope.currentPage = this.n;
    };

    $scope.changeItemPerPage = function(itemsPerPage){
        $scope.averageChallengesPerPage = itemsPerPage.per_page;
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

    $scope.sort_by = function(newSortOrder){
        if($scope.sortingOrder == newSortOrder){
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortingOrder = newSortOrder;
        $scope.search($scope.currentPage);

        $('th').each(function(){
            $(this).removeClass('sorting_desc sorting_asc').addClass('sorting');
        });
        if($scope.reverse){
            $('th.'+newSortOrder).removeClass('sorting sorting_asc').addClass('sorting_desc');
        }else{
            $('th.'+newSortOrder).removeClass('sorting sorting_desc').addClass('sorting_asc');
        }
    };

    $scope.changeSelectedClassroom = function(selected_classroom){
        StudentResource.getStudents({class:selected_classroom.class_id}).$promise.then(function(response){
            $scope.students = response.students;
            $scope.selectedStudent = $scope.students[0];
            if(angular.isDefined($scope.selectedStudent)){
                StudentStatResource.getStudentStatDetailChallenge({class_id:$scope.selectedClassroom.class_id,student_id:$scope.selectedStudent.student_id}).$promise.then(function(response){
                    $scope.average_challenges = response.average_data;

                    $scope.search();
                });
            }
        });
    };

    $scope.changeSelectedStudent = function(selected_student){
        StudentStatResource.getStudentStatDetailChallenge({class_id:$scope.selectedClassroom.class_id,student_id:$scope.selectedStudent.student_id}).$promise.then(function(response){
            $scope.average_challenges = response.average_data;

            $scope.search();
        });
    };

});
angular.module('ccomp').controller('ChallengeStatPlayedTimes',function($scope, $filter,ChallengeStatResource){

    $scope.sortingOrder = 'challenge_name';
    $scope.reverse = false;
    $scope.filteredChallenges = [];
    $scope.groupedChallenges = [];
    $scope.viewPerPage = [{per_page:5},{per_page:10},{per_page:15}];
    $scope.selectedChallengePerPage = $scope.viewPerPage[0];
    $scope.challengesPerPage = $scope.viewPerPage[0].per_page;
    $scope.pagedChallenges = [];
    $scope.currentPage = 0;
    $scope.query_challenges = '';
    $scope.searchCollapsed = true;
    $scope.filterCollapsed = true;

    ChallengeStatResource.getChallengePlayedTimes().$promise.then(function(response){
        $scope.challenge_played_times = response.played_times;
        console.log($scope.challenge_played_times);
        $scope.search();
    });

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(page){
        $scope.filteredChallenges = $filter('filter')($scope.challenge_played_times, function(item){
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

    $scope.sort_by = function(newSortOrder){
        if($scope.sortingOrder == newSortOrder){
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortingOrder = newSortOrder;
        $scope.search($scope.currentPage);

        $('th').each(function(){
            $(this).removeClass('sorting_desc sorting_asc').addClass('sorting');
        });
        if($scope.reverse){
            $('th.'+newSortOrder).removeClass('sorting sorting_asc').addClass('sorting_desc');
        }else{
            $('th.'+newSortOrder).removeClass('sorting sorting_desc').addClass('sorting_asc');
        }
    };

});
angular.module('ccomp').controller('StudentStatChallenge',function($scope, $filter, $modal, ClassroomResource, StudentStatResource){
    $scope.filterCollapsed = true;
    $scope.searchCollapsed = true;
    $scope.sortingOrder = 'student_firstname';
    $scope.reverse = false;
    $scope.filteredStudent = [];
    $scope.groupedStudent = [];
    $scope.viewPerPage = [{per_page:5},{per_page:10},{per_page:15}];
    $scope.selectedStudentsPerPage = $scope.viewPerPage[0];
    $scope.studentsPerPage = $scope.viewPerPage[0].per_page;
    $scope.pagedStudentsChallengePlayTimes = [];
    $scope.currentPage = 0;
    $scope.query_students = '';

    ClassroomResource.getAll().$promise.then(function(response){
        $scope.classrooms = response.class_list;
        $scope.selectedClass = $scope.classrooms[0];

        StudentStatResource.getStudentChallengePlayedTimes({class_id:$scope.selectedClass.class_id}).$promise.then(function(response){
            $scope.students_played_times = response.students;
            $scope.search();
        });
    });

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(page){
        $scope.filteredStudent = $filter('filter')($scope.students_played_times, function(item){
            if(searchMatch(item['student_firstname'], $scope.query_students)){
                return true;
            }
        });

        if($scope.sortingOrder !== ''){
            $scope.filteredStudent = $filter('orderBy')($scope.filteredStudent, $scope.sortingOrder, $scope.reverse);
        }

        if(page !== angular.undefined){
            $scope.currentPage = page;
        }else
            $scope.currentPage = 0;

        $scope.groupToPages();
    };

    $scope.groupToPages = function(){
        $scope.pagedStudentsChallengePlayTimes = [];
        for(var i = 0; i < $scope.filteredStudent.length; i++){
            if(i % $scope.studentsPerPage === 0){
                $scope.pagedStudentsChallengePlayTimes[Math.floor(i/$scope.studentsPerPage)] = [$scope.filteredStudent[i]];
            }else{
                $scope.pagedStudentsChallengePlayTimes[Math.floor(i/$scope.studentsPerPage)].push($scope.filteredStudent[i]);
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
        if($scope.currentPage < $scope.pagedStudentsChallengePlayTimes.length - 1){
            $scope.currentPage++;
        }
    };

    $scope.setPage = function(){
        $scope.currentPage = this.n;
    };

    $scope.changeItemPerPage = function(itemsPerPage){
        $scope.studentsPerPage = itemsPerPage.per_page;
        $scope.search($scope.currentPage);
    };

    $scope.collapseFilters = function(type){
        switch (type){
            case 'search':
                $scope.searchCollapsed = !$scope.searchCollapsed;
                $scope.filterCollapsed = true;
                break;
            case 'filter':
                $scope.filterCollapsed = !$scope.filterCollapsed;
                break;
        }
    };

    $scope.sort_by = function(newSortOrder){
        if($scope.sortingOrder == newSortOrder){
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortingOrder = newSortOrder;
        $scope.search($scope.currentPage);

        $('th').each(function(){
            $(this).removeClass('sorting_desc sorting_asc').addClass('sorting');
        });
        if($scope.reverse){
            $('th.'+newSortOrder).removeClass('sorting sorting_asc').addClass('sorting_desc');
        }else{
            $('th.'+newSortOrder).removeClass('sorting sorting_desc').addClass('sorting_asc');
        }
    };

    $scope.changeClass = function(classrom){
        StudentStatResource.getStudentChallengePlayedTimes({class_id:classrom.class_id}).$promise.then(function(response){
            $scope.students_played_times = response.students;
            $scope.search($scope.currentPage);
        });
    };

    $scope.studentChallengeDetails = function(student){
        var studentChallengeInfo = $modal.open({
            templateUrl:'partials/modals/student_challenge_details.html',
            controller:'ModalStudentChallengeDetails',
            windowClass:'modal classmodal modal_wide',
            resolve:{
                student: function(){
                    return student;
                },
                classroom: function(){
                    return $scope.selectedClass.class_id;
                }
            }
        });
    };
});
angular.module('ccomp').controller('ModalStudentChallengeDetails', function($scope, $filter, $modalInstance, student, classroom, StudentStatResource){

    $scope.sortingOrder = 'challenge_name';
    $scope.reverse = false;
    $scope.filteredChallenge = [];
    $scope.groupedChallenge = [];
    $scope.viewPerPage = [{per_page:5},{per_page:10},{per_page:15}];
    $scope.selectedChallengePerPage = $scope.viewPerPage[0];
    $scope.challengesPerPage = $scope.viewPerPage[0].per_page;
    $scope.pagedChallenges = [];
    $scope.currentPage = 0;
    $scope.query = '';

    StudentStatResource.getStudentChallengePlayedTimesDetails({class_id:classroom,student_id:student}).$promise.then(function(response){
        $scope.challenges = response.challenges;

        $scope.search();
    });

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(page){
        $scope.filteredChallenge = $filter('filter')($scope.challenges, function(item){
            if(searchMatch(item['challenge_name'], $scope.query)){
                return true;
            }
        });

        if($scope.sortingOrder !== ''){
            $scope.filteredChallenge = $filter('orderBy')($scope.filteredChallenge, $scope.sortingOrder, $scope.reverse);
        }

        if(page !== angular.undefined){
            $scope.currentPage = page;
        }else
            $scope.currentPage = 0;

        $scope.groupToPages();
    };

    $scope.groupToPages = function(){
        $scope.pagedChallenges = [];
        for(var i = 0; i < $scope.filteredChallenge.length; i++){
            if(i % $scope.challengesPerPage === 0){
                $scope.pagedChallenges[Math.floor(i/$scope.challengesPerPage)] = [$scope.filteredChallenge[i]];
            }else{
                $scope.pagedChallenges[Math.floor(i/$scope.challengesPerPage)].push($scope.filteredChallenge[i]);
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
        $scope.search($scope.currentPage);
    };

    $scope.sort_by = function(newSortOrder){
        if($scope.sortingOrder == newSortOrder){
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortingOrder = newSortOrder;
        $scope.search($scope.currentPage);

        $('th').each(function(){
            $(this).removeClass('sorting_desc sorting_asc').addClass('sorting');
        });
        if($scope.reverse){
            $('th.'+newSortOrder).removeClass('sorting sorting_asc').addClass('sorting_desc');
        }else{
            $('th.'+newSortOrder).removeClass('sorting sorting_desc').addClass('sorting_asc');
        }
    };

    $scope.cancel = function(){
        $modalInstance.dismiss('dismiss');
    };

});