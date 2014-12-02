<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ClassCompete - Teacher panel password recovery</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link href="<?php echo AssetHelper::cssUrl('main.css') ?>" rel="stylesheet">
    <script src="<?php echo AssetHelper::jsUrl('jquery.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('jquery-ui-1.10.3.min.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('admin/controller/model.js') ?>"></script>
    <script src="<?php echo AssetHelper::jsUrl('auth/auth.js') ?>"></script>
    <script type="text/javascript">
        var BASEURL = '<?php echo base_url() ?>';
    </script>
</head>
<body style="background-color: #DDD">
    <?php $this->load->view(config_item('teacher_template') . '_common/analytics.php') ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-body">
                    <div class="span3">&nbsp;</div>
                    <div class="span6">
                        <div class="sign-in-container">
                            <?php echo form_open('auth/reset_password', array('id' => 'reset_password', 'class' => 'login-wrapper', 'method' => 'POST')) ?>
                                <div class="header">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <h3 style="color: #FF720C; font-size: 30px; font-weight: normal; line-height: 36px;" class="clearfix">
                                                <span style="float: left; height: 40px; width: 40px; overflow: hidden; margin-right: 10px;">
                                                    <img src="http://teacher.classcompete.com/logo-new.png" alt="Logo" class="pull-left" style="max-width: inherit;">
                                                </span>
                                                Teacher password recovery
                                            </h3>
                                        </div>
                                    </div>

                                </div>
                                <div class="content">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <input class="input span12" type="text" name="email" id="email" value="" placeholder="Email">
                                        </div>
                                    </div>
                                    <span class="error"></span>

                                </div>
                                <div class="actions">
                                    <button id="reset" type="button" class="btn btn-primary" name="Reset" value="Reset">Reset</button>
                                    <a class="link" href="<?php echo base_url('auth/login')?>" data-original-title="">Go back</a>
                                    <div class="clearfix"></div>
                                </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="span3">&nbsp;</div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo AssetHelper::jsUrl('jquery.backstretch.min.js') ?>"></script>
    <script type="text/javascript">
        $.backstretch('http://cdn.classcompete.com/images/kids-bg-1.jpg');
    </script>
</body>
</html>
