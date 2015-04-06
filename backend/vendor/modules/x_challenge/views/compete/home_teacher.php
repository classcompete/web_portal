<div class="dashboard-wrapper">
    <div class="left-sidebar">
        <div class="row-fluid">
            <div class="span9">
                <div class="widget">
                    <div class="widget-header">
                        <?php if($this->uri->segment(1)=== 'marketplace'):?>
                            <div class="title">Available Challenges</div>
                        <?php endif;?>
                        <?php if($this->uri->segment(1) === 'challenge'):?>
                            <div class="title">Classroom Challenges</div>
                        <?php endif;?>
                        <?php if($this->uri->segment(1) === 'challenge_builder'):?>
                            <div class="title">Build Challenges</div>
                        <?php endif;?>
                        <span class="tools">
                            <select id="assigned_challenge_selector">
                                <option value="all" selected="selected">All classrooms</option>
                                <?php foreach($classroms as $class=>$val):?>
                                    <option value="<?php echo $val->getId()?>"><?php echo $val->getName()?></option>
                                <?php endforeach;?>
                            </select>
                        </span>
                    </div>
                    <div class="widget-body clearfix">
                    <div class="container-fluid mod-challenge">
                    <?php foreach ($challenges as $challenge => $val): ?>
                        <div class="span5 margin_bottom my_challenge margin_left_0" data-class-id="<?php echo $val['class_id']?>"
                             id="my_challenge<?php echo $val['uninstall_challenge'] ?>">
                            <div class="float_left">
                                <div class="thumbnail_challenge">
                                    <?php if (isset($val['edit_challenge']) === true): ?>
                                        <a href="<?php echo site_url('question/challenge') . '/' . $val['edit_challenge'] ?>">
                                            <img
                                                src="<?php echo site_url('challenge/display_teacher_image/' . $val['user_id']) ?>">
                                        </a>
                                    <?php else : ?>
                                        <img
                                            src="<?php echo site_url('challenge/display_teacher_image/' . $val['user_id']) ?>">
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="float_left" style="width: 210px;">
                                <h5 class="challenge_list_width" style="max-width: 210px"><?php echo $val['challenge_name']?></h5>
                                <span><?php echo $val['data']['class_name'] ?></span>

                                <p style="margin-top: 5px">
                                    <button class="btn btn-mini btn-danger uninstallMyChallange"
                                            data-target="#uninstallChallenge"
                                            data-toggle="modal" data-backdrop="static"
                                            data-id="<?php echo $val['uninstall_challenge'] ?>">
                                        Remove
                                    </button>
                                    <?php if (isset($val['edit_challenge']) === true): ?>
                                        <button class="btn btn-warning btn-mini edit" data-target="#addEditChallenge"
                                                data-toggle="modal" data-id="<?php echo $val['edit_challenge'] ?>"
                                                data-mychallenges="true" data-backdrop="static">Edit
                                        </button>
                                        <a class="btn btn-info btn-mini"
                                           href="<?php echo site_url('question/challenge') . '/' . $val['edit_challenge'] ?>">Questions</a>
                                    <?php endif;?>
                                </p>
                            </div>

                            <div class="tooltip_content" style="display: none;">
                                <h3 class="text_align_center overflow_text"><b><?php echo $val['challenge_name'] ?></b></h3>

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
                                    <dd><?php echo $val['data']['subject_name'] ?></dd>
                                    <dt>Topic:</dt>
                                    <dd><?php echo $val['data']['skill_name'] ?></dd>
                                    <dt>Subtopic:</dt>
                                    <dd><?php echo $val['data']['topic_name'] ?></dd>
                                    <dt>Grade:</dt>
                                    <dd><?php echo $val['data']['level'] ?></dd>
                                    <dt>Environment:</dt>
                                    <dd><?php echo $val['data']['game_name'] ?></dd>
                                    <dt>Questions:</dt>
                                    <dd><?php echo $val['number_of_questions'] ?></dd>
                                    <dt>Played times:</dt>
                                    <dd><?php echo $val['data']['played_times'] ?></dd>
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
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>

                <div class="modal hide fade classmodal" id="uninstallChallenge" tabindex="-1" role="dialog" aria-labelledby="addClassLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Remove challenge</h3>
                    </div>

                    <?php $this->load->view('form_uninstall_challenge'); ?>

                </div>

                <div class="modal hide fade modal_absolute" id="addEditChallenge" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Edit Challenge</h3>
                    </div>

                    <?php $this->load->view('form'); ?>

                </div>
            </div>
                </div>
            </div>
            <div class="span3">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Most Played Challenges</div>
                    </div>
                    <div class="widget-body">
                        <div class="wrapper">
                            <ul class="progress-statistics">
                                <?php foreach($top_challenges as $challenge=>$val):?>
                                    <li>
                                        <div class="details">
                                            <span><?php echo $val['challenge_name']?></span>
                                            <span class="pull-right"><?php echo $val['played_times_percent']?>%</span>
                                        </div>
                                        <div class="progress  progress-striped active">
                                            <div style="width: <?php echo $val['played_times_percent']?>%;" class="bar">
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
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