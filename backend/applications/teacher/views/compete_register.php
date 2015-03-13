<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ClassCompete - Teacher panel Registration</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
    <link href="<?php echo AssetHelper::cssUrl('main.css') ?>" rel="stylesheet">
    <link href="<?php echo AssetHelper::cssUrl('jquery_ui/jquery-ui-1.10.3.min.css') ?>" rel="stylesheet">
    <style type="text/css">
        .ui-autocomplete {
            max-height: 240px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
        }

            /* IE 6 doesn't support max-height
            * we use height instead, but this forces the menu to always be this tall
            */
        * html .ui-autocomplete {
            height: 240px;
        }
    </style>

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
                        <?php echo form_open('auth/process_register', array('id' => 'registration_form', 'class' => 'login-wrapper', 'method' => 'POST')) ?>
                        <div class="header">
                            <div class="row-fluid">
                                <div class="span12">
                                    <h3 style="color: #FF720C; font-size: 30px; font-weight: normal; line-height: 36px;" class="clearfix">
                                        <span style="float: left; height: 40px; width: 40px; overflow: hidden; margin-right: 10px;">
                                            <img src="http://teacher.classcompete.com/logo-new.png" alt="Logo" class="pull-left" style="max-width: inherit;">
                                        </span>
                                        Teacher Registration
                                    </h3>

                                    <p>Fill out the form below to make an account.</p>
                                </div>
                            </div>

                        </div>
                        <div class="content clearfix">
                            <div class="control-group span12 margin_left_0">
                                <div class="controls span6">
                                    <input class="input span10" type="text" name="username" id="username"
                                           placeholder="Username" tabindex="1"/>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>
                                <div class="controls span6">
                                    <input class="input span10 password" placeholder="Password" type="password"
                                           id="password" name="password" tabindex="5"/>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group span12 margin_left_0">
                                <div class="controls span6">
                                    <input class="input span10" placeholder="First name" type="text" name="first_name"
                                           id="first_name" tabindex="2"/>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>
                                <div class="controls span6">
                                    <input class="input span10 password" placeholder="Repeat password" type="password"
                                           id="re_password" name="re_password" tabindex="6"/>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group span12 margin_left_0">
                                <div class="controls span6">
                                    <input class="input span10" placeholder="Last name" type="text" name="last_name"
                                           id="last_name" tabindex="3"/>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>
                                <div class="controls span6">

                                    <input class="input span10" type="text" placeholder="Type zip code" id="zip_code"
                                           name="zip_code" tabindex="7"/>
                                </div>
                            </div>
                            <div class="control-group span12 margin_left_0">
                                <div class="controls span6">
                                    <input class="input span10" type="text" placeholder="Email" name="email"
                                           id="email" tabindex="4"/>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>

                                <div class="controls span6">
                                    <input type="hidden" id="school_id" name="school_id">
                                    <input class="input span10 password" placeholder="Type your school name" type="text"
                                           id="school_name" name="school_name" tabindex="8"/>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>
                            </div>

                            <div class="control-group span12 margin_left_0">
                                <div class="controls span6">
                                    <select class="span10" name="country" id="country">
                                        <option>Country</option>
                                        <?php foreach ($countryList as $country): ?>
                                        <option value="<?php echo $country->getIso2Code()?>"><?php echo $country->getName()?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <span>*</span>
                                    <span class="help-inline"></span>
                                </div>
                                <div class="controls span6 register_not_listed">
                                    <label>
                                        <input id="not_listed" type="checkbox" name="not_listed" tabindex="9">My school is not listed
                                    </label>
                                    <span class="help-inline"></span>
                                </div>
                            </div>

                            <div class="control-group grade_holder_registration">
                                <div class="controls clearfix">
                                    <span class="help-inline" style="font-size: 14px; padding-left: 0px;">Select grades you are teaching</span>
                                </div>
                                <div class="controls grade_holder clearfix">
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[-2]"/>Pre - K
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[-1]"/>K
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[1]"/>Grade 1
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[2]"/>Grade 2
                                    </label>
                                </div>
                                <div class="controls grade_holder clearfix">
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[3]"/>Grade 3
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[4]"/>Grade 4
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[5]"/>Grade 5
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[6]"/>Grade 6
                                    </label>
                                </div>
                                <div class="controls grade_holder clearfix">
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[7]"/>Grade 7
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[8]"/>Grade 8
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[9]"/>High School
                                    </label>
                                    <label class="span3">
                                        <input class="input" type="checkbox" name="grade[10]"/>Higher ED
                                    </label>

                                </div>
                            </div>
                            <div class="control-group register_accept">
                                <label>
                                    <input id="terms_and_policy" type="checkbox" name="terms_and_policy">
                                    I accept <a href="http://www.classcompete.com/privacy-policy-terms-conditions/" target="_blank">Terms and Conditions</a>
                                    & <a href="http://www.classcompete.com/privacy-policy-terms-conditions/" target="_blank">Privacy Policy</a>
                                </label>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="actions">
                            <span>* required</span>
                            <button class="btn btn-primary" name="register" id="teacher_register">Sign up</button>
                            <a class="link" href="<?php echo base_url('auth/forgot_password')?>" data-original-title="">Forgot Password?</a>
                            <a class="link" href="<?php echo base_url('auth/login')?>">Sign in</a>
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
