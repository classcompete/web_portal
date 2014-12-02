var directives = angular.module('parent-app.directives',[]);

directives.directive('bsNavbar', ['$location',function ($location) {
    return {
        restrict: 'A',
        link: function postLink(scope, element, attrs, controller) {
            scope.$watch(function () {
                return $location.path();
            }, function (newValue, oldValue) {
                $('a[data-match-route]', element).each(function (k, li) {
                    var $li = angular.element(li), pattern = $li.attr('data-match-route'), regexp = new RegExp('^' + pattern + '$', ['i']);
                    if(pattern.search(newValue) >= 0){
                        $li.addClass('selected');
                    }else{
                        $li.removeClass('selected');
                    }
                });
            });
        }
    };
}]);
directives.directive('imageLoader', function(){
    return {
        restrict: 'A',
        link: function(scope, elem, attrs){
            if(angular.isDefined(scope.image_changed)){
                scope.user.parent_image  = scope.user.parent_image + '?decache=' + Math.random();
                scope.parent.image_thumb = scope.parent_image + '?decache='+ Math.random();
            }
        }
    }
});
directives.directive('imageonload',function(){
    return{
        restrict:'A',
        link:function(scope,elem,attrs){
            elem.bind('load',function(){
                if(angular.isDefined(attrs.ngSrc)){
                    scope.uploadingProfileImage = false;
                    scope.$apply();
                }
            });
        }
    }
});
directives.directive('triggerChange',function($sniffer){
    return {
        link : function(scope, elem, attrs) {
            elem.bind('click', function(){
                $(attrs.triggerChange).trigger($sniffer.hasEvent('input') ? 'input' : 'change');
            });
        },
        priority : 1
    }
});
directives.directive('dashboardstyleadd',function(){
    return{
        restrict:'A',
        link:function(scope, elem, attrs){
            angular.element('#dashboard-wrapper').addClass('dashboard-wrapper');
            angular.element('#view-animate-container').addClass('view-animate-container');
            angular.element('.backstretch').hide();
        }
    }
});
directives.directive('dashboardstyleremove',function(){
    return{
        restrict:'A',
        link:function(scope, elem, attrs){
            angular.element('#view-animate-container').removeClass('view-animate-container');
            angular.element('#dashboard-wrapper').removeClass('dashboard-wrapper');
        }
    }
});
directives.directive('googleconnect', function($window){
    return{
        restrict:'A',
        link: function(scope,elem,attrs){
            scope.$watch('avaiable_social_networks',function(){
                if(angular.isDefined(scope.avaiable_social_networks) && scope.avaiable_social_networks.google.added === false){
                    var scripts = document.getElementsByTagName('script'),
                        scriptsL = scripts.length;
                    for (var i=0; i<scriptsL; ++i) {
                        if (scripts[i].src = 'https://apis.google.com/js/client:plusone.js') {
                            (function() {
                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                po.src = 'https://apis.google.com/js/client:plusone.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                            })();
                            scripts[i].remove();
                            break;
                        }
                    }
                }
            });

            $window.googleConnectCallback = function (authResult) {
                if(authResult && authResult.access_token){
                    scope.$broadcast('event:google-plus-connect-success',authResult);
                }
                else{
                    scope.$broadcast('event:google-plus-connect-failure',authResult);
                }
            };
        }

    }
});
directives.directive('facebookconnect',function($window){
    return {
        restrict:'A',
        link:function(scope, elem, attrs){

            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '225058110951151',
                    status     : true, // check login status
                    cookie     : true, // enable cookies to allow the server to access the session
                    xfbml      : true  // parse XFBML
                });

                // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
                // for any authentication related change, such as login, logout or session refresh. This means that
                // whenever someone who was previously logged out tries to log in again, the correct case below
                // will be handled.
                FB.Event.subscribe('auth.authResponseChange', function(response) {
                    // Here we specify what we do with the response anytime this event occurs.
                    if (response.status === 'connected') {
                        // The response object is returned with a status field that lets the app know the current
                        // login status of the person. In this case, we're handling the situation where they
                        // have logged in to the app.
                        testAPI();
                    } else if (response.status === 'not_authorized') {
                        // In this case, the person is logged into Facebook, but not into the app, so we call
                        // FB.login() to prompt them to do so.
                        // In real-life usage, you wouldn't want to immediately prompt someone to login
                        // like this, for two reasons:
                        // (1) JavaScript created popup windows are blocked by most browsers unless they
                        // result from direct interaction from people using the app (such as a mouse click)
                        // (2) it is a bad experience to be continually prompted to login upon page load.
                        FB.login();
                    } else {
                        // In this case, the person is not logged into Facebook, so we call the login()
                        // function to prompt them to do so. Note that at this stage there is no indication
                        // of whether they are logged into the app. If they aren't then they'll see the Login
                        // dialog right after they log in to Facebook.
                        // The same caveats as above apply to the FB.login() call here.
                        FB.login();
                    }
                });
                FB.Event.subscribe('auth.login', function(response) {
                    return false;
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    return false;
                });
            };

            // Load the SDK asynchronously
            (function(d){
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = "//connect.facebook.net/en_US/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));

            // Here we run a very simple test of the Graph API after login is successful.
            // This testAPI() function is only called in those cases.
            function testAPI() {
                FB.api('/me', function(response) {
                    scope.$apply(function(){
                        scope.$broadcast('event:facebook-connect-success',response);
                    });
                });
            }

        }
    }
});
directives.directive('googlesignin',['$window','ParentAppSettings',function($window,ParentAppSettings){
    return{
        restrict:'A',
        controller:function($scope){
            $scope.google_login = function(){
                gapi.auth.signIn({
                    'clientid' : ParentAppSettings.googleId,
                    'cookiepolicy' : 'single_host_origin',
                    'callback' : 'googleSigninCallback',
                    'data-cookiepolicy':"single_host_origin",
                    'scope':"https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read"
                })
            };

            $window.googleSigninCallback = function (authResult) {
                if(authResult && authResult.access_token){
                    $scope.$broadcast('event:google-plus-sign-success',authResult);
                }
                else{
                    $scope.$broadcast('event:google-plus-sign-failure',authResult);
                }
            };
        }
    }
}]);
directives.directive('googlesignup',['$window', 'ParentAppSettings',function($window,ParentAppSettings){
    return{
        restrict:'A',
        controller:function($scope){
            $scope.google_register = function(){
                gapi.auth.signIn({
                    'clientid' : ParentAppSettings.googleId,
                    'cookiepolicy' : 'single_host_origin',
                    'callback' : 'googleSignupCallback',
                    'data-cookiepolicy':"single_host_origin",
                    'scope':"https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read"
                })
            };

            $window.googleSignupCallback = function (authResult) {
                if(authResult && authResult.access_token){
                    $scope.$broadcast('event:google-plus-signup-success',authResult);
                }
                else{
                    $scope.$broadcast('event:google-plus-signup-failure',authResult);
                }
            };
        }
    }
}]);
//directives.directive('linkedinconnect', function(){
//    return{
//        restrict:'A',
//        link:function(scope, elem, attrs){
//            $('#linkedinconnect').append("<script type='IN/Login'>Hello, <?js= firstName ?> <?js= lastName ?>.</script>");
//
//            if(IN.parse){
//                IN.parse(document.getElementById('linkedinconnect'));
//            }
//        }
//    }
//});
//directives.directive('linkedinlogin', function(){
//    return{
//        restrict:'A',
//        link:function(scope, elem, attrs){
//            $('#linkedinlogin').append("<script type='IN/Login'>Hello, <?js= firstName ?> <?js= lastName ?>.</script>");
//
//            if(IN.parse){
//                IN.parse(document.getElementById('linkedinlogin'));
//            }
//        }
//    }
//});
directives.directive('googleChart', function () {
    return {
        restrict: 'A',
        link: function ($scope, $elm, $attr) {
            $scope.$watch($attr.data, function (value) {
                if(angular.isUndefined(value))return;
                var stats       = value.stats;
                var head_stats  = value.head_stats;
                var data        = new google.visualization.DataTable();
                var g_height      = 160;
                var g_width       = 'auto';

                if(angular.isDefined($attr.height)){g_height = $attr.height;}
                if(angular.isDefined($attr.width)){g_width = $attr.width;}

                angular.forEach(head_stats, function(val,key){
                    data.addColumn(val.type,val.value);
                });

                angular.forEach(stats, function (row,key) {
                    var p_arr = [];
                    angular.forEach(row,function(val,key){
                        p_arr.push(val);
                    });
                    data.addRow(p_arr);
                });

                var color_set = ['#ed6d49', '#0daed3', '#ffb400', '#74b749', '#f63131'];
                var options = {
                    height: g_height,
                    width: g_width,
                    backgroundColor: 'transparent',
                    colors: color_set,
                    tooltip: {
                        textStyle: {
                            color: '#666666',
                            fontSize: 11
                        },
                        showColorCode: true
                    },
                    legend: {
                        textStyle: {
                            color: 'black',
                            fontSize: 12
                        }
                    },
                    chartArea: {
                        left: 60,
                        top: 10,
                        height: '80%'
                    },
                    vAxis: {
                        baseline: 0
                    }
                };
                var chart;
                switch ($attr.type) {
                    case ('PieChart'):
                        chart = new google.visualization.PieChart($elm[0]);
                        break;
                    case ('ColumnChart'):
                        chart = new google.visualization.ColumnChart($elm[0]);
                        break;
                    case ('BarChart'):
                        chart = new google.visualization.BarChart($elm[0]);
                        break;
                    case ('Table'):
                        chart = new google.visualization.Table($elm[0]);
                        break;
                }
                chart.draw(data, options);
            });
        }
    }
});