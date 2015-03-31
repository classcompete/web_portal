<!DOCTYPE html>
<html lang="en" id="modernizrcom" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Teachers Panel Login | Educational Games To Improve Grades And Lower Test Anxiety | Class Compete</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, minimal-ui">
    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="touch-icon.png">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic' rel='stylesheet'
          type='text/css'>
    <link rel="stylesheet" href="/assets/v2/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/v2/assets/css/jquery.sudo-notify.css">
    <link rel="stylesheet" href="/assets/v2/assets/css/main.css?<?php echo time() ?>">
    <script src="/assets/v2/assets/js/libs/modernizr.js"></script>
</head>
<body>
<div class="notification-container"></div>
<header>
    <div class="wrapper clearfix">
        <a href="/" class="logo">ClassCompete</a>

        <div class="login-box">
            <a href="#" class="mobile-nav"><span>Login</span></a>

            <form id="login-form" method="post">
                <ul>
                    <li>
                        <input type="text" placeholder="Email/Username" name="username">
                    </li>
                    <li>
                        <input type="password" placeholder="Password" name="password">
	                    <span class="forgot-pass">
		                    <a href="/auth/forgot-password">Forgot password?</a>
	                    </span>
                    </li>
                    <li>
                        <button type="submit">Teacher Login</button>
                    </li>
                </ul>
            </form>

        </div>
    </div>
</header>

<div class="wrapper content clearfix">

    <div class="reg-form centered-form">

        <h2>Teacher password recovery</h2>
	    <br/>
	    <p>Hello <?php echo $full_name . ' (' . $email . ')' ?></p>
        <p>Enter your new password twice and you are done.</p>

        <form id="recovery-form" method="post">
	        <input type="hidden" name="token" value="<?php echo $token ?>">
            <ul>
                <li>
                    <input type="password" placeholder="Your new password (minimum 6 characters)" name="password">
                </li>
                <li>
                    <input type="password" placeholder="Confirm password" name="confirm_password">
                </li>
                <li class="clearfix">
                    <button class="do-recovery right" type="submit">Set password</button>
                </li>
            </ul>
        </form>

    </div> <!-- / Reg form -->
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>window.jQuery || document.write("<script src='assets/js/libs/jquery-1.11.1.min.js'>\x3C/script>")</script>
<script type="text/javascript" src="/assets/v2/assets/js/libs/jquery.sudo-notify.js"></script>

<!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="/assets/v2/assets/js/libs/selectivizr-min.js"></script>
<![endif]-->

<script src="/assets/v2/assets/js/init.js"></script>
<?php include_once dirname(__FILE__) . '/../compete_common/analytics.php' ?>
</body>
</html>