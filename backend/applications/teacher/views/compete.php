<!DOCTYPE html>
<!--[if lt IE 7]>

<html class="lt-ie9 lt-ie8 lt-ie7" lang="en">

<![endif]-->
<!--[if IE 7]>

<html class="lt-ie9 lt-ie8" lang="en">

<![endif]-->
<!--[if IE 8]>

<html class="lt-ie9" lang="en">

<![endif]-->
<!--[if gt IE 8]>
<!-->

<html lang="en">

<!--
<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Class Compete - Teacher Panel</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
    <!-- bootstrap css -->
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <link rel="stylesheet" href="<?php echo site_url('assets/icomoon/style.css') ?>"/>
    <!--[if lte IE 7]>
    <script src="<?php echo AssetHelper::commonUrl('icomoon-font/lte-ie7.js')?>"></script>
    <![endif]-->
    <link href="<?php echo AssetHelper::cssUrl('wysiwyg/bootstrap-wysihtml5.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('wysiwyg/wysiwyg-color.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('main.css?' . time())?>" rel="stylesheet"> <!-- Important. For Theming change primary-color variable in main.css  -->
    <link href="<?php echo AssetHelper::cssUrl('charts-graphs.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('jquery.gritter.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('jquery.powertip.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('jquery_ui/jquery-ui-1.10.3.min.css') ?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('bootstrap-slider.css')?>" rel="stylesheet">

    <script src="<?php echo AssetHelper::jsUrl('jquery.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery-ui-1.10.3.custom.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.bootstrap.wizard.js?' . time()) ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.dataTables.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.gritter.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.powertip.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.easy-pie-chart.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('bootstrap-slider.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jscolor/jscolor.js') ?>"></script>

    <script src="<?php echo AssetHelper::jsUrl('wysiwyg/wysihtml5-0.3.0.js') ?>"></script>

    <script src="<?php echo AssetHelper::jsUrl('bootstrap.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('wysiwyg/bootstrap-wysihtml5.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.scrollUp.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload-2.0.0/jquery.plupload.queue/jquery.plupload.queue.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload-2.0.0/plupload.full.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('../../vendor/plupload-2.0.0/jquery.ui.plupload/jquery.ui.plupload.min.js') ?>"></script>

    <script>
        var BASEURL = '<?php echo base_url() ?>';
	    var CURR_USER_ID = '<?php echo TeacherHelper::getUserId() ?>';
    </script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="<?php echo AssetHelper::jsUrl('init/models.js?' . time()) ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('tiny-scrollbar.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('init/legacy.js?' . time()) ?>"></script>

    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        //google.setOnLoadCallback(challenges_class_statistic);
    </script>

</head>
<body>
<?php $this->load->view(config_item('teacher_template') . '_common/header.php') ?>
<div class="container-fluid">
    <div class="dashboard-container">
        <?php $this->load->view(config_item('teacher_template') . '_common/menu.php') ?>

        <?php echo @$content ?>
    </div>
</div>
<?php if(TeacherHelper::viewIntro() !== PropTeacherPeer::VIEW_INTRO_TRUE): ?>
    <?php $this->load->view('simple-modal'); ?>
<?php endif ?>
<?php $this->load->view(config_item('teacher_template') . '_common/footer.php') ?>