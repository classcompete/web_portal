<?php echo form_open_multipart('users/save', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

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

    <div class="control-group grade_holder_registration">
        <div class="controls clearfix">
            <span class="help-inline">Select grades you are teaching</span>
        </div>
        <div class="controls grade_holder clearfix">
            <label class="span2">
                <input id="pre_k" class="input" type="checkbox" name="grade[-2]"/>Pre - K
            </label>
            <label class="span2">
                <input id="k" class="input" type="checkbox" name="grade[-1]"/>K
            </label>
        </div>
        <div class="controls grade_holder clearfix">
            <label class="span2">
                <input id="1" class="input" type="checkbox" name="grade[1]"/>Grade 1
            </label>
            <label class="span2">
                <input id="2" class="input" type="checkbox" name="grade[2]"/>Grade 2
            </label>
            <label class="span2">
                <input id="3" class="input" type="checkbox" name="grade[3]"/>Grade 3
            </label>
            <label class="span2">
                <input id="4" class="input" type="checkbox" name="grade[4]"/>Grade 4
            </label>
        </div>
        <div class="controls grade_holder clearfix">
            <label class="span2">
                <input id="5" class="input" type="checkbox" name="grade[5]"/>Grade 5
            </label>
            <label class="span2">
                <input id="6" class="input" type="checkbox" name="grade[6]"/>Grade 6
            </label>
            <label class="span2">
                <input id="7" class="input" type="checkbox" name="grade[7]"/>Grade 7
            </label>
            <label class="span2">
                <input id="8" class="input" type="checkbox" name="grade[8]"/>Grade 8
            </label>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            Zip code
        </div>
        <div class="controls">
            <input class="input span2" type="text" placeholder="Type zip code" id="zip_code"
                   name="zip_code" tabindex="7"/>
        </div>
    </div>
    <div class="control-group">
        <input type="hidden" id="school_id" name="school_id">
        <div class="control-label">
            School name
        </div>
        <div class="controls">
            <input class="input span2 password" placeholder="Type your school name" type="text"
                   id="school_name" name="school_name" tabindex="8"/>
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Publisher</label>

        <div class="controls">
            <input type="checkbox" name="publisher" id="publisher"  />
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary">Save changes</button>
    </div>

    <input type="hidden" name="id" id="edit_teacher_id"/>

    <input type="hidden" name="user" id="user_type" value="teacher"/>

<?php echo form_close() ?>