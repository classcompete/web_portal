<?php echo form_open_multipart('',
    array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'change_student_password_form')) ?>
    <div class="modal-body">
        <div class="control-group">
            <label class="control-label">Password</label>

            <div class="controls">
                <input type="password" name="password" id="user_password" autocomplete="off"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Retype password</label>

            <div class="controls">
                <input type="password" name="repassword" id="user_repassword" autocomplete="off"/>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="student_password_change_user_id" name="user_id"/>
        <button class="btn btn-primary" id="student_password_change_submit">Save changes</button>
    </div>

<?php echo form_close() ?>