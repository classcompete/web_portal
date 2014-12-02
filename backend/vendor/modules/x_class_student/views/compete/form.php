<?php echo form_open_multipart('class_student/save',
    array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'class_student_form')) ?>

<div class="control-group">
    <label class="control-label">Select class</label>

    <div class="controls">
        <select name="class_id" id="dl_class_id">
            <option value="" selected="selected" disabled="disabled">Select class...</option>
        </select>
        <span class="help-inline"></span>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Select student</label>

    <div class="controls">
        <select name="user_id" id="dl_student_id">
            <option value="" selected="selected" disabled="disabled">Select student...</option>
        </select>
        <span class="help-inline"></span>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" id="class_student_form_submit">Save changes</button>
</div>
<input type="hidden" name="class_student_id" id="edit_classstud_id"/>

<?php echo form_close() ?>