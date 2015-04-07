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

    <div class="reg-form">

        <h2>Teacher Registration</h2>

        <p>It’s free and always will be.</p>

        <form id="signup-form" method="post">
            <ul>
                <li class="clearfix">
                    <span class="half left"><input type="text" placeholder="First Name" name="first_name"></span>
                    <span class="half right"><input type="text" placeholder="Last Name" name="last_name"></span>
                </li>
                <li>
                    <input type="text" placeholder="Email" name="email">
                </li>
                <li>
                    <input type="password" placeholder="Password (minimum 6 characters)" name="password">
                </li>
                <li>
                    <p>By clicking Register, you agree to our
                        <a href="http://www.classcompete.com/privacy-policy-terms-conditions/#termsandconditions"
                           target="_blank">
                            Terms and Conditions
                        </a> &
                        <a href="http://www.classcompete.com/privacy-policy-terms-conditions/#privacypolicy"
                           target="_blank">
                            Privacy Policy
                        </a>
                    </p>
                </li>
                <li>
                    <button class="do-register" type="submit">Register</button>
                </li>
            </ul>
        </form>

    </div>
    <!-- / Reg form -->

    <div class="reg-info">

        <h3>Why Teachers Need Class Compete?</h3>

        <ul>
            <li>
                <img src="/assets/v2/pictures/icon-reduce.png" alt="Reduces Test Anxiety">
                <h4>Reduces Test Anxiety</h4>

                <p>Students develop the skills and confidence they need to successfully take timed academic tests.</p>
            </li>
            <li>
                <img src="/assets/v2/pictures/icon-scores.png" alt="Higher Scores">
                <h4>Higher Scores</h4>

                <p>Research shows scores significantly improved after only 10 trials!</p>
            </li>
            <li>
                <img src="/assets/v2/pictures/icon-kidslove.png" alt="Kids Love Our Game">
                <h4>Kids Love Our Game</h4>

                <p>We’ve leveraged game-based learning theory to create a positive learning environment.</p>
            </li>
            <li>
                <img src="/assets/v2/pictures/icon-bettertest.png" alt="A Better Test">
                <h4>A Better Test</h4>

                <p>We’ve gamified testing, unlocking its true power as a learning tool.</p>
            </li>
        </ul>

    </div>
    <!-- / Reg info -->

</div>

<?php $this->load->view('v2/common/scripts') ?>
<?php include_once dirname(__FILE__) . '/../compete_common/analytics.php' ?>
</body>
</html>