<div class="dashboard-wrapper">
<div class="left-sidebar no-margin">
<div class="widget">

<div class="widget-header">
    <div class="title">Challenge Questions</div>
    <span class="tools">
        <a class="btn btn-small btn-info" href="#"
           data-original-title="" data-target="#addEditQuestion2"
           data-toggle="modal" id="addNewQuestion2" data-backdrop="static">+ Add new question</a>
    </span>
</div>

<div class="widget-body clearfix">

<div class="container-fluid mod-challenge-question">
    <?php foreach ($questions as $question => $val): ?>
        <div class="span2 margin_bottom challenge_question" id="challenge_question<?php echo $val['question_id'] ?>">

            <div class="text_align_center">
                <p class="margin_bottom_0 one_line_text"><?php echo $val['question_name']?></p>

                <span class="overflow_text"><?php echo $val['question_type']?></span>
            </div>

            <div class="thumbnail_challenge_question" data-id="<?php echo $val['question_id'] ?>">
                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png?' . time() ?>">
            </div>
            <div class="text_align_center">
                <p class="margin_bottom_0">
                    <button class="btn btn-warning btn-mini edit" data-target="#editQuestion2"
                            data-toggle="modal" data-backdrop="static" data-id="<?php echo $val['question_id'] ?>"
                            data-questiontype="<?php echo $val['question_image'] ?>">Edit
                    </button>
                    <button class="btn btn-danger btn-mini delete" data-id="<?php echo $val['question_id'] ?>">Delete</button>
                </p>
            </div>
            <div class="tooltip_content" style="display: none">
                <?php $type = intval(str_replace('question_type_', '', $val['question_image']));
                switch ($type):
                    case 1:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png?' . time() ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size clearfix">
                                <div class="form_holder">
                                    <div class="question_form_holder form_1">
                                        <div class="question previewed_question_style">
                                            <div class="controls">
                                                <?php echo $val['data']['question_text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true &&
                                            $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][0]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true &&
                                            $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][1]['text']?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php
                    case 2:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png?' . time() ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size clearfix">
                                <div class="form_holder">
                                    <div class="question_form_holder form_2">
                                        <div class="question previewed_question_style">
                                            <div class="controls">
                                                <?php echo $val['data']['question_text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                            && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][0]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                            && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][1]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a3<?php echo (isset($val['data']['answers'][2]['correct']) === true
                                            && $val['data']['answers'][2]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][2]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a4<?php echo (isset($val['data']['answers'][3]['correct']) === true
                                            && $val['data']['answers'][3]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][3]['text'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php
                    case 3:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size clearfix">
                                <div class="form_holder">
                                    <div class="question_form_holder form_3 clearfix">
                                        <div class="question previewed_question_style">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                        <div class="question_image previewed_question_image_style pic1">
                                            <div class="image_holder">
                                                <img src="<?php echo site_url('question/display_question_image') . '/' . $val['data']['question_image'] ?>">
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                            && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][0]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                            && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][1]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a3<?php echo (isset($val['data']['answers'][2]['correct']) === true
                                            && $val['data']['answers'][2]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][2]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a4<?php echo (isset($val['data']['answers'][3]['correct']) === true
                                            && $val['data']['answers'][3]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][3]['text'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php
                    case 4:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size">
                                <div class="form_holder">
                                    <div class="question_form_holder form_4 clearfix">
                                        <div class="question previewed_question_style">
                                            <div class="controls">
                                                <?php echo $val['data']['question_text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer_holder a1">
                                            <div class="answer previewed_answer_image_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                                && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_4 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][0]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder a2">
                                            <div class="answer previewed_answer_image_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                                && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_4 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][1]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_image_styles a3<?php echo (isset($val['data']['answers'][2]['correct']) === true
                                                && $val['data']['answers'][2]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_4 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][2]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_image_styles a4<?php echo (isset($val['data']['answers'][3]['correct']) === true
                                                && $val['data']['answers'][3]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_4 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][3]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php
                    case 5:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size">
                                <div class="form_holder">
                                    <div class="question_form_holder form_5 clearfix">
                                        <div class="question previewed_question_style">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                        <div class="question_image previewed_question_image_style pic1">
                                            <div class="image_holder_5_question">
                                                <img src="<?php echo site_url('question/display_question_image') . '/' . $val['data']['question_image'] ?>">
                                            </div>
                                        </div>
                                        <div class="answer_holder a1">
                                            <div class="answer previewed_answer_image_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                                && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_5 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][0]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div> <!-- /Answer Holder 1-->
                                        <div class="answer_holder a2">
                                            <div class="answer previewed_answer_image_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                                && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_5 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][1]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div> <!-- /Answer Holder 2-->
                                        <div class="answer_holder a3">
                                            <div class="answer previewed_answer_image_styles a3<?php echo (isset($val['data']['answers'][2]['correct']) === true
                                                && $val['data']['answers'][2]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_5 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][2]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div> <!-- /Answer Holder 3-->
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_image_styles a4<?php echo (isset($val['data']['answers'][3]['correct']) === true
                                                && $val['data']['answers'][3]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="image_holder_5 answer_image_holder">
                                                    <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][3]['answer_image'] ?>" alt="">
                                                </div>
                                            </div>
                                        </div> <!-- /Answer Holder 4-->
                                    </div> <!-- /Form 5 -->
                                </div> <!-- /Form holder -->
                            </div> <!-- /Tooltip Size Modal -->
                        </div>
                        <?php break; ?>
                    <?php
                    case 6:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size clearfix">
                                <div class="form_holder">
                                    <div class="question_form_holder form_6">
                                        <div  class="question previewed_question_style">
                                            <div class="controls">
                                                <?php echo $val['data']['question_text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                                && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][0]['text'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                                && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][1]['text'] ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a3<?php echo (isset($val['data']['answers'][2]['correct']) === true
                                                && $val['data']['answers'][2]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][2]['text'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a4<?php echo (isset($val['data']['answers'][3]['correct']) === true
                                                && $val['data']['answers'][3]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][3]['text'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a5<?php echo (isset($val['data']['answers'][4]['correct']) === true
                                                && $val['data']['answers'][4]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][4]['text'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a6<?php echo (isset($val['data']['answers'][5]['correct']) === true
                                                && $val['data']['answers'][5]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][5]['text'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a7<?php echo (isset($val['data']['answers'][6]['correct']) === true
                                                && $val['data']['answers'][6]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][6]['text'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="answer_holder">
                                            <div class="answer previewed_answer_styles a8<?php echo (isset($val['data']['answers'][7]['correct']) === true
                                                && $val['data']['answers'][7]['correct'] === true) ? ' correct_answer' : '' ?>">
                                                <div class="controls">
                                                    <?php echo $val['data']['answers'][7]['text'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php
                    case 7:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size">
                                <div class="form_holder">
                                    <div class="question_form_holder form_7 clearfix">
                                        <div class="question previewed_question_style">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                        <div class="answer previewed_answer_styles_preview">
                                            <div class="controls">
                                                <?php echo $val['data']['correct_text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles_ok">ok</div>

                                        <div class="answer previewed_answer_styles a1">1</div>
                                        <div class="answer previewed_answer_styles a2">2</div>
                                        <div class="answer previewed_answer_styles a3">3</div>
                                        <div class="answer previewed_answer_styles a4">4</div>
                                        <div class="answer previewed_answer_styles a5">5</div>
                                        <div class="answer previewed_answer_styles a6">6</div>
                                        <div class="answer previewed_answer_styles a7">7</div>
                                        <div class="answer previewed_answer_styles a8">8</div>
                                        <div class="answer previewed_answer_styles a9">9</div>
                                        <div class="answer previewed_answer_styles a10">.</div>
                                        <div class="answer previewed_answer_styles a11">0</div>
                                        <div class="answer previewed_answer_styles a12">del</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php
                    case 8:
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size">
                                <div class="form_holder">
                                    <div class="question_form_holder form_8 clearfix">
                                        <div class="question previewed_question_style">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                        <div class="question_image previewed_question_image_style pic1">
                                            <div class="image_holder_8_question">
                                                <img src="<?php echo site_url('question/display_question_image') . '/' . $val['data']['question_image'] ?>">
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles_preview">
                                            <div class="controls">
                                                <?php echo $val['data']['correct_text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles_ok">ok</div>

                                        <div class="answer previewed_answer_styles a1">1</div>
                                        <div class="answer previewed_answer_styles a2">2</div>
                                        <div class="answer previewed_answer_styles a3">3</div>
                                        <div class="answer previewed_answer_styles a4">4</div>
                                        <div class="answer previewed_answer_styles a5">5</div>
                                        <div class="answer previewed_answer_styles a6">6</div>
                                        <div class="answer previewed_answer_styles a7">7</div>
                                        <div class="answer previewed_answer_styles a8">8</div>
                                        <div class="answer previewed_answer_styles a9">9</div>
                                        <div class="answer previewed_answer_styles a10">.</div>
                                        <div class="answer previewed_answer_styles a11">0</div>
                                        <div class="answer previewed_answer_styles a12">del</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php
                    case 9:
                        ?>
                        <?php $order_array = explode(',', $val['data']['correct_text']);
                        $min_item = min($order_array) - 1;
                        $ordered_answer_indexes = array();
                        foreach ($order_array as $item){
                            $ordered_answer_indexes[] = ($item - $min_item);
                        }
                        ?>
<!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">

                            <div class="modal_tooltip_size">

                                <div class="form_holder">

                                    <div class="question_form_holder form_9 clearfix">
                                        <div class="question previewed_question_style">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>

                                        <div class="answer previewed_answer_styles a1" >
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][0]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a2">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][1]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a3">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][2]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a4">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][3]['text'] ?>
                                            </div>
                                        </div>

                                        <div class="question_image previewed_question_image_style_middle">
                                            <div class="image_holder">
                                                <img src="<?php echo site_url('question/display_question_image') . '/' . $val['data']['question_image'] ?>">
                                            </div>
                                        </div>

                                        <div class="answer previewed_order_styles o1">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][$ordered_answer_indexes[0]-1]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_order_styles o2">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][$ordered_answer_indexes[1]-1]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_order_styles o3">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][$ordered_answer_indexes[2]-1]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_order_styles o4">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][$ordered_answer_indexes[3]-1]['text'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--<div class="question_type_9_tooltip">

                                <div class="form_holder">
                                    <div class="question_form_holder form9 clearfix">
                                        <div class="question previewed_question_style"><?php /*echo $val['data']['question_text'] */?></div>

                                        <div class="answer previewed_answer_styles a1"><?php /*echo $val['data']['answers'][0]['text'] */?></div>
                                        <div class="answer previewed_answer_styles a2"><?php /*echo $val['data']['answers'][1]['text'] */?></div>
                                        <div class="answer previewed_answer_styles a3"><?php /*echo $val['data']['answers'][2]['text'] */?></div>
                                        <div class="answer previewed_answer_styles a4"><?php /*echo $val['data']['answers'][3]['text'] */?></div>

                                        <div class="question_image previewed_question_image_style_middle">
                                            <div class="image_holder">
                                                <img src="<?php /*echo site_url('question/display_question_image') . '/' . $val['data']['question_image'] */?>">
                                            </div>
                                        </div>

                                        <div class="answer previewed_order_styles o1"><?php /*echo $val['data']['answers'][$ordered_answer_indexes[0]-1]['text'] */?></div>
                                        <div class="answer previewed_order_styles o2"><?php /*echo $val['data']['answers'][$ordered_answer_indexes[1]-1]['text'] */?></div>
                                        <div class="answer previewed_order_styles o3"><?php /*echo $val['data']['answers'][$ordered_answer_indexes[2]-1]['text'] */?></div>
                                        <div class="answer previewed_order_styles o4"><?php /*echo $val['data']['answers'][$ordered_answer_indexes[3]-1]['text'] */?></div>
                                    </div>
                                </div>

                            </div>-->
                        </div>
                        <?php break; ?>
                        <?php case 10: ?>
                        <!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                        <div class="tooltip_question_left_column">
                            <div class="thumbnail_challenge_question tooltip_question_type_image">
                                <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                            </div>
                            <div class="text_align_center">
                                <span class="overflow_text"><?php echo $val['question_type']?></span>
                            </div>
                        </div>
                        <div class="tooltip_question_right_column">
                            <div class="modal_tooltip_size clearfix">
                                <div class="form_holder">
                                    <div class="question_form_holder form_10 clearfix">
                                        <div class="question previewed_question_style">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                        <div class="question_image previewed_question_image_style pic1">
                                            <div class="image_holder">
                                                <img src="<?php echo site_url('question/display_question_image') . '/' . $val['data']['question_image'] ?>">
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                            && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][0]['text'] ?>
                                            </div>
                                        </div>
                                        <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                            && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="controls">
                                                <?php echo $val['data']['answers'][1]['text'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php case 11: ?>
                    <!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                    <div class="tooltip_question_left_column">
                        <div class="thumbnail_challenge_question tooltip_question_type_image">
                            <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                        </div>
                        <div class="text_align_center">
                            <span class="overflow_text"><?php echo $val['question_type']?></span>
                        </div>
                    </div>
                    <div class="tooltip_question_right_column">
                        <div class="modal_tooltip_size">
                            <div class="form_holder">
                                <div class="question_form_holder form_11 clearfix">
                                    <div class="question previewed_question_style">
                                        <?php echo $val['data']['question_text'] ?>
                                    </div>
                                    <div class="question_image previewed_question_image_style pic1">
                                        <div class="image_holder_11_question">
                                            <img src="<?php echo site_url('question/display_question_image') . '/' . $val['data']['question_image'] ?>">
                                        </div>
                                    </div>
                                    <div class="answer_holder a1">
                                        <div class="answer previewed_answer_image_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                            && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="image_holder_11 answer_image_holder">
                                                <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][0]['answer_image'] ?>" alt="">
                                            </div>
                                        </div>
                                    </div> <!-- /Answer Holder 1-->
                                    <div class="answer_holder a2">
                                        <div class="answer previewed_answer_image_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                            && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="image_holder_11 answer_image_holder">
                                                <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][1]['answer_image'] ?>" alt="">
                                            </div>
                                        </div>
                                    </div> <!-- /Answer Holder 2-->
                                </div> <!-- /Form 5 -->
                            </div> <!-- /Form holder -->
                        </div> <!-- /Tooltip Size Modal -->
                    </div>
                    <?php break; ?>
                    <?php case 12: ?>
                    <!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                    <div class="tooltip_question_left_column">
                        <div class="thumbnail_challenge_question tooltip_question_type_image">
                            <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                        </div>
                        <div class="text_align_center">
                            <span class="overflow_text"><?php echo $val['question_type']?></span>
                        </div>
                    </div>
                    <div class="tooltip_question_right_column">
                        <div class="modal_tooltip_size">
                            <div class="form_holder">
                                <div class="question_form_holder form_4 clearfix">
                                    <div class="question previewed_question_style">
                                        <div class="controls">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer_holder a1">
                                        <div class="answer previewed_answer_image_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                            && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="image_holder_4 answer_image_holder">
                                                <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][0]['answer_image'] ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="answer_holder a2">
                                        <div class="answer previewed_answer_image_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                            && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                            <div class="image_holder_4 answer_image_holder">
                                                <img src="<?php echo site_url('question/display_choice_image') . '/' . $val['data']['answers'][1]['answer_image'] ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php break; ?>
                    <?php case 13: ?>
                    <!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                    <div class="tooltip_question_left_column">
                        <div class="thumbnail_challenge_question tooltip_question_type_image">
                            <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                        </div>
                        <div class="text_align_center">
                            <span class="overflow_text"><?php echo $val['question_type']?></span>
                        </div>
                    </div>
                    <div class="tooltip_question_right_column">
                        <div class="modal_tooltip_size clearfix">
                            <div class="form_holder">
                                <div class="question_form_holder form_13">
                                    <div class="question previewed_question_style">
                                        <div class="controls">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true &&
                                        $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][0]['text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true &&
                                        $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][1]['text']?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php break; ?>
                    <?php case 14: ?>
                    <!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                    <div class="tooltip_question_left_column">
                        <div class="thumbnail_challenge_question tooltip_question_type_image">
                            <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                        </div>
                        <div class="text_align_center">
                            <span class="overflow_text"><?php echo $val['question_type']?></span>
                        </div>
                    </div>
                    <div class="tooltip_question_right_column">
                        <div class="modal_tooltip_size clearfix">
                            <div class="form_holder">
                                <div class="question_form_holder form_14">
                                    <div class="question previewed_question_style">
                                        <div class="controls">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                        && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][0]['text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                        && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][1]['text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a3<?php echo (isset($val['data']['answers'][2]['correct']) === true
                                        && $val['data']['answers'][2]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][2]['text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a4<?php echo (isset($val['data']['answers'][3]['correct']) === true
                                        && $val['data']['answers'][3]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][3]['text'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php break; ?>
                    <?php case 15: ?>
                    <!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                    <div class="tooltip_question_left_column">
                        <div class="thumbnail_challenge_question tooltip_question_type_image">
                            <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png' ?>">
                        </div>
                        <div class="text_align_center">
                            <span class="overflow_text"><?php echo $val['question_type']?></span>
                        </div>
                    </div>
                    <div class="tooltip_question_right_column">
                        <div class="modal_tooltip_size clearfix">
                            <div class="form_holder">
                                <div class="question_form_holder form_14">
                                    <div class="question previewed_question_style">
                                        <div class="controls">
                                            <?php echo $val['data']['question_text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a1<?php echo (isset($val['data']['answers'][0]['correct']) === true
                                        && $val['data']['answers'][0]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][0]['text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a2<?php echo (isset($val['data']['answers'][1]['correct']) === true
                                        && $val['data']['answers'][1]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][1]['text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a3<?php echo (isset($val['data']['answers'][2]['correct']) === true
                                        && $val['data']['answers'][2]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][2]['text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles a4<?php echo (isset($val['data']['answers'][3]['correct']) === true
                                        && $val['data']['answers'][3]['correct'] === true) ? ' correct_answer' : '' ?>">
                                        <div class="controls">
                                            <?php echo $val['data']['answers'][3]['text'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php break; ?>
                    <?php case 16: ?>
                    <!--                        <h5 class="text_align_center"><b>--><?php //echo $val['data']['question_text'] ?><!--</b></h5>-->
                    <div class="tooltip_question_left_column">
                        <div class="thumbnail_challenge_question tooltip_question_type_image">
                            <img src="<?php echo site_url('images') . '/' . $val['question_image'] . '.png?' . time() ?>">
                        </div>
                        <div class="text_align_center">
                            <span class="overflow_text"><?php echo $val['question_type']?></span>
                        </div>
                    </div>
                    <div class="tooltip_question_right_column">
                        <div class="modal_tooltip_size">
                            <div class="form_holder">
                                <div class="question_form_holder form_16 clearfix">
                                    <div class="question previewed_question_style">
                                        <?php echo $val['data']['question_text'] ?>
                                    </div>
                                    <div class="answer previewed_answer_styles_preview">
                                        <div class="controls">
                                            <?php echo $val['data']['correct_text'] ?>
                                        </div>
                                    </div>
                                    <div class="answer previewed_answer_styles_ok">ok</div>
                                    <div class="answer previewed_read_text_styles_preview">
                                        <div class="controls">
                                            <?php echo nl2br($val['data']['read_text']) ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php break; ?>
                    <?php endswitch; ?>
            </div>
        </div>
    <?php endforeach;?>

</div>

<div class="modal hide fade classmodal modal_absolute modal_wide" id="addEditQuestion2" tabindex="-1"
     role="dialog"
     aria-labelledby="addClassLabel"
     aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Add Question</h3>
    </div>
    <div class="modal-body no-padding" style="min-height: 400px;">
        <?php $this->load->view('form'); ?>
    </div>
</div>

<div class="modal hide fade classmodal modal_absolute modal_wide" id="editQuestion2" tabindex="-1" role="dialog"
     aria-labelledby="addClassLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Edit Question</h3>
    </div>
    <?php $this->load->view('form_edit'); ?>
</div>

<div class="modal hide fade classmodal" id="uninstallChallenge" tabindex="-1" role="dialog" aria-labelledby="addClassLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Remove question</h3>
    </div>
    <?php $this->load->view('form_uninstall_question'); ?>
</div>

<div class="modal hide fade classmodal modal_semiwide" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="addClassLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Resize and Crop image</h3>
    </div>
    <?php $this->load->view('form_crop'); ?>
</div>

</div>
</div>
</div>
</div>