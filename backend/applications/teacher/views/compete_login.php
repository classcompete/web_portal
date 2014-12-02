<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ClassCompete - Teacher Panel Login</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link href="<?php echo AssetHelper::cssUrl('main.css') ?>" rel="stylesheet">
    <script src="<?php echo AssetHelper::jsUrl('jquery.min.js') ?>"></script>
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
                        <?php echo form_open('auth/process_login', array('id' => 'login', 'class' => 'login-wrapper', 'method' => 'POST')) ?>
                        <div class="header">
                            <div class="row-fluid">
                                <div class="span12">
                                    <h3 style="color:#3D96D0;" class="clearfix"><img src="<?php echo site_url('logo-new.png') ?>" alt="Logo" class="pull-left"></h3>
                                    <p>Fill out the form below to login.</p>
                                </div>
                            </div>

                        </div>
                        <div class="content">
                            <div class="row-fluid control-group">
                                <div class="span6">
                                    <input class="input span12" type="text" name="username" id="username" placeholder="Username"/>
                                </div>
                                <div class="span6">
                                    <input class="input span12 password" placeholder="Password" id="password" type="password" name="password"/>
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <span class="info"><?php echo $this->session->flashdata('message');?></span>
                            <button class="btn btn-primary" id="login_submit">Login</button>
                            <a class="link" href="<?php echo base_url('auth/forgot_password')?>" data-original-title="">Forgot Password?</a>

                            <div class="clearfix"></div>
                            <div style="text-align: center; display: block; margin: 20px auto;">
                                <span style="font-size: 16px; color: rgb(188, 188, 188);">Not a member yet?
                                    <a class="link" style="font-size: 16px; float: none; color: rgb(255, 148, 74);" href="<?php echo base_url('auth/register')?>">Join Now!</a></span>
                            </div>
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
