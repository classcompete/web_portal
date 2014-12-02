<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Class Compete Teacher Portal</title>
    <!--    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>-->
        <meta name="description" content="">
        <meta name="author" content="">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="<?php echo base_url('assets/icomoon/style.css') ?>"/>
        <link href="<?php echo AssetHelper::cssUrl('wysiwyg/bootstrap-wysihtml5.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('wysiwyg/wysiwyg-color.css')?>" rel="stylesheet">

        <link href="<?php echo AssetHelper::cssUrl('main.css')?>" rel="stylesheet"> <!-- Important. For Theming change primary-color variable in main.css  -->
        <link href="<?php echo AssetHelper::cssUrl('charts-graphs.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('jquery.gritter.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('jquery.powertip.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('jquery_ui/jquery-ui-1.10.3.min.css') ?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('bootstrap-slider.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('toastr.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('animation/animation.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('bootstrap-slider.css')?>" rel="stylesheet">
        <link href="<?php echo AssetHelper::cssUrl('colorpicker.css')?>" rel="stylesheet">
    </head>
    <body ng-controller="DefaultCtrl" id="ng-app" ng-app="ccomp">
        <header ng-show="user.logged" ng-include="header_tmpl.url" ng-cloak></header>
        <div id="container" class="container-fluid">
            <div class="dashboard-container"  ng-cloak>
                <div ng-show="user.logged" ng-include="menu_tmpl.url" ng-cloak></div>
                <div id="dashboard-wrapper" class="dashboard-wrapper" ng-cloak>
                        <div ng-show="mainLoading" class="loading-holder">
                            <img src="<?php echo AssetHelper::imageUrl('main_loader.gif');?>" style="width: 200px">
                        </div>
                        <div id="view-animate-slide" ng-view ng-cloak ng-show="!mainLoading" class="reveal-animation"></div>
                </div>
            </div>
            <footer ng-show="user.logged" ng-include="footer_tmpl.url" ng-cloak></footer>
        </div>
        <script src="<?php echo AssetHelper::jsUrl('jquery.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('jquery-ui-1.10.3.custom.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('bootstrap.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('bootstrap-slider.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('jquery.backstretch.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('jquery.powertip.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('tiny-scrollbar.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('canvasRender.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('easyPieChart.js') ?>"></script>
        <script src="<?php echo AssetHelper::jsUrl('jquery.sparkline.js') ?>"></script>

        <script src="<?php echo AssetHelper::angularJsUrl('lib/spin.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/toastr.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/TweenMax.min.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/validate.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('lib/validate_helper.js') ?>"></script>

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
            <script src="<?php echo AssetHelper::angularJsUrl('js/development/app.js') ?>"></script>
        <?php endif;?>
        <?php if(ENVIRONMENT === 'testing'):?>
            <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular.min.js') ?>"></script>
            <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-resource.min.js') ?>"></script>
            <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-animate.min.js') ?>"></script>
            <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-route.min.js') ?>"></script>
            <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/ui-bootstrap-tpls-0.6.0.min.js') ?>"></script>
            <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-resource.min.js') ?>"></script>
            <script src="<?php echo AssetHelper::angularJsUrl('lib/angular/angular-cookie.min.js') ?>"></script>

            <script src="<?php echo AssetHelper::angularJsUrl('js/testing/app.js') ?>"></script>
        <?php endif;?>

        <script src="<?php echo AssetHelper::angularJsUrl('js/services.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/AssignedChallengesCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/QuestionCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/ClassroomCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/ContentBuilderCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/DefaultCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/HomeCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/LoginCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/LoginErrorCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/PasswordRecoveryCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/RegistrationCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/MarketplaceCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/ProfileCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/BasicReportCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/StatisticReportCtrl.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/controller/ImageCropperCtrl.js') ?>"></script>

        <script src="<?php echo AssetHelper::angularJsUrl('lib/bootstrap-colorpicker-module.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/filters.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/directives.js') ?>"></script>
        <script src="<?php echo AssetHelper::angularJsUrl('js/angular-plupload.js') ?>"></script>
    </body>
</html>