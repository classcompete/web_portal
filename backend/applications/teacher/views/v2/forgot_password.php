<!DOCTYPE html>
<html lang="en" id="modernizrcom" class="no-js">
<head>
    <title>Teachers Panel Login | Educational Games To Improve Grades And Lower Test Anxiety | Class Compete</title>
	<?php $this->load->view('v2/common/head') ?>
</head>

<body>
<div class="notification-container"></div>
<header>
	<?php $this->load->view('v2/common/header') ?>
</header>

<div class="wrapper content clearfix">

    <div class="reg-form centered-form">

        <h2>Teacher password recovery</h2>
	    <br/>
        <p>Enter your email and we will send you a link to the page where you can enter your new password.</p>

        <form id="forgot-form" method="post">
            <ul>
                <li>
                    <input type="text" placeholder="Email" name="email">
                </li>
                <li>
	                <p><strong>Please note</strong> that link we send you will be accessible for 3 hours after we sent it to you. No need to hurry, but don't forget about it...</p>
                </li>
                <li class="clearfix">
                    <button class="do-send-link right" type="submit">Send me the link</button>
                </li>
            </ul>
        </form>

    </div> <!-- / Reg form -->
</div>

<?php $this->load->view('v2/common/scripts') ?>
<?php include_once dirname(__FILE__) . '/../compete_common/analytics.php' ?>
</body>
</html>