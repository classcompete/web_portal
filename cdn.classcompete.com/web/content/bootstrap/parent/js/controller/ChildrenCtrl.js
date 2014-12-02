angular.module('parent-app').controller('ChildrenCtrl', function($scope, $rootScope, $filter, ChildResource, ClassResource, ChildStatResource){
    $rootScope.mainLoading = true;
    $scope.searchCollapsed = true;
    $scope.filterCollapsed = true;
    $scope.sortingOrder = 'date';
    $scope.reverse = false;
    $scope.filteredData = [];
    $scope.groupedDate = [];
    $scope.itemsPerPage = 15;
    $scope.viewPerPage = [{per_page:5},{per_page:10},{per_page:15}];
    $scope.selectedItemsPerPage = $scope.viewPerPage[0];
    $scope.pagedData = [];
    $scope.currentPage = 0;
    $scope.query = '';

    ChildResource.get().$promise.then(function(response){
        $scope.childrens = response.child;
        if($scope.childrens.length < 1){
            $rootScope.mainLoading = false;
            return;
        }
        $scope.selectedChild = $scope.childrens[0];
        $scope.loadingTableData = true;
        ClassResource.getClasses({id:$scope.selectedChild.student_id}).$promise.then(function(response){
            if(angular.isDefined(response.classes[0])){
                $scope.classes = response.classes;
                $scope.selected_classroom = $scope.classes[0];
                ChildStatResource.getChallengeScore({student_id:$scope.selectedChild.student_id,class_id:$scope.selected_classroom.class_id }).$promise.then(function(response){
                    $scope.table_info       = response.stats;
                    $scope.search();
                    ChildStatResource.getChallengeGlobalScore({student_id:$scope.selectedChild.student_id, class_id:$scope.selected_classroom.class_id}).$promise.then(function(global_stat_response){
                        $scope.global_challenge_score = global_stat_response.chart_data;
                        $scope.loadingTableData = false;
                    });
                });
            }else{
                $rootScope.mainLoading = false;
                $scope.emptyClasses = true;
            }
        });
        $rootScope.mainLoading = false;
    });

    $scope.changeChild = function(index){
        if($scope.selectedChild === $scope.childrens[index])return;
        $scope.loadingTableData = true;
        $scope.classes = {};
        $scope.selectedChild = $scope.childrens[index];

        ClassResource.getClasses({id:$scope.childrens[index].student_id}).$promise.then(function(response){
            if(response.classes[0] === undefined){
                $scope.table_info = {};
                $scope.classes = null;
                $scope.loadingTableData = false;
                return;
            }
            $scope.classes = response.classes;
            $scope.selected_classroom = $scope.classes[0];

            ChildStatResource.getChallengeScore({student_id:$scope.childrens[index].student_id,class_id:$scope.selected_classroom.class_id}).$promise.then(function(response){
                $scope.table_info       = response.stats;
                $scope.search();
                ChildStatResource.getChallengeGlobalScore({student_id:$scope.selectedChild.student_id, class_id:$scope.selected_classroom.class_id}).$promise.then(function(global_stat_response){
                    $scope.global_challenge_score = global_stat_response.chart_data;
                    $scope.loadingTableData = false;
                });
            });
        });
    };

    $scope.changeClass = function(){
        $scope.loadingTableData = true;
        ChildStatResource.getChallengeScore({student_id:$scope.selectedChild.student_id,class_id:$scope.selected_classroom.class_id}).$promise.then(function(response){
            $scope.query = '';
            $scope.table_info       = response.stats;
            $scope.search();
            ChildStatResource.getChallengeGlobalScore({student_id:$scope.selectedChild.student_id, class_id:$scope.selected_classroom.class_id}).$promise.then(function(global_stat_response){
                $scope.global_challenge_score = global_stat_response.chart_data;
                $scope.loadingTableData = false;
            });
        });
    };

    var searchMatch = function(haystack, needle){
        if(!needle){return true}
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
    };

    $scope.search = function(){
        $scope.filteredData = $filter('filter')($scope.table_info, function(item){
            for(var attr in item){
                if(searchMatch(item['challenge_name'], $scope.query)){
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

    $scope.collapseFilters = function(type){
        switch (type){
            case 'search':
                if($scope.table_info.length == 0)return;
                $scope.searchCollapsed = !$scope.searchCollapsed;
                $scope.filterCollapsed = true;
                break;
            case 'filter':
                if($scope.classes.length == 0)return;
                $scope.searchCollapsed = true;
                $scope.filterCollapsed = !$scope.filterCollapsed;
                break;
        }
    };
});