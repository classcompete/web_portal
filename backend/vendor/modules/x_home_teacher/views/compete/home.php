<div class="dashboard-wrapper">

    <div class="left-sidebar">

        <?php /*
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="row-fluid">
                            <div class="metro-nav">
                                <div class="metro-nav-block nav-block-orange margin_bottom_0">
                                    <a data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $total_teacher_studetns ?></div>
                                        <div class="brand">Total Students</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-yellow margin_bottom_0">
                                    <a href="<?php echo base_url('classes') ?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $total_classes ?></div>
                                        <div class="brand">Total Classes</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-blue double margin_bottom_0">
                                    <a href="<?php echo base_url('marketplace') ?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon="&#xe0a4;"></div>
                                        <div class="info"><?php echo $challenges_in_market ?></div>
                                        <div class="brand">Total Challenges</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-green margin_bottom_0">
                                    <a href="<?php echo base_url('reporting/basic') ?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"></div>
                                        <div class="brand">Reports</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-red margin_bottom_0">
                                    <a href="<?php echo base_url('support') ?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon="&#xe03b;"></div>
                                        <div class="info"></div>
                                        <div class="brand">Support</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> */ ?>

        <div class="row-fluid">
            <div class="span3">
                <div class="widget">
                    <div class="widget-header yellow">
                        <div class="title"><span data-icon="&#xe021;"></span> Step 1</div>
                    </div>
                    <div class="widget-body">
                        <a href="/classes">
                            <h4>
                                Create a Classroom
                            </h4>

                            <p style="font-size: 14px; min-height: 100px">
                                Give the <strong>Code</strong> you create to students so they will see challenges
                                you assign to the classroom
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="widget">
                    <div class="widget-header blue">
                        <div class="title"><span data-icon="&#xe0a4;"></span> Step 2</div>
                    </div>
                    <div class="widget-body">
                        <a href="/marketplace">
                            <h4>Assign Challenges</h4>

                            <p style="font-size: 14px; min-height: 100px">
                                Filter by Grade, or Subject, or Topic and assign a challenge to classroom
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="widget">
                    <div class="widget-header green">
                        <div class="title"><span data-icon=""></span> Step 3</div>
                    </div>
                    <div class="widget-body">
                        <a href="/support">
                            <h4>Tell Students to Play</h4>

                            <p style="font-size: 14px; min-height: 100px">
                                Students can login to the game and when they use your code,
                                will see the challenges you assigned and can compete against others
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="widget">
                    <div class="widget-header red">
                        <div class="title"><span data-icon="&#xe097;"></span> Step 4</div>
                    </div>
                    <div class="widget-body">
                        <a href="/reporting/basic">
                            <h4>Monitor Results</h4>

                            <p style="font-size: 14px; min-height: 100px">
                                Click a classroom and see individual student and classroom results and adjust
                                challenges accordingly
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title" style="width: 50%">Want to try as student?</div>
                    </div>
                    <div class="widget-body">
                        <p style="font-size: 16px;">Register as student and enter the following trial codes</p>

                        <div class="row-fluid">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <div class="span3">
                                    <h5>
                                        Grade <?php echo $i ?> <span style="font-weight: normal">Code- </span>
                                        <strong
                                            style="font-size: 15px; color: #ed6d49">trymath<?php echo $i ?></strong>
                                    </h5>
                                </div>
                            <?php endfor ?>
                        </div>
                        <div class="row-fluid">
                            <?php for ($i = 5; $i <= 8; $i++): ?>
                                <div class="span3">
                                    <h5>
                                        Grade <?php echo $i ?> <span style="font-weight: normal">Code- </span>
                                        <strong
                                            style="font-size: 15px; color: #ed6d49">trymath<?php echo $i ?></strong>
                                    </h5>
                                </div>
                            <?php endfor ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-sidebar">
            <div class="wrapper">
                <div class="overview">
                    <div class="featured-articles-container featured-articles-container">
                        <h5 class="heading">Video Support</h5>

                        <div>
                            <a href="#" data-toggle="modal" data-target="#introVideo">
                                <img src="http://i.ytimg.com/vi/krsBMGULJKw/mqdefault.jpg"/>
                            </a>
                            <br/><br/>
                        </div>
                        <h5 class="heading">Class Compete Overview</h5>

                        <div class="articles">
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('classes') ?>">Setup Classroom</a>
                            </a>
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('marketplace') ?>">Lookup Challenges in Marketplace</a>
                            </a>
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('marketplace') ?>">Assign Challenges to Classroom</a>
                            </a>
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('reporting/basic') ?>">Watch the Results!!!</a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal hide fade" id="introVideo" tabindex="-1" role="dialog"
         style="width: 830px; margin-left: -415px; top:5px" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        How to use ClassCompete?
                    </div>
                </div>
                <div class="widget-body">
                    <iframe src="//www.youtube.com/embed/krsBMGULJKw?rel=0" frameborder="0" allowfullscreen=""
                            width="800" frameborder="0" height="600"></iframe>
                </div>
            </div>
        </div>
    </div>
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