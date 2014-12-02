<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ClassCompete - Error</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link href="<?php echo AssetHelper::cssUrl('main.css') ?>" rel="stylesheet">
    <script src="<?php echo AssetHelper::jsUrl('jquery.min.js') ?>"></script>
</head>

<body style="background-color: #DDD">
<?php $error = $this->session->flashdata('error'); ?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-body">
                <div class="span3">&nbsp;</div>
                <div class="span6">
                    <div class="sign-in-container">
                        <div class="login-wrapper">
                            <div class="header">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <h3 style="color: #FF720C; font-size: 30px; font-weight: normal; line-height: 36px;" class="clearfix">
                                                <span style="float: left; height: 40px; width: 40px; overflow: hidden; margin-right: 10px;">
                                                    <img src="http://teacher.classcompete.com/logo-new.png" alt="Logo" class="pull-left" style="max-width: inherit;">
                                                </span>
                                            Teacher login error
                                        </h3>
                                    </div>
                                </div>

                            </div>
                            <div class="content">
                                <div class="row-fluid control-group">
                                    <div class="span12">
                                        <p>Whooops! looks like something did not work correctly. If you are having issues
                                            please <a href="mailto:support@classcompete.com"
                                                      style="text-decoration: underline">email us</a> or please "Return
                                            to try again"</p>
                                        <?php if (empty($error) === false): ?>
                                            <?php foreach ($error as $msg): ?>
                                                <p style="color: red"><?php echo $msg ?></p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="actions">
                                <a class="link" href="<?php echo base_url('auth/login') ?>">Return to try again</a>

                                <div class="clearfix"></div>
                            </div>
                        </div>
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
<?php $this->load->view(config_item('teacher_template') . '_common/analytics.php') ?>
</body>
</html>
