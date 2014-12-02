<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="<?php echo AssetHelper::cssUrl('main.css') ?>" rel="stylesheet">
</head>
<body>
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
<!--                                            <h3 style="color:#3D96D0;">Login<img src="--><?php //echo AssetHelper::imageUrl('logo.png') ?><!--" alt="Logo" class="pull-right"></h3>-->
                                            <h3 style="color: #FF720C; font-size: 30px; font-weight: normal; line-height: 36px;" class="clearfix">
                                                <span style="float: left; height: 40px; width: 40px; overflow: hidden; margin-right: 10px;">
                                                    <img src="http://teacher.classcompete.com/logo-new.png" alt="Logo" class="pull-left" style="max-width: inherit;">
                                                </span>
                                                Log-In Admin Portal
                                            </h3>
                                            <p>Fill out the form below to login.</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="content">
                                    <div class="row-fluid control-group">
                                        <div class="span6">
                                            <input class="input span12" type="text" name="username" id="username" value="" placeholder="Username">
                                        </div>
                                        <div class="span6">
                                            <input class="input span12 password" placeholder="Password" type="password" name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="actions">
                                    <span class="info"><?php echo $this->session->flashdata('message');?></span>
                                    <button type="submit" class="btn btn-primary" name="Login" value="Login">Login </button>
                                    <a class="link" href="<?php echo base_url('auth/forgot_password')?>" data-original-title="">Forgot Password?</a>
                                    <a class="link" href="<?php echo base_url('auth/register')?>">Sign up</a>
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
</body>
</html>
