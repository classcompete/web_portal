<?php echo form_open_multipart('', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

    <div class="control-group">
        <label class="control-label">Username</label>

        <div class="controls">
            <input type="text" name="username" id="t_username" value="" disabled/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Email</label>

        <div class="controls">
            <input type="text" name="email" id="t_email" value="" disabled/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">First name</label>

        <div class="controls">
            <input type="text" name="first_name" id="t_first_name" value="" disabled/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Last name</label>

        <div class="controls">
            <input type="text" name="last_name" id="t_last_name" value="" disabled/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">School</label>

        <div class="controls">
            <input type="text" name="p_school" id="t_school" value="" disabled/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Grade</label>

        <div class="controls">
            <input type="text" name="p_grade" id="t_grade" value="" disabled/>
        </div>
    </div>


    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" >Close modal</button>
    </div>

    <input type="hidden" name="id" id="edit_teacher_id"/>

    <input type="hidden" name="user" id="user_type" value="teacher"/>

<?php echo form_close() ?>