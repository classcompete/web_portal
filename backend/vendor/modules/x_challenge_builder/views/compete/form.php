<?php //$question_type_path = BASEPATH . '../vendor/modules/x_challenge_question/views/compete/question_type/'; ?>
<!--<div id="inverse">-->
<!--    <div class="navbar">-->
<!--        <div class="navbar-inner">-->
<!--            <div class="container">-->
<!--                <ul class="nav">-->
<!--                    <li class="active">-->
<!--                        <a data-toggle="tab" href="#inverse-tab1_challenge" data-original-title="">Challenge Info</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a data-toggle="tab" href="#inverse-tab2_challenge" data-original-title="">Additional</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="progress progress-info progress-striped" id="bar">-->
<!--        <div class="bar" style="width: 14.2857%;">-->
<!--        </div>-->
<!--    </div>-->
<!--    --><?php //echo form_open_multipart('challenge_builder/save_challenge',
//        array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'challenge_form'))
?>
<!--    <div class="tab-content">-->
<!---->
<!--        <div id="inverse-tab1_challenge" class="tab-pane active">-->
<!---->
<!--            <div class="modal_left_column">-->
<!--                <div class="control-group">-->
<!--                    <label class="control-label">Challenge name</label>-->
<!---->
<!--                    <div class="controls">-->
<!--                        <input type="text" name="challenge_name" id="challenge_name">-->
<!--                        <span class="help-inline"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="control-group">-->
<!--                    <label class="control-label">Select subject</label>-->
<!---->
<!--                    <div class="controls">-->
<!--                        <select name="subject_id" id="dl_subject_id">-->
<!--                            <option value="" selected="selected" disabled="disabled">Select subject...</option>-->
<!--                        </select>-->
<!--                        <span class="help-inline"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="control-group">-->
<!--                    <label class="control-label">Select topic</label>-->
<!---->
<!--                    <div class="controls">-->
<!--                        <select name="skill_id" id="dl_skill_id" disabled>-->
<!--                            <option value="" selected="selected" disabled="disabled">Select topic...</option>-->
<!--                        </select>-->
<!--                        <span class="help-inline"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="modal_right_column">-->
<!--                <div class="control-group">-->
<!--                    <label class="control-label">Select subtopic</label>-->
<!---->
<!--                    <div class="controls">-->
<!--                        <select name="topic_id" id="dl_topic_id" class="add_title" disabled="disabled">-->
<!--                            <option value="" selected="selected" disabled="disabled">Select subtopic...</option>-->
<!--                        </select>-->
<!--                        <span class="help-inline"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="control-group">-->
<!--                    <label class="control-label">Grade</label>-->
<!---->
<!--                    <div class="controls">-->
<!--                        <select name="level" id="level">-->
<!--                            <option value="-2">Pre k</option>-->
<!--                            <option value="-1">K</option>-->
<!--                            <option value="1">1</option>-->
<!--                            <option value="2">2</option>-->
<!--                            <option value="3">3</option>-->
<!--                            <option value="4">4</option>-->
<!--                            <option value="5">5</option>-->
<!--                            <option value="6">6</option>-->
<!--                            <option value="7">7</option>-->
<!--                            <option value="8">8</option>-->
<!--                        </select>-->
<!--                        <span class="help-inline"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="control-group">-->
<!--                    <label class="control-label">Environment</label>-->
<!---->
<!--                    <div class="controls">-->
<!--                        <select name="game_id" id="dl_game_id">-->
<!--                            <option value="" selected="selected" disabled="disabled">Select student...</option>-->
<!--                        </select>-->
<!--                        <span class="help-inline"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="modal_down">-->
<!--                <div class="control-group">-->
<!--                    <label class="control-label">Description</label>-->
<!---->
<!--                    <div class="controls">-->
<!--                        <textarea name="description" id="description" cols="30" rows="5"></textarea>-->
<!--                        <span> Characters left:-->
<!--                            <span id="chars"></span>-->
<!--                        </span>-->
<!--                        <span class="help-inline"></span>-->
<!--                    </div>-->
<!--                    <input type="hidden" name="add_question" id="add_question"/>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div id="inverse-tab2_challenge" class="tab-pane">-->
<!--            <div class="control-group">-->
<!--                <label class="control-label">Class</label>-->
<!---->
<!--                <div class="controls">-->
<!--                    <select name="class_id" id="class_id">-->
<!--                        <option value="" selected="selected" disabled="disabled">No class assigned</option>-->
<!--                    </select>-->
<!--                    <span class="help-inline"></span>-->
<!--                </div>-->
<!--                <div class="controls">-->
<!--                    <label>-->
<!--                        <input type="checkbox" checked="checked" value="--><?php //echo PropChallengePeer::IS_PUBLIC_YES?><!--" name="public_challenge" class="class_align_checkbox">Public challenge-->
<!--                    </label>-->
<!--                    <span class="help-inline"></span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <ul class="pager wizard no-margin" style="clear: both">-->
<!---->
<!--            <li style="display:none;" class="previous first disabled">-->
<!--                <a href="#" data-original-title="">First</a>-->
<!--            </li>-->
<!--            <li class="previous disabled">-->
<!--                <a href="#" data-original-title="">Previous</a>-->
<!--            </li>-->
<!--            <li style="display:none;" class="next last">-->
<!--                <a href="#" data-original-title="">Last</a>-->
<!--            </li>-->
<!--            <li class="next nextnext">-->
<!--                <a href="#" data-original-title="">Next</a>-->
<!--            </li>-->
<!--            <li class="save" style="display: none; float: right">-->
<!--                <button id="save_challenge_wizard" class="btn_question_save">Save & Close</button>-->
<!--            </li>-->
<!--            <li class="save" style="display: none; float: right">-->
<!--                <button id="save_challenge_add_question_wizard" class="btn_question_save">Save & Add Question</button>-->
<!--            </li>-->
<!---->
<!--        </ul>-->
<!--    </div>-->
<!--    --><?php //echo form_close() ?>
<!--</div>-->

<?php $question_type_path = BASEPATH . '../vendor/modules/x_challenge_question/views/compete/question_type/'; ?>
<div id="inverse">
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav">
                <li class="active">
                    <a data-toggle="tab" href="#inverse-tab1_challenge" data-original-title="">Challenge Info</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#inverse-tab1_rc" data-original-title="">Challenge Read Passage Info</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#inverse-tab2" data-original-title="">Question Type</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#inverse-tab3" data-original-title="">Question</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="progress progress-info progress-striped" id="bar">
    <div class="bar" style="width: 14.2857%;">
    </div>
</div>
<?php echo form_open_multipart('challenge_builder/save_challenge',
    array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'challenge_form')) ?>
<div class="tab-content">

<div id="inverse-tab1_challenge" class="tab-pane active">

    <div class="modal_left_column">
        <div class="control-group">
            <label class="control-label">Challenge name</label>

            <div class="controls">
                <input type="text" name="challenge_name" id="challenge_name">
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Select subject</label>

            <div class="controls">
                <select name="subject_id" id="dl_subject_id">
                    <option value="" selected="selected" disabled="disabled">Select subject...</option>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Select topic</label>

            <div class="controls">
                <select name="skill_id" id="dl_skill_id" disabled>
                    <option value="" selected="selected" disabled="disabled">Select topic...</option>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
    </div>
    <div class="modal_right_column">
        <div class="control-group">
            <label class="control-label">Select subtopic</label>

            <div class="controls">
                <select name="topic_id" id="dl_topic_id" class="add_title" disabled="disabled">
                    <option value="" selected="selected" disabled="disabled">Select subtopic...</option>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Grade</label>

            <div class="controls">
                <select name="level" id="level">
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
                <span class="help-inline"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Environment</label>

            <div class="controls">
                <select name="game_id" id="dl_game_id">
                    <option value="" selected="selected" disabled="disabled">Select student...</option>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
    </div>
    <div class="modal_down">
        <div class="control-group">
            <label class="control-label">Description</label>

            <div class="controls">
                <textarea name="description" id="description" cols="30" rows="5"></textarea>
                        <span> Characters left:
                            <span id="chars"></span>
                        </span>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Reading Comprehension? </label>
            <div class="controls" style="margin-top: 5px">
                <input type="checkbox" checked="checked" value="yes" id="is_read_passage"
                       name="is_read_passage" style="bottom: 3px; margin-right: 5px; position: relative;">
            </div>
        </div>
        <?php if(TeacherHelper::isPublisher()):?>
            <div class="control-group">
                <label class="control-label">Public challenge</label>
                    <div class="controls" style="margin-top: 5px">
                            <input type="checkbox" checked="checked" value="<?php echo PropChallengePeer::IS_PUBLIC_YES ?>"
                                   name="public_challenge" style="bottom: 3px; margin-right: 5px; position: relative;">
                    </div>
            </div>
        <?php endif;?>
    </div>
    <input type="hidden" name="add_question" id="add_question"/>
</div>
<div id="inverse-tab1_rc" class="tab-pane">
    <div class="modal_down">
        <div class="control-group">
            <label class="control-label">Passage Title</label>

            <div class="controls">
                <input type="text" name="read_title" id="read_title" style="width: 90%" size="33">
                <span class="help-inline"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Passage Text</label>

            <div class="controls">
                <textarea name="read_text" id="read_text" cols="30" rows="5"></textarea>
                <span class="help-inline"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Passage Image</label>
            <div id="read_image_preview" class="read_image read_image_style pic1">
                <div id="read_image" class="image_holder" style="float: left; margin-left: 20px; position: relative">
                    <img class="img_to_upload" src="" style="display: none;"/>
                    <input type="hidden" name="read_image" class="image_name" id="read_image_name"/>
                    <button class="btn btn-warning set_image_btn" style="margin: -25% 0px 0px 41%; position: absolute; width: 100px;">Set image</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="inverse-tab2" class="tab-pane">
    <ul class="thumbnails question_thumbs">
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_1.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_2.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_3.png' ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_4.png' ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_5.png' ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_6.png' ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_7.png' ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_8.png' ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_9.png' ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_10.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_11.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_12.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_13.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_14.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_15.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
        <li class="span">
            <a class="thumbnail" data-original-title="">
                <img src="<?php echo site_url('images') . '/question_type_16.png?' . time() ?>" alt="260x180" title="">
            </a>
        </li>
    </ul>
    <input type="hidden" id="question_type_selected" name="question_type"/>
    <input type="hidden" id="save_and_add_new_question" name="new"/>
</div>
<div id="inverse-tab3" class="tab-pane">
    <?php //TODO: first question tab && select class for this challenge on tab 4 or tab 2??? ?>
    <div id="question_type_1" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_1.php'); ?>
    </div>

    <div id="question_type_2" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_2.php'); ?>
    </div>

    <div id="question_type_3" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_3.php'); ?>
    </div>

    <div id="question_type_4" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_4.php'); ?>
    </div>

    <div id="question_type_5" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_5.php'); ?>
    </div>

    <div id="question_type_6" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_6.php'); ?>
    </div>

    <div id="question_type_7" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_7.php'); ?>
    </div>

    <div id="question_type_8" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_8.php'); ?>
    </div>

    <div id="question_type_9" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_9.php'); ?>
    </div>

    <div id="question_type_10" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_10.php'); ?>
    </div>

    <div id="question_type_11" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_11.php'); ?>
    </div>

    <div id="question_type_12" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_12.php'); ?>
    </div>

    <div id="question_type_13" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_13.php'); ?>
    </div>

    <div id="question_type_14" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_14.php'); ?>
    </div>
    <div id="question_type_15" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_15.php'); ?>
    </div>
    <div id="question_type_16" class="question_type" style="display: none">
        <?php include_once($question_type_path . 'question_type_16.php'); ?>
    </div>
</div>

<ul class="pager wizard no-margin" style="clear: both">

    <?php /*
    <li style="display:none;" class="previous first disabled">
        <a href="#" data-original-title="">First</a>
    </li>
    <li class="previous disabled">
        <a href="#" data-original-title="">Previous</a>
    </li>
 */ ?>
    <li style="display:none;" class="next last">
        <a href="#" data-original-title="">Last</a>
    </li>
    <li class="next nextnext">
        <a href="#" data-original-title="">Next</a>
    </li>
    <li class="save save_close" style="display: none; float: right">
        <button id="save_challenge_wizard" class="btn_question_save">Save & Close</button>
    </li>
    <li class="save" style="display: none; float: right">
        <button id="save_challenge_add_question_wizard" class="btn_question_save">Save & Add Question</button>
    </li>

</ul>
</div>
<?php echo form_close() ?>
</div>