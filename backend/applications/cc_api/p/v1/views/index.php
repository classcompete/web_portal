<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Class Compete Parent Portal</title>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="<?php echo base_url('assets/icomoon/style.css') ?>"/>
        <link href="<?php echo AssetHelper::cssUrl('wysiwyg/bootstrap-wysihtml5.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('wysiwyg/wysiwyg-color.css')?>" rel="stylesheet">

        <link href="<?php echo AssetHelper::cssUrl('parent/main.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('parent/animation.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('charts-graphs.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('jquery.gritter.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('jquery_ui/jquery-ui-1.10.3.min.css') ?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('toastr.css') ?>" rel="stylesheet">
        <style>
            .row-fluid .span12 {
                width: 97%;
            }
        </style>
    </head>
    <body ng-controller="DefaultCtrl" id="parent-app" ng-app="parent-app" ng-cloak>
    <header ng-show="user.logged" ng-include="header_tmpl.url" ng-cloak></header>
    <div id="container" class="container-fluid" ng-cloak>
        <div class="dashboard-container"  ng-cloak>
            <div ng-show="user.logged" ng-include="menu_tmpl.url" ng-cloak></div>
            <div id="dashboard-wrapper" class="dashboard-wrapper" ng-cloak>
                <div ng-show="mainLoading" class="loading-holder" ng-cloak>
                    <img src="<?php echo AssetHelper::imageUrl('main_loader.gif');?>" style="width: 200px">
                </div>
                <div id="view-animate-slide" ng-view ng-cloak ng-show="!mainLoading" class="reveal-animation"></div>
            </div>
        </div>
        <footer ng-show="user.logged" ng-include="footer_tmpl.url" ng-cloak></footer>
    </div>
    <div ng-show="user.logged" class="feedback-wrapper" ng-cloak>
        <a href="http://www.classcompete.com/pilots/" target="_blank" class="btn btn-block btn-info feedback-subwrapper">
            <div class="feedback">Feedback</div>
        </a>
    </div>
    <script src="https://apis.google.com/js/client:plusone.js"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery-ui-1.10.3.custom.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('bootstrap.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.backstretch.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::angularJsUrl('lib/validate.js') ?>"></script>
    <script src="<?php echo AssetHelper::angularJsUrl('lib/validate_helper.js') ?>"></script>
    <script src="<?php echo AssetHelper::angularJsUrl('lib/toastr.js') ?>"></script>

    <script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload-2.0.0/jquery.plupload.queue/jquery.plupload.queue.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload-2.0.0/plupload.full.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload-2.0.0/jquery.ui.plupload/jquery.ui.plupload.min.js') ?>"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <?php if(ENVIRONMENT === 'development'):?>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-resource.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-animate.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-route.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/ui-bootstrap-tpls-0.6.0.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-resource.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-cookie.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/development/app.js') ?>"></script>
    <?php endif;?>
    <?php if(ENVIRONMENT === 'testing' || ENVIRONMENT === 'production'):?>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-resource.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-animate.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-route.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/ui-bootstrap-tpls-0.6.0.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-resource.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-cookie.min.js') ?>"></script>

        <script src="<?php echo AssetHelper::parentJsUrl('js/' . ENVIRONMENT . '/app.js') ?>"></script>
    <?php endif;?>


        <script src="<?php echo AssetHelper::parentJsUrl('js/services.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/DefaultCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/LoginCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/RegistrationCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/LoginErrorCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/ForgotPasswordCtrl.js')?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/ChildrenCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/ProfileCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/SocialNetworkConCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/controller/ManageChildrenCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/filters.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/directives.js') ?>"></script>
        <script src="<?php echo AssetHelper::parentJsUrl('js/angular-plupload.js') ?>"></script>

        <script src="<?php echo AssetHelper::angularJsUrl('lib/angular-easyfb.js') ?>"></script>
<!--        <script src="--><?php //echo AssetHelper::parentJsUrl('js/linkedin.js') ?><!--"></script>-->
<!--        <script src="http://platform.linkedin.com/in.js">-->
<!--            api_key: 77t4gt76tfngii-->
<!--            onLoad: onLinkedInLoad-->
<!--        </script>-->

    </body>
</html>