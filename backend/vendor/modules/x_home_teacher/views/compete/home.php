<div class="dashboard-wrapper">

    <div class="left-sidebar">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="row-fluid">
                            <div class="metro-nav">
                                <div class="metro-nav-block nav-block-orange margin_bottom_0">
                                    <a data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $total_teacher_studetns?></div>
                                        <div class="brand">Total Students</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-yellow margin_bottom_0">
                                    <a href="<?php echo base_url('classes')?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $total_classes?></div>
                                        <div class="brand">Total Classes</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-blue double margin_bottom_0">
                                    <a href="<?php echo base_url('marketplace')?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon="&#xe0a4;"></div>
                                        <div class="info"><?php echo $challenges_in_market?></div>
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
        </div>

        <div class="row-fluid">
            <div class="span3">
                <div class="widget">
                    <div class="widget-header">
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
                    <div class="widget-header">
                        <div class="title"><span data-icon="&#xe0a4;"></span>  Step 2</div>
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
                    <div class="widget-header">
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
                    <div class="widget-header">
                        <div class="title"><span data-icon="&#xe097;"></span> Step 4</div>
                    </div>
                    <div class="widget-body">
                        <a href="/marketplace">
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
                        <p>Register as student and enter the following trial codes</p>
                        <div class="row-fluid">
                            <?php for ($i=1; $i<=4; $i++): ?>
                            <div class="span3">
                                <div class="widget">
                                    <div class="widget-header">
                                        <div class="title"> Grade <?php echo $i ?></div>
                                    </div>
                                    <div class="widget-body">
                                        <strong style="font-size: 15px; color: #ed6d49">trymath<?php echo $i ?></strong>
                                    </div>
                                </div>
                            </div>
                            <?php endfor ?>
                        </div>
                        <div class="row-fluid">
                            <?php for ($i=5; $i<=8; $i++): ?>
                                <div class="span3">
                                    <div class="widget">
                                        <div class="widget-header">
                                            <div class="title">Grade <?php echo $i ?></div>
                                        </div>
                                        <div class="widget-body">
                                            <strong style="font-size: 15px; color: #ed6d49">trymath<?php echo $i ?></strong>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span9">
<!--                <div class="widget">-->
<!--                    <div class="widget-header">-->
<!--                        <div class="title">Top 5 Challenges</div>-->
<!--                    </div>-->
<!--                    <div class="widget-body">-->
<!--                        <div class="easy-pie-charts-container" style="padding: 35px 30px;">-->
<!--                            --><?php //if(isset($top_challenges) === true && empty($top_challenges) === false):?>
<!--                                --><?php //foreach($top_challenges as $challenge=>$val):?>
<!--                                    <div class="pie-chart">-->
<!--                                        <div class="chart--><?php //echo $challenge+1?><!-- easyPieChart" data-percent="--><?php //echo $val['played_times_percent']?><!--" style="width: 140px; height: 140px; line-height: 140px;">-->
<!--                                            --><?php //echo $val['played_times_percent']?><!--%-->
<!--                                            <canvas width="140" height="140"></canvas>-->
<!--                                        </div>-->
<!--                                        <p class="name">--><?php //echo $val['challenge_name']?><!--</p>-->
<!--                                    </div>-->
<!--                                --><?php //endforeach;?>
<!--                            --><?php //endif?>
<!--                            <div class="clearfix">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="span12 margin_left_0">

                </div>
            </div>

        <div class="clearfix">
        </div> <br>

    </div>

    <div class="right-sidebar">
        <div class="wrapper">
            <div class="overview" >
                <div class="featured-articles-container featured-articles-container">
                    <h5 class="heading">Video Support</h5>
                    <div>
                        <a href="#" data-toggle="modal" data-target="#introVideo">
                            <img src="http://i.ytimg.com/vi/krsBMGULJKw/mqdefault.jpg" />
                        </a>
                        <br/><br/>
                    </div>
                    <h5 class="heading">Class Compete Overview</h5>
                    <div class="articles">
                        <a data-original-title="">
                            <span class="label-bullet">&nbsp;</span>
                            <a href="<?php echo site_url('classes')?>">Setup Classroom</a>
                        </a>
                        <a data-original-title="">
                            <span class="label-bullet">&nbsp;</span>
                            <a href="<?php echo site_url('marketplace')?>">Lookup Challenges in Marketplace</a>
                        </a>
                        <a data-original-title="">
                            <span class="label-bullet">&nbsp;</span>
                            <a href="<?php echo site_url('marketplace')?>">Assign Challenges to Classroom</a>
                        </a>
                        <a data-original-title="">
                            <span class="label-bullet">&nbsp;</span>
                            <a href="<?php echo site_url('reporting/basic')?>">Watch the Results!!!</a>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal hide fade" id="introVideo" tabindex="-1" role="dialog" style="width: 830px; margin-left: -415px; top:5px" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    How to use ClassCompete?
                </div>
            </div>
            <div class="widget-body">
                <iframe src="//www.youtube.com/embed/krsBMGULJKw?rel=0" frameborder="0"  allowfullscreen="" width="800" frameborder="0" height="600"></iframe>
            </div>
        </div>
    </div>
</div>
