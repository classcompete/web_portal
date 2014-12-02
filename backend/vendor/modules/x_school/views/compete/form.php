<?php echo form_open_multipart('school/save_school', array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'add_edit_school_form')) ?>

<div class="control-group">
    <label class="control-label">School name</label>

    <div class="controls">
        <input type="text" name="name" id="name"/>
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Country</label>

    <div class="controls">
        <input type="text" name="country" id="country"/>
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">State</label>

    <div class="controls">
        <input type="text" name="state" id="state"/>
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">City</label>

    <div class="controls">
        <input type="text" name="city" id="city"/>
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">County</label>

    <div class="controls">
        <input type="text" name="county" id="county"/>
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Zip code</label>

    <div class="controls">
        <input type="text" name="zip_code" id="zip_code"/>
        <span class="help-inline"></span>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Type</label>

    <div class="controls" id="public">
        <label>
            <input type="radio" value="public" name="public" id="public_school"/>
            Public
        </label>
        <label>
            <input type="radio" value="private" name="public" id="private_school"/>
            Private
        </label>
        <span class="help-inline"></span>
    </div>
</div>

<!--<div class="control-group">-->
<!--    <label class="control-label">Skill name</label>-->
<!---->
<!--    <div class="controls">-->
<!--        <select name="skill_id" id="skill_id">-->
<!--            <option value="" selected="selected" disabled="disabled">Select skill...</option>-->
<!--        </select>-->
<!--    </div>-->
<!--</div>-->

<div class="modal-footer">
    <button class="btn btn-primary" id="save_school_submit">Save changes</button>
</div>

<input type="hidden" name="approved" value="approved" id="approved"/>
<input type="hidden" name="school_id" id="edit_school_id"/>

<?php echo form_close() ?>
