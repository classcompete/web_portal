<?php echo form_open_multipart('',
    array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'change_student_profile_form')) ?>
    <div class="modal-body">
        <div class="control-group">
            <label class="control-label">First Name <span class="required">*</span></label>

            <div class="controls">
                <input type="text" name="first_name" id="student_first_name" autocomplete="off"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Last Name <span class="required">*</span></label>

            <div class="controls">
                <input type="text" name="last_name" id="student_last_name" autocomplete="off"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Username <span class="required">*</span></label>

            <div class="controls">
                <input type="text" name="username" id="student_username" autocomplete="off"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Email <span class="required">*</span></label>

            <div class="controls">
                <input type="text" name="email" id="student_email" autocomplete="off"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Parent Email</label>

            <div class="controls">
                <input type="text" name="parent_email" id="student_parent_email" autocomplete="off"/>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <span style="font-size: 13px; padding-left: 20px; position: relative; display: block; float: left; margin-top: -3px;" class="text-info">
            Fields marked with asterisk (<strong>*</strong>) <br/>are mandatory
        </span>
        <input type="hidden" id="student_profile_change_user_id" name="user_id"/>
        <button class="btn btn-primary" id="student_profile_change_submit">Save changes</button>
    </div>

<?php echo form_close() ?>