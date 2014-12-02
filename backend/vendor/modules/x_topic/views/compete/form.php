<?php echo form_open_multipart('topic/save', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

<div class="control-group">
    <label class="control-label">Subtopic name</label>
    <div class="controls">
        <input type="text" name="name" id="name" value="<?php echo set_value('name') ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label">Skill name</label>

    <div class="controls">
        <select name="skill_id" id="skill_id">
            <option value="" selected="selected" disabled="disabled">Select skill...</option>
        </select>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary">Save changes</button>
</div>

<input type="hidden" name="edit_topic_id" id="edit_topic_id"/>

<?php echo form_close() ?>
