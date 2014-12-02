<div class="dashboard-wrapper">

    <div class="left-sidebar">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget no-margin">
                    <div class="widget-header">
                        <div class="title">
                            Edit Profile
                        </div>
                        <span class="tools">
                            <a class="fs1" aria-hidden="true" data-icon="&#xe090;"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="container-fluid">

                            <div class="row-fluid">
                                <div class="span3"></div>
                                <div class="span9">
                                    <?php echo form_open_multipart('admin/password_update', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>
                                    <h5>Change Password</h5>
                                    <hr>

                                    <div class="control-group">
                                        <label class="control-label">Old Password</label>

                                        <div class="controls">
                                            <input type="password" name="old_password"/>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">New Password</label>

                                        <div class="controls">
                                            <input type="password" name="password1"/>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Confirm Password</label>

                                        <div class="controls">
                                            <input type="password" name="password2"/>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-info">Save changes</button>
                                        <button type="button" class="btn">Cancel</button>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-sidebar">
        <div class="action1">Right Sidebar Widget</div>
        <hr class="hr-stylish-1">
        <div class="action2">Right Sidebar Widget 2</div>
    </div>
</div>