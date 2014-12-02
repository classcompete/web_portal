<?php echo form_open_multipart('challenge_class/save',
    array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'challenge_class_form')) ?>

<div class="control-group">
    <label class="control-label">Challenge name</label>
    <div class="controls">
        <select name="challenge_id" id="dl_challenge_id"></select>
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Class name</label>
    <div class="controls">
        <select name="class_id" id="dl_challenge_class_id"></select>
        <span class="help-inline"></span>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" id="challenge_class_form_submit">Save changes</button>
</div>

<input type="hidden" name="id" id="edit_challenge_class_id"/>

<?php echo form_close() ?>
