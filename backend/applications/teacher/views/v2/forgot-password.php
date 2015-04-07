<!DOCTYPE html>
<html lang="en" id="modernizrcom" class="no-js">
<head>
    <title>Teachers Panel Login | Educational Games To Improve Grades And Lower Test Anxiety | Class Compete</title>
    <meta name="description" content="">
    <?php $this->load->view('v2/common/head') ?>
</head>
<body>
<div class="notification-container"></div>
<header>
    <?php $this->load->view('v2/common/header') ?>
</header>

<div class="wrapper content clearfix">
    <div class="reg-form forgot-password">
        <h2>Teacher Password Recovery</h2>

        <p>Enter your email and we will send you new password.</p>

        <form id="recovery-form" method="post">
            <ul>
                <li>
                    <input type="text" placeholder="Email" name="email">
                </li>
                <li>
                    <button class="do-recover right" type="submit">Resend</button>
                </li>
            </ul>
        </form>
    </div>
</div>

<?php $this->load->view('v2/common/scripts') ?>
<?php include_once dirname(__FILE__) . '/../compete_common/analytics.php' ?>
</body>
</html>