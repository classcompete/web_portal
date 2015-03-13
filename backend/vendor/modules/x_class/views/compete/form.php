<?php if (CC_APP === 'teacher'): ?>
    <div style="display: none;" class="debug">
        <?php
        $teacherId = TeacherHelper::getId();
        $teacher = PropTeacherQuery::create()->findOneByTeacherId($teacherId);

        $allowForm = false;
        $grades = $teacher->getPropTeacherGrades();
        if ($teacher->getCountry() !== '' && $grades->count() > 0 && $teacher->getSchoolId() > 0) {
            $allowForm = true;
        }

        ?>
    </div>
<?php endif ?>

<?php if (CC_APP === 'teacher' && @$allowForm === false): ?>
    <div class="modal-body">
        <div class="control-group">
            <p style="font-size: 16px; line-height: 100px; text-align: center">
                Your profile needs to be completed to add a classroom.
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="class_form_submit" onclick="window.location='/profile'">
                Complete my Profile
            </button>
        </div>
    </div>
<?php else: ?>
    <?php echo form_open_multipart('classes/save',
        array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'class_form')) ?>
    <div class="modal-body">
        <div class="control-group">
            <label class="control-label">Name</label>

            <div class="controls">
                <input type="text" name="name" id="name"/>
                <span class="help-inline"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Class Code</label>

            <div class="controls">
                <input type="text" name="class_code" id="auth_code"/>
                <span class="help-inline"></span>
                <span>
                    Use default or make your own. Provide this to students for use in the game.
                </span>
            </div>
        </div>
        <?php if (CC_APP === 'teacher'): ?>
            <div class="control-group">
                <label for="" class="control-label">Licenses</label>

                <div class="controls">
                    <select name="licenses" id="licenses"
                            data-max="<?php echo TeacherHelper::getAvailableLicenses() ?>">
                        <option value="2">2 licenses (free)</option>
                        <option value="5" disabled="disabled">5 licenses</option>
                        <option value="10" disabled="disabled">10 licenses</option>
                        <option value="15" disabled="disabled">15 licenses</option>
                        <option value="20" disabled="disabled">20 licenses</option>
                        <option value="25" disabled="disabled">25 licenses</option>
                        <option value="50" disabled="disabled">50 licenses</option>
                        <option value="100" disabled="disabled">100 licenses</option>
                    </select><br/>
                    </span>
                    <span class="help-inline"></span>
                <span>
                    If selection is disabled, that means you don't have enough licenses for that selection.
                    You can review licenses per class on <a href="/store" style="text-decoration: underline">Licenses
                        Page</a>
                </span>
                </div>
            </div>
        <?php endif ?>

        <?php if (CC_APP === 'admin'): ?>
            <div class="control-group">
                <label class="control-label">Select teacher</label>

                <div class="controls">
                    <select name="user_id" id="user_id">
                        <option selected="selected" disabled="disabled">Select teacher...</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Price</label>

                <div class="controls">
                    <input type="text" name="price" id="price" value="0"/>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Students limit</label>

                <div class="controls">
                    <input type="text" name="limit" id="limit" value="2"/>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="modal-footer">
        <?php if (CC_APP !== 'admin'): ?>
            <span class="text-info"
                  style="font-size: 13px; padding-left: 20px; position: relative; display: block; float: left; margin-top: -3px;">
                2 students are allowed for free/classroom<br>
                <a href="<?php echo site_url('store') ?>" style="text-decoration: underline">Purchase More</a> or
                <a href="<?php echo site_url('support') ?>" style="text-decoration: underline">Contact Us</a> for more seats
                <span style="position: absolute; top: 0px; left: 4px; font-size: 16px; line-height: 26px;">*</span>
            </span>
        <?php endif; ?>
        <button class="btn btn-primary" id="class_form_submit">Save changes</button>
    </div>

    <input type="hidden" name="class_id" id="edit_class_id"/>

    <?php echo form_close() ?>
<?php endif ?>