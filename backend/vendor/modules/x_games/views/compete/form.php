<?php echo form_open_multipart('games/save', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

<div class="control-group">
    <label class="control-label">Name</label>

    <div class="controls">
        <input type="text" name="name" id="name"/>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary">Save changes</button>
</div>

<input type="hidden" name="id" id="edit_game_id"/>

<?php echo form_close() ?>
