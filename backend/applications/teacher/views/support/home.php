<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget">
                    <div class="widget-header yellow">
                        <div class="title">FAQ</div>
                    </div>
                    <div class="widget-body clearfix">
                        <div class="accordion no-margin mod-classes" id="accordion1">
                            <?php foreach ($questions as $key => $question): ?>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse"
                                       data-parent="#accordion1"
                                       href="#collapse-<?php echo $key ?>" data-original-title=""
                                       id="faq-<?php echo $key ?>">
                                        <?php echo $question['question'] ?>
                                    </a>
                                </div>
                                <div style="height: 0px;" id="collapse-<?php echo $key ?>"
                                     class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        <p style="font-size: 13px;">
                                            <?php echo $question['answer'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget">
                    <div class="widget-header green">
                        <div class="title">Ask a question</div>
                    </div>
                    <div class="widget-body clearfix">
                        <form action="<?php echo site_url('support/sendMail')?>" method="post">
                            <ul>
                                <li style="position: relative" class="row-fluid">
                                    <label>Full Name <small>(required)</small></label>
                                    <input type="text" name="name" placeholder="" style="width: 95%" value="<?php echo $user->getFirstName() .' '.$user->getLastName()?>">
                                </li>
                                <li style="position: relative" class="row-fluid">
                                    <label>Email <small>(required)</small></label>
                                    <input type="email" name="email" placeholder="" style="width: 95%" value="<?php echo $user->getEmail()?>">
                                </li>
                                <li style="position: relative" class="row-fluid">
                                    <label>Question <small>(required)</small></label>
                                    <textarea name="message" style="width: 95%" placeholder=""></textarea>
                                </li>
                                <li style="position: relative" class="row-fluid">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-right: 5%; float: right">Send</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-header blue">
                        <div class="title">Student Game</div>
                    </div>
                    <div class="widget-body clearfix">

                        <p style="font-size: 16px; padding: 10px">
                            Create a student account and use a free code to try it
                        </p>

	                    <div class="wrapper" style="background: none;">
	                        <div class="row-fluid">
	                            <div class="span6">
	                                <div class="widget">
	                                    <div class="widget-header blue">
	                                        <div class="title"><span data-icon=""></span>  Step 1 - Register</div>
	                                    </div>
	                                    <div class="widget-body">

					                        <ul class="start-competing-list box">
					                            <li>
					                                <a class="app-store" target="_blank" href="http://bit.ly/1iHxsW6">
					                                    Available on the <b>App Store</b>
					                                </a>
					                            </li>
					                            <li>
					                                <a class="google-play" target="_blank" href="http://bit.ly/1gPwpix">
					                                    Android App on <b><em>Google</em> Play</b>
					                                </a>
					                            </li>
					                            <br>
					                            <li>
					                                <a class="pc-mac" target="_blank" href="http://bit.ly/1idscos">
					                                    Available on <b>PC &amp; Mac</b>
					                                </a>
					                            </li>
					                            <li>
					                                <a class="kindle" target="_blank" href="http://amzn.to/1icY3f1">
					                                    Available on <b>Amazon kindle</b>
					                                </a>
					                            </li>
					                        </ul>

	                                    </div>
	                                </div>
	                            </div>

                                <div class="span6">
	                                <div class="widget">
	                                    <div class="widget-header blue">
	                                        <div class="title"><span data-icon="&#xe0a4;"></span>  Step 2 - Sample Code</div>
	                                    </div>
	                                    <div class="widget-body">

				                            <?php for ($i = 1; $i <= 8; $i++): ?>
				                                    <h5>
				                                        Grade <?php echo $i ?> <span style="font-weight: normal">Code - </span>
				                                        <strong
				                                            style="font-size: 15px; color: #ed6d49">trymath<?php echo $i ?></strong>
				                                    </h5>
				                            <?php endfor ?>

	                                    </div>
	                                </div>
	                            </div>

	                        </div>
	                    </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">

        </div>
    </div>
</div>
<?php if (@$_GET['sent'] === 'ok'): ?>
<script type="text/javascript">
    setTimeout(function(){
        alert("Your message has been sent.\nPlease be patient, someone will reply to your email as soon as possible.");
    }, 250);
</script>
<?php endif ?>
<?php if (isset($_GET['error']) && empty($_GET['error']) === false): ?>
    <script type="text/javascript">
        setTimeout(function(){
            alert("<?php echo $_GET['error']?>");
        }, 250);
    </script>
<?php endif ?>
<style>
    .start-competing-list {
        padding: 10px;
        position: relative;
        text-align: center;
        background: none repeat scroll 0 0 #fff;
        border: 1px solid rgba(0, 0, 0, 0.09);
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.19);
        box-sizing: border-box;
    }
    .start-competing-list:before {
        bottom: -20px;
        content: "";
        display: block;
        height: 20px;
        left: 0;
        position: absolute;
        width: 100%;
    }
    .start-competing-list li {
        display: inline-block;
        margin: 10px;
        width: 230px;
    }
    .start-competing-list li a.app-store {
        background-position: 0 0;
    }
    .start-competing-list li a.google-play {
        background-position: 0 -60px;
    }
    .start-competing-list li a b {
        color: #fff;
        display: block;
        font-size: 24px;
        font-weight: 400;
        line-height: 24px;
    }
    .start-competing-list li a {
        background-color: #7c8390;
        background-image: url("http://parent.classcompete.com/app/images/icons-start-competing.png");
        background-repeat: no-repeat;
        border-radius: 3px;
        color: rgba(255, 255, 255, 0.6);
        display: block;
        font-size: 14px;
        height: 52px;
        overflow: hidden;
        padding: 8px 25px 0 70px;
        text-align: left;
        width: 135px;
    }
    .start-competing-list li a.pc-mac {
        background-position: 0 -120px;
    }
    .start-competing-list li a.kindle {
        background: url("http://parent.classcompete.com/app/images/amazon_kindle.jpg") no-repeat scroll center center / contain #79818c;
        text-indent: -9999px;
    }
</style>
<style type="text/css">
    .dashboard-wrapper .left-sidebar .widget .widget-header.yellow {
        background-color: #ffb400;
        /* Fallback Color */
        background-image: -webkit-gradient(linear, left top, left bottom, from(#ffb400), to(#eda602));
        /* Saf4+, Chrome */
        background-image: -webkit-linear-gradient(top, #ffb400, #eda602);
        /* Chrome 10+, Saf5.1+, iOS 5+ */
        background-image: -moz-linear-gradient(top, #ffb400, #eda602);
        /* FF3.6 */
        background-image: -ms-linear-gradient(top, #ffb400, #eda602);
        /* IE10 */
        background-image: -o-linear-gradient(top, #ffb400, #eda602);
        /* Opera 11.10+ */
        background-image: linear-gradient(top, #ffb400, #eda602);
    }

    .dashboard-wrapper .left-sidebar .widget .widget-header.blue {
        background-color: #0daed3;
        /* Fallback Color */
        background-image: -webkit-gradient(linear, left top, left bottom, from(#0daed3), to(#34A1BA));
        /* Saf4+, Chrome */
        background-image: -webkit-linear-gradient(top, #0daed3, #34A1BA);
        /* Chrome 10+, Saf5.1+, iOS 5+ */
        background-image: -moz-linear-gradient(top, #0daed3, #34A1BA);
        /* FF3.6 */
        background-image: -ms-linear-gradient(top, #0daed3, #34A1BA);
        /* IE10 */
        background-image: -o-linear-gradient(top, #0daed3, #34A1BA);
        /* Opera 11.10+ */
        background-image: linear-gradient(top, #0daed3, #34A1BA);
    }

    .dashboard-wrapper .left-sidebar .widget .widget-header.green {
        background-color: #74b749;
        /* Fallback Color */
        background-image: -webkit-gradient(linear, left top, left bottom, from(#74b749), to(#79A35D));
        /* Saf4+, Chrome */
        background-image: -webkit-linear-gradient(top, #74b749, #79A35D);
        /* Chrome 10+, Saf5.1+, iOS 5+ */
        background-image: -moz-linear-gradient(top, #74b749, #79A35D);
        /* FF3.6 */
        background-image: -ms-linear-gradient(top, #74b749, #79A35D);
        /* IE10 */
        background-image: -o-linear-gradient(top, #74b749, #79A35D);
        /* Opera 11.10+ */
        background-image: linear-gradient(top, #74b749, #79A35D);
    }

    .dashboard-wrapper .left-sidebar .widget .widget-header.red {
        background-color: #ed6d49;
        /* Fallback Color */
        background-image: -webkit-gradient(linear, left top, left bottom, from(#ed6d49), to(#CC755D));
        /* Saf4+, Chrome */
        background-image: -webkit-linear-gradient(top, #ed6d49, #CC755D);
        /* Chrome 10+, Saf5.1+, iOS 5+ */
        background-image: -moz-linear-gradient(top, #ed6d49, #CC755D);
        /* FF3.6 */
        background-image: -ms-linear-gradient(top, #ed6d49, #CC755D);
        /* IE10 */
        background-image: -o-linear-gradient(top, #ed6d49, #CC755D);
        /* Opera 11.10+ */
        background-image: linear-gradient(top, #ed6d49, #CC755D);
    }

    .dashboard-wrapper .left-sidebar .widget .widget-header.red .title,
    .dashboard-wrapper .left-sidebar .widget .widget-header.green .title,
    .dashboard-wrapper .left-sidebar .widget .widget-header.yellow .title,
    .dashboard-wrapper .left-sidebar .widget .widget-header.blue .title {
        color: #FFF;
    }
</style>