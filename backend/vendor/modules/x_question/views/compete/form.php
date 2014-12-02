<?php echo form_open_multipart('question/save', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

    <div class="modal_left_column">

        <div class="control-group">
            <label class="control-label">Select subject</label>

            <div class="controls">
                <select name="subject_id" id="dl_question_subject_id">
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Select skill</label>

            <div class="controls">
                <select name="skill_id" id="dl_question_skill_id" disabled="disabled">
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Level</label>

            <div class="controls">
                <input type="text" name="level" id="level" value=""/>
            </div>
        </div>

        <div class="control-group" id="type_holder">
            <label class="control-label">Type</label>

            <div class="controls">
                <select name="type" id="type_id">
                    <option selected="selected" disabled="disabled">Select type...</option>
                </select>
            </div>
        </div>

        <div class="control-group question_type_multiple_choice" id="multiple_choice_holder" style="display: none">
            <label class="control-label">Multiple Choice</label>

            <div class="controls">
                <select name="multiple_choice" id="multiple_choice">
                    <option selected="selected" disabled="disabled">Select choice...</option>
                </select>
            </div>
        </div>

        <div class="control-group question_type_text">
            <label class="control-label">Question Text</label>

            <div class="controls">
                <textarea style="resize:none" id="text" name="text" rows="6" cols="20"></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Image</label>

            <div class="controls">
                <img id="image_link" src="http://admin.classcompete.local/question/display_question_image/1" width="100px" height="100px">
                <input type="file" name="image" id="image" value="" style="width: 230px !important;"/>
            </div>
        </div>

    </div>

    <div class="modal_right_column">
    <div id="dl_8_quest" class="control-group dl_question" style="display: none">
        <ul>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 1</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_1" name="eight_answer[1]"/>
                        <label>
                            <input type="file" name="eight_image_answer[1]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_1" name="correct_eight_answer" value="1"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 2</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_2" name="eight_answer[2]"/>
                        <label>
                            <img id="image_link" src="http://admin.classcompete.local/question/display_question_choice_image/1" width="100px" height="100px">
                            <input type="file" name="eight_image_answer[2]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_2" name="correct_eight_answer" value="2"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 3</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_3" name="eight_answer[3]"/>
                        <label>
                            <input type="file" name="eight_image_answer[3]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_3" name="correct_eight_answer" value="3"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 4</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_4" name="eight_answer[4]"/>
                        <label>
                            <input type="file" name="eight_image_answer[4]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_4" name="correct_eight_answer" value="4"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 5</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_5" name="eight_answer[5]"/>
                        <label>
                            <input type="file" name="eight_image_answer[5]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_5" name="correct_eight_answer" value="5"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 6</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_6" name="eight_answer[6]"/>
                        <label>
                            <input type="file" name="eight_image_answer[6]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_6" name="correct_eight_answer" value="6"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 7</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_7" name="eight_answer[7]"/>
                        <label>
                            <input type="file" name="eight_image_answer[7]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_7" name="correct_eight_answer" value="7"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 8</label>

                    <div class="controls">
                        <input type="text" id="eight_answer_8" name="eight_answer[8]"/>
                        <label>
                            <input type="file" name="eight_image_answer[8]"/>
                        </label>
                        <label>
                            <input type="radio" id="correct_eight_answer_8" name="correct_eight_answer" value="8"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div id="dl_4_quest" class="control-group dl_question" style="display: none">
        <ul>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 1</label>

                    <div class="controls">
                        <input type="text" id="four_answer_1" name="four_answer[1]"/>
                        <label>
                            <img id="image_link" src="http://admin.classcompete.local/question/display_question_choice_image/1" width="100px" height="100px">
                            <input type="file" name="four_image_answer[1]"/>
                        </label>
                        <label>
                            <input type="radio" name="correct_four_answer" id="correct_four_answer_1" value="1"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 2</label>

                    <div class="controls">
                        <input type="text" id="four_answer_2" name="four_answer[2]"/>
                        <label>
                            <input type="file" name="four_image_answer[2]"/>
                        </label>
                        <label>
                            <input type="radio" name="correct_four_answer" id="correct_four_answer_2" value="2"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 3</label>

                    <div class="controls">
                        <input type="text" id="four_answer_3" name="four_answer[3]"/>
                        <label>
                            <input type="file" name="four_image_answer[3]"/>
                        </label>
                        <label>
                            <input type="radio" name="correct_four_answer" id="correct_four_answer_3" value="3"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
            <li>
                <div class="control-group">
                    <label class="control-label">Answer 4</label>

                    <div class="controls">
                        <input type="text" id="four_answer_4" name="four_answer[4]"/>
                        <label>
                            <input type="file" name="four_image_answer[4]"/>
                        </label>
                        <label>
                            <input type="radio" name="correct_four_answer" id="correct_four_answer_4" value="4"/>
                            <span>Correct?</span>
                        </label>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="control-group dl_question" id="true_false" style="display: none">
        <div class="control-group">
            <label class="control-label">Answer</label>

            <div class="controls">
                <label>
                    <input type="radio" id="answer_true" name="true_false" value="true"/>True
                </label>
                <label>
                    <input type="radio" id="answer_false" name="true_false" value="false"/>False
                </label>
            </div>
        </div>
    </div>

    <div class="control-group dl_question" id="order_slider" style="display: none">
        <a href="#" id="order_slider_add" class="add_icon"></a>
        <a href="#" id="order_slider_remove" class="remove_icon"></a>

        <div class="control-group">
            <label class="control-label">Answer 1</label>

            <div class="controls">
                <input type="text" id="order_slider_1" name="order_slider[1]"/>
                <label>
                    <img id="image_link" src="http://admin.classcompete.local/question/display_question_choice_image/1" width="100px" height="100px">
                    <input type="file" name="order_slider_image[1]"/>
                </label>
            </div>
        </div>

        <div id="order_slider_answer_holder"></div>

        <div class="control-group">
            <label class="control-label">Correct</label>

            <div class="controls">
                <input type="text" id="order_slider_correct" name="order_slider_correct"/>
            </div>
        </div>
    </div>

    <div class="control-group" id="correct_text" style="display: none">
        <label class="control-label">Correct text</label>

        <div class="controls">
            <textarea style="resize: none" id="correct_answer_text" name="correct_text" rows="6" cols="20"></textarea>
        </div>
    </div>

    <div class="control-group" id="correct_calculation" style="display: none">
        <label class="control-label">Correct calculation</label>

        <div class="controls">
            <input type="text" id="calculator_correct_text" name="calculator_correct_text"/>
        </div>
    </div>

    </div>

    <div class="modal_full_width">
        <div class="modal-footer">
            <button class="btn btn-primary">Save changes</button>
        </div>

        <input type="hidden" name="id" id="edit_question_id"/>
    </div>

<?php echo form_close(); ?>