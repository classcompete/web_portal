<?php echo form_open_multipart('', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>
    <div class="modal-body">
        <div class="control-group">
            <label>Are you sure you want to remove this question?</label>
        </div>

        <input type="hidden" name="id" id="edit_challenge_id"/>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" id="question_btn_uninstall">Yes</button>
        <button class="btn btn-primary" data-dismiss="modal">No</button>
    </div>

<?php echo form_close() ?>