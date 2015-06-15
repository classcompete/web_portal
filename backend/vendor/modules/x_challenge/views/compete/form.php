<?php echo form_open_multipart('challenge/save',
    array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'challenge_form_edit')) ?>
    <div class="modal-body">
        <div class="modal_left_column">
            <div class="control-group">
                <label class="control-label">Challenge name</label>

                <div class="controls">
                    <input type="text" name="challenge_name" id="challenge_name_edit">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Select subject</label>

                <div class="controls">
                    <select name="subject_id" id="subject_id_edit">
                        <option value="" selected="selected" disabled="disabled">Select subject...</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Select topic</label>

                <div class="controls">
                    <select name="skill_id" id="skill_id_edit" disabled>
                        <option value="" selected="selected" disabled="disabled">Select topic...</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Description</label>

                <div class="controls">
                    <textarea class="resize_vertical" name="description" id="description_edit" cols="30"
                              rows="5"></textarea>
                <br/><span> Characters left:
                    <span id="chars_edit"></span>
                </span>
                    <span class="help-inline"></span>
                </div>
            </div>
        </div>
        <div class="modal_right_column">
            <div class="control-group">
                <label class="control-label">Select subtopic</label>

                <div class="controls">
                    <select name="topic_id" id="topic_id_edit" class="add_title" disabled="disabled">
                        <option selected="selected">Select subtopic...</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Grade</label>

                <div class="controls">
                    <select name="level" id="level_edit">
                        <!--<option value="-2">Pre k</option>-->
                        <option value="-1">K</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Environment</label>

                <div class="controls">
                    <select name="game_id" id="game_id_edit">
                        <option value="" selected="selected" disabled="disabled">Select environment...</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <?php if(CC_APP === 'admin' || TeacherHelper::isPublisher()):?>
            <div class="control-group">
                <label class="control-label">Public challenge</label>
                <div class="controls">
                    <input type="checkbox" id="is_public_edit" name="is_public" value="yes">
                </div>
            </div>
            <?php endif ?>
            <div class="control-group">
                <label class="control-label">Reading Comprehension? </label>
                <div class="controls" style="margin-top: 5px">
                    <input type="checkbox" value="yes" id="is_read_passage_edit"
                           name="is_read_passage" style="bottom: 3px; margin-right: 5px; position: relative;">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body" id="read_passage_box">
        <div class="modal_down">
            <div class="control-group">
                <label class="control-label">Passage Title</label>

                <div class="controls">
                    <input type="text" name="read_title" id="read_title_edit" style="width: 90%" size="33">
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Passage Text</label>

                <div class="controls">
                    <textarea name="read_text" id="read_text_edit" cols="30" rows="5"></textarea>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Passage Image</label>
                <div id="read_image_preview_edit" class="read_image read_image_style pic1">
                    <div id="read_image_edit" class="image_holder" style="float: left; margin-left: 20px; position: relative">
                        <img class="img_to_upload" src="" style="display: none;"/>
                        <input type="hidden" name="read_image" class="image_name" id="read_image_name_edit"/>
                        <button class="btn btn-warning set_image_btn" style="margin: -25% 0px 0px 41%; position: absolute; width: 100px;">Set image</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="challenge_form_submit">Save changes</button>
    </div>
    <input type="hidden" id="my_challenges_redirection" name="my_challenges_redirection"/>
    <input type="hidden" name="id" id="edit_challenge_id_edit"/>
<?php echo form_close() ?>
<style>
    #challenge_form_edit input {width: 90%;}
    #challenge_form_edit select {width: 93%;}
    #challenge_form_edit textarea {width: 90%; max-width: none}
</style>