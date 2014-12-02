<?php echo form_open_multipart('challenge_builder/install', array('method' => 'post', 'class' => 'form-horizontal no-margin',
    'id' => 'install_challenge_form')) ?>
    <div class="modal-body">

        <div class="control-group">
            <label class="control-label">Select class</label>

            <div class="controls">
                <select name="class_id" id="add_class_id">
                    <option selected="selected" disabled="disabled">Select class...</option>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>

        <div id="no_classes" class="control-group" style="display: none">
            <span>This challenge is already added to all your classes</span>
        </div>

        <input type="hidden" name="challenge_id" id="challenge_install_id"/>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success" id="challenge_btn_install_to_class">Add to class</button>
        <button class="btn btn-info" id="challenge_btn_close" style="display: none"
                aria-hidden="true" data-dismiss="modal" type="button">Close
        </button>
    </div>

<?php echo form_close() ?>