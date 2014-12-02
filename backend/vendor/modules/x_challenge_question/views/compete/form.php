<?php $question_type_path = BASEPATH . '../vendor/modules/x_challenge_question/views/compete/question_type/'; ?>
<div id="inverse2">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav">
                    <li>
                        <a data-toggle="tab" href="#inverse-tab1" data-original-title="">Question Type</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#inverse-tab2" data-original-title="">Question</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--<div class="progress progress-info progress-striped" id="bar testtest2">
        <div class="bar" style="width: 14.2857%;">
        </div>
    </div>-->
    <?php echo form_open_multipart('',
        array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'question_form')) ?>
    <input type="hidden" name="challenge_id" id="challenge_id"
           value="<?php echo (isset($challange_id) === true) ? $challange_id : '' ?>">
    <input type="hidden" name="add_new_question" id="add_new_question"/>

    <div class="tab-content no_bar_content">

        <div id="inverse-tab1" class="tab-pane">
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
        </div>
        <div id="inverse-tab2" class="tab-pane">
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

            <li style="display:none;" class="previous first disabled">
                <a href="#" data-original-title="">First</a>
            </li>
            <li class="previous disabled">
                <a href="#" data-original-title="">Previous</a>
            </li>
            <li style="display:none;" class="next last">
                <a href="#" data-original-title="">Last</a>
            </li>
            <li class="save" style="display: none; float: right">
                <button id="save_question_wizard" class="btn_question_save">Save & Close</button>
            </li>
            <li class="save" style="display: none; float: right">
                <button id="save_add_new_question_wizard" class="btn_question_save">Save & Add New Question</button>
            </li>

        </ul>
    </div>
    <?php echo form_close() ?>
</div>
<style>
    .thumbnails .thumbnail img {
        max-width: 170px;
    }
</style>