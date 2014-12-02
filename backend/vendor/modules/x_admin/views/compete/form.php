<?php echo form_open_multipart('admin/save', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

<div class="control-group">
    <label class="control-label">Username</label>

    <div class="controls">
        <input type="text" name="username" id="username" value="<?php echo set_value('username') ?>"/>
    </div>
</div>

<div class="control-group">
    <label class="control-label">First name</label>

    <div class="controls">
        <input type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name') ?>"/>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Last name</label>

    <div class="controls">
        <input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name') ?>"/>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Email</label>

    <div class="controls">
        <input type="text" name="email" id="email" value="<?php echo set_value('email') ?>"/>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary">Save changes</button>
</div>

<input type="hidden" name="id" id="edit_admin_id"/>

<?php echo form_close() ?>
