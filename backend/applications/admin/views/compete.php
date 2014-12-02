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
    <title>Class Compete - Admin Homepage</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
    <!-- bootstrap css -->
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <link rel="stylesheet" href="<?php echo site_url('assets/icomoon/style.css') ?>"/>
    <!--[if lte IE 7]>
    <script src="<?php echo AssetHelper::commonUrl('icomoon-font/lte-ie7.js')?>"></script>
    <![endif]-->
    <link href="<?php echo AssetHelper::cssUrl('wysiwyg/bootstrap-wysihtml5.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('wysiwyg/wysiwyg-color.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('main.css')?>" rel="stylesheet"> <!-- Important. For Theming change primary-color variable in main.css  -->
    <link href="<?php echo AssetHelper::cssUrl('charts-graphs.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('jquery.gritter.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('jquery.powertip.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('bootstrap-datepicker.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('bootstrap-slider.css')?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('jquery_ui/jquery-ui-1.10.3.min.css') ?>" rel="stylesheet">

    <script src="<?php echo AssetHelper::jsUrl('jquery.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery-ui-1.10.3.custom.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.bootstrap.wizard.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.powertip.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('bootstrap-datepicker.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('bootstrap-slider.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jscolor/jscolor.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.dataTables.js') ?>"></script>
    <script>
        var BASEURL = '<?php echo base_url() ?>';
    </script>
    <script src="<?php echo AssetHelper::jsUrl('jquery.gritter.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('admin/controller/model.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('admin/init.js?653g') ?>"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load('visualization', '1.0', {'packages':['corechart']});
    </script>

</head>
<body>
<?php $this->load->view(config_item('admin_template') . '_common/header.php') ?>
<div class="container-fluid">
    <div class="dashboard-container">
        <?php $this->load->view(config_item('admin_template') . '_common/menu.php') ?>

        <?php echo @$content ?>
    </div>
</div>

<?php $this->load->view(config_item('admin_template') . '_common/footer.php') ?>