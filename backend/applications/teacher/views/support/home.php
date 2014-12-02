<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget">
                    <div class="widget-header">
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
                    <div class="widget-header">
                        <div class="title">Ask a question</div>
                    </div>
                    <div class="widget-body clearfix">
                        <form action="<?php echo site_url('support/sendMail')?>" method="post">
                            <ul>
                                <li style="position: relative" class="row-fluid">
                                    <input type="text" name="name" placeholder="Name" style="width: 95%">
                                    <span class="required" style="position: absolute; top: 2px; right: 0px; font-size: 26px; color: #DD2222">*</span>
                                </li>
                                <li style="position: relative" class="row-fluid">
                                    <input type="email" name="email" placeholder="Email" style="width: 95%">
                                    <span class="required" style="position: absolute; top: 2px; right: 0px; font-size: 26px; color: #DD2222">*</span>
                                </li>
                                <li style="position: relative" class="row-fluid">
                                    <textarea name="message" style="width: 95%" placeholder="Comments box"></textarea>
                                    <span class="required" style="position: absolute; top: 2px; right: 0px; font-size: 26px; color: #DD2222">*</span>
                                </li>
                                <li style="position: relative" class="row-fluid">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-right: 5%; float: right">Send</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Start Competing Now</div>
                    </div>
                    <div class="widget-body clearfix">
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
        </div>
        <div class="row-fluid">

        </div>
    </div>
</div>
<?php if ($_GET['sent'] === 'ok'): ?>
<script type="text/javascript">
    setTimeout(function(){
        alert("Your message has been sent.\nPlease be patient, someone will reply to your email as soon as possible.");
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