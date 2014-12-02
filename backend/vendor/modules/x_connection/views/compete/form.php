<?php echo form_open_multipart('connection/save', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

    <div class="control-group">
        <label class="control-label">From user</label>

        <div class="controls">
            <select name="from_user" id="from_user_id">
                <option selected="selected" disabled="disabled">Select user...</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">To user</label>

        <div class="controls">
            <select name="to_user" id="to_user_id">
                <option selected="selected" disabled="disabled">Select user...</option>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Status</label>

        <div class="controls">
            <select name="status" id="status">
                <option selected="selected" disabled="disabled">Select status...</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary">Save status</button>
    </div>

    <input type="hidden" name="connection_id" id="edit_connection_id"/>

<?php echo form_close() ?>