function onLinkedInLoad() {
    IN.Event.on(IN, "auth", function() {
        onLinkedInLogin();
    });
    IN.Event.on(IN, "logout", function() {
        onLinkedInLogout();
    });
}

//execute on logout event
function onLinkedInLogout() {
//    location.reload(true);
}

//execute on login event
function onLinkedInLogin() {
    // pass user info to angular
    if(document.getElementById("social_connection_grant") !== null){
        angular.element(document.getElementById("social_connection_grant")).scope().$apply(
            function($scope) {
                $scope.getLinkedInData();
            }
        );
    }else{
        angular.element(document.getElementById("login")).scope().$apply(
            function($scope) {
                $scope.getLinkedInDataLogin();
            }
        );
    }
}