<div class="dashboard-wrapper">
    <div class="left-sidebar">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Build Challenges</div>
                <span class="tools">
                    <a class="btn btn-small btn-info" href="#"
                       data-original-title="" data-target="#addEditChallenge"
                       data-toggle="modal" id="addNewChallenge" data-backdrop="static">+ Add New Challenge</a>
                </span>
            </div>

            <div class="widget-body clearfix">
                <div id="challenge_filter_selector_holder">

                    <span class="challenge_filter_caption">Grade: </span>

                    <div class="row-fluid">
                        <select id="challenge_filter_grade_selector">
                            <option id="grade_all_option" value="all" selected="selected">All</option>
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
                            <option id="subject_all_option" value="all" selected="selected">All</option>
                            <?php foreach ($subjects as $subject => $val): ?>
                                <option
                                    value="<?php echo $val['subject_id'] ?>"><?php echo $val['subject_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <span class="challenge_filter_caption">Topic: </span>

                    <div class="row-fluid">
                        <select id="challenge_filter_topic_selector">
                            <option id="topic_all_option" value="all" selected="selected">All</option>
                            <?php foreach ($skills as $skill => $val): ?>
                                <option value="<?php echo $val['skill_id'] ?>"><?php echo $val['skill_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                </div>

                <div class="container-fluid mod-challenge challenge_filter_tab_content" id="challenge_filter_challenges_list">
                    <?php foreach ($challenges as $challenge => $val): ?>
                        <div class="span5 margin_bottom my_challenge challenge" data-subjectid="<?php echo $val['data']['subject_id'] ?>"
                             data-grade="<?php echo $val['data']['level'] ?>"
                             data-skill-id="<?php echo $val['data']['skill_id'] ?>" id="my_challenge<?php echo $val['challenge_id']?>">
                            <div class="float_left">
                                <div class="thumbnail_challenge">
                                    <a href="<?php echo site_url('question/challenge') . '/' . $val['edit_challenge'] ?>">
                                        <img
                                            src="<?php echo site_url('challenge_builder/display_teacher_image/' . $val['user_id']) ?>"
                                            style="vertical-align: middle">
                                    </a>
                                </div>
                            </div>
                            <div class="float_left">
                                <h5 class="challenge_list_width"><?php echo $val['challenge_name']?></h5>
                                <h6><?php echo $val['author_name']?></h6>

                                <p>
                                    <?php if (isset($val['edit_challenge']) === true): ?>
                                        <button class="btn btn-success btn-mini add installChallenge"
                                                data-target="#addChallenge" data-toggle="modal" data-backdrop="static"
                                                data-challenge-id="<?php echo $val['challenge_id']?>">Add to class</button>
                                        <button class="btn btn-warning btn-mini edit" data-target="#editChallenge"
                                                data-toggle="modal" data-backdrop="static" data-id="<?php echo $val['edit_challenge'] ?>">Edit
                                        </button>
                                        <a class="btn btn-info btn-mini"
                                           href="<?php echo site_url('question/challenge') . '/' . $val['edit_challenge'] ?>">Questions</a>
                                        <button class="btn btn-danger btn-mini deleteMyChallenge"
                                            data-target="#deleteChallenge" data-toggle="modal" data-backdrop="static" data-challenge-id="<?php echo $val['challenge_id']?>">
                                            Delete
                                        </button>
                                    <?php endif;?>
                                </p>
                            </div>

                            <div class="tooltip_content" style="display: none">
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
                                    <dd><?php echo $val['data']['number_of_questions']?></dd>
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

                <div class="modal hide fade classmodal modal_absolute modal_wide" id="addEditChallenge" tabindex="-1"
                     role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add Challenge</h3>
                    </div>
                    <div class="modal-body no-padding">
                        <?php $this->load->view('form'); ?>
                    </div>
                </div>

                <div class="modal hide fade modal_absolute" id="editChallenge" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Edit Challenge</h3>
                    </div>
                    <?php $this->load->view('../../../x_challenge/views/compete/form'); ?>
                </div>

                <div class="modal hide fade classmodal modal_absolute modal_wide" id="addQuestion" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add Question</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('../../../x_challenge_question/views/compete/form'); ?>
                    </div>
                </div>

                <div class="modal hide fade classmodal" id="addChallenge" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add challenge to class</h3>
                    </div>

                    <?php $this->load->view('form_install'); ?>

                </div>

                <div class="modal hide fade classmodal modal_semiwide" id="cropModal" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel" aria-hidden="true" style="top: -50px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Resize and Crop image</h3>
                    </div>

                    <?php $this->load->view('../../../x_challenge_question/views/compete/form_crop'); ?>
                </div>

                <div class="modal hide fade classmodal" id="deleteChallenge" tabindex="-1" role="dialog" aria-labelledby="addClassLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Delete challenge</h3>
                    </div>

                    <?php $this->load->view('form_delete_challenge'); ?>

                </div>

            </div>
        </div>
    </div>
    <div class="right-sidebar">
        <div class="wrapper">
            <div class="viewport">
                <div class="overview">
                    <div class="featured-articles-container featured-articles-container_min_height">
                        <h5 class="heading">Video Support - Challenges</h5>
                        <div>
                            <a href="#" data-toggle="modal" data-target="#introVideo">
                                <img src="http://i.ytimg.com/vi/krsBMGULJKw/mqdefault.jpg" />
                            </a>
                            <br/><br/>
                        </div>
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