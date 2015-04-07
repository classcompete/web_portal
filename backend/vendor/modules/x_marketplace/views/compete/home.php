<div class="dashboard-wrapper">
    <div class="left-sidebar">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    Available Challenges
                    <small> - Don't have what you need? Feel free to
                        "<a style="text-decoration: underline;" href="<?php echo site_url('challenge_builder')?>">Create Challenges</a>"</small>
                </div>
            </div>
            <div class="widget-body">

                <div id="challenge_filter_selector_holder">

                    <span class="challenge_filter_caption">Grade: </span>

                    <div class="row-fluid">
                        <select id="challenge_filter_grade_selector">
                            <option id="grade_all_option" value="all" selected="selected">Select</option>
                            <option value="-2">Pre K</option>
                            <option value="K">K</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">High School</option>
                        </select>
                    </div>

                    <span class="challenge_filter_caption">Subject: </span>

                    <div class="row-fluid">
                        <select id="challenge_filter_subject_selector">
                            <option id="subject_all_option" value="all" selected="selected">Select</option>
                            <?php foreach ($subjects as $subject => $val): ?>
                                <option
                                    value="<?php echo $val['subject_id'] ?>"><?php echo $val['subject_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <span class="challenge_filter_caption">Topic: </span>

                    <div class="row-fluid">
                        <select id="challenge_filter_topic_selector">
                            <option id="topic_all_option" value="all" selected="selected">Select</option>
                            <?php foreach ($skills as $skill => $val): ?>
                                <option value="<?php echo $val['skill_id'] ?>"><?php echo $val['skill_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                </div>

                <div id="challenge_filter_challenges_list" class="challenge_filter_tab_content container-fluid">
                    <div class="wrapper" style="background: none" id="challenge_filter_intro">
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="widget">
                                    <div class="widget-header yellow">
                                        <div class="title"><span data-icon="&#xe0a4;"></span>  Step 1</div>
                                    </div>
                                    <div class="widget-body">
                                        <h4>Assign Challenges</h4>
                                        <p style="font-size: 14px; min-height: 100px">
                                            Filter by Grade, or Subject, or Topic and assign a challenge to classroom
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="widget">
                                    <div class="widget-header blue">
                                        <div class="title"><span data-icon=""></span> Step 2</div>
                                    </div>
                                    <div class="widget-body">
                                        <h4>Tell Students to Play</h4>
                                        <p style="font-size: 14px; min-height: 100px">
                                            Students can login to the game and when they use your code,
                                            will see the challenges you assigned and can compete against others
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="widget">
                                    <div class="widget-header green">
                                        <div class="title"><span data-icon="&#xe097;"></span> Step 3</div>
                                    </div>
                                    <div class="widget-body">
                                        <h4>Monitor Results</h4>
                                        <p style="font-size: 14px; min-height: 100px">
                                            Click a classroom and see individual student and classroom results and adjust
                                            challenges accordingly
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Start challenge items list -->
                    <?php foreach ($grade_all as $grade => $val): ?>
                            <!-- Challenge item -->
                        <div class="span5 challenge my_challenge margin_bottom hide" data-subjectid="<?php echo $val['subject_id'] ?>"
                             data-grade="<?php echo $val['level'] ?>"
                             data-skill-id="<?php echo $val['skill_id'] ?>">
                            <div class="float_left">
                                <div class="thumbnail_challenge marketplace_thumb">
                                    <img
                                        src="<?php echo site_url('challenge/display_teacher_image/' . $val['user_id']) ?>">
                                </div>
                            </div>
                            <div class="float_left">
                                <h5 class="challenge_list_width"><?php echo $val['challenge_name']?></h5>
                                <h6><?php echo $val['author_name']?></h6>
                                <p>
                                    <button class="btn btn-mini btn-success install_challenge"
                                            data-target="#installChallenge" data-toggle="modal" data-backdrop="static"
                                            data-challengeid="<?php echo $val['challenge_id'] ?>">Add to class
                                    </button>
                                    <a class="btn btn-mini btn-info show_challenge_questions"
                                       href="<?php echo site_url('question/challenge_preview') . '/' . $val['challenge_id'] ?>">Questions
                                    </a>
                                </p>
                            </div>
                        </div> <!-- End Challenge item -->

                            <!-- Challenge tooltip -->
                        <div class="tooltip_content" style="display: none">
                            <h3 class="text_align_center overflow_text">
                                <b><?php echo $val['challenge_name'] ?></b>
                            </h3>

                            <div class="tooltip_author">
                                <span>by:</span>

                                <div>
                                    <span class="text_align_center"><?php echo $val['author_name'] ?></span>
                                    <img class="tooltip_img"
                                         src="<?php echo site_url('challenge/display_teacher_image/' . $val['user_id']) ?>"/>
                                </div>

                            </div>

                            <dl class="inline">
                                <dt>Subject:</dt>
                                <dd><?php echo $val['subject_name'] ?></dd>
                                <dt>Topic:</dt>
                                <dd><?php echo $val['skill_name'] ?></dd>
                                <dt>Subtopic:</dt>
                                <dd><?php echo $val['subskill_name'] ?></dd>
                                <dt>Grade:</dt>
                                <dd><?php echo $val['level'] ?></dd>
                                <dt>Environment:</dt>
                                <dd><?php echo $val['game_name'] ?></dd>
                                <dt>Questions:</dt>
                                <dd><?php echo $val['number_of_questions'] ?></dd>
                                <dt>Played times:</dt>
                                <dd><?php echo $val['played_times'] ?></dd>
                            </dl>

                            <?php if (empty($val['description']) === false): ?>
                                <div class="tooltip_description">
                                    <span>Description</span>

                                    <p>
                                        <?php echo (strlen($val['description']) >= 200) ?
                                            substr($val['description'], 0, 200) . '...' : $val['description'] ?>
                                    </p>
                                </div>
                            <?php endif ?>
                            <?php if (empty($val['teacher_biography']) === false): ?>
                                <div class="tooltip_description">
                                    <span>Teacher biography</span>

                                    <p>
                                        <?php echo (strlen($val['teacher_biography']) >= 200) ?
                                            substr($val['teacher_biography'], 0, 200) . '...' : $val['teacher_biography'] ?>
                                    </p>
                                </div>
                            <?php endif ?>
                        </div> <!-- End Challenge tooltip -->

                    <?php endforeach;?> <!-- End challenge items list-->
                </div>

	                <!-- Add challenge dialog -->
                <div class="modal hide fade classmodal" id="installChallenge" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add challenge to class</h3>
                    </div>

                    <?php $this->load->view('form_install'); ?>

                </div> <!-- End Add challenge dialog -->
            </div>
        </div>
    </div>
    <div class="right-sidebar">
        <div class="wrapper">
            <div class="viewport">
                <div class="overview">
                    <div class="featured-articles-container featured-articles-container_min_height">
                        <h5 class="heading">Video Support – Challenges</h5>
                        <div>
                            <a href="#" data-toggle="modal" data-target="#introVideo">
                                <img src="http://i.ytimg.com/vi/krsBMGULJKw/mqdefault.jpg" />
                            </a>
                            <br/><br/>
                        </div>

	                    <?php /*
	                    <h5 class="heading">Challenge Wizard</h5>

                        <div class="articles">
                            <a href="<?php echo site_url('marketplace')?>" data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                Search the marketplace for Exist Challenges
                            </a>
                            <a href="<?php echo site_url('challenge')?>" data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                Assign Challenges to a Classroom
                            </a>
                            <a href="<?php echo site_url('challenge_builder')?>" data-original-title="Challenge Builder">
                                <span class="label-bullet">&nbsp;</span>
                                Create Challenges for your Classes or to be listed in the Marketplace
                            </a>
                        </div>
                        */ ?>
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
                <iframe width="800" height="600" src="//www.youtube-nocookie.com/embed/2lK8HIz2XqI?rel=0&amp;showinfo=0"
                        frameborder="0" allowfullscreen></iframe>
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