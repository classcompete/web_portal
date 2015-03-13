<div class="dashboard-wrapper">
    <div class="left-sidebar">
        <div class="row-fluid">
            <div class="col-lg-12 col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">
                            Change your teacher account password
                        </div>
                        <span class="tools">
                            <i class="fa fa-cogs"></i>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="row-fluid">
                            <div class="col-lg-12 col-md-12">
                                <form class="form-horizontal" autocomplete="off" id="change-password">
                                    <h5>Security Information</h5>
                                    <hr/>
                                    <div class="control-group">
                                        <label class="control-label" for="old_password">Old Password</label>

                                        <div class="controls">
                                            <input type="password" name="old_password" id="old_password"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="control-group">
                                        <label class="control-label" for="password">New Password</label>

                                        <div class="controls">
                                            <input type="password" name="password" id="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="new_password">Retype New Password</label>

                                        <div class="controls">
                                            <input type="password" name="new_password" id="new_password"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-actions">
                                        <button class="btn btn-info pull-right" type="submit">
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-control {
        background-color: #fff;
        background-image: none;
        border: 3px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        color: #555;
        display: block;
        font-size: 14px;
        height: 34px;
        line-height: 1.42857;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    }
</style>
<script type="text/javascript">
    $('#change-password').on('submit', function () {

        $('#change-password').find('button[type=submit]').html('Sending...');
        $.post('/v2/profile/passwordPut', $('#change-password').serialize(), function () {
            $.gritter.add({
                title: 'Great',
                text: 'Your password was changed successfully',
                sticky: false,
                time: 10000
            });
        }).always(function () {
            $('#change-password').find('button[type=submit]').html('Update Password');
        }).fail(function (jqXHR, textStatus, errorThrown) {
            try {
                response = $.parseJSON(jqXHR.responseText);
                if (response.error) {
                    message = response.error;
                } else {
                    message = "Please try again. If you keep seeing this message, contact us";
                }
            } catch(e) {
                message = "Please try again. If you keep seeing this message, contact us";
            }

            $.gritter.add({
                title: 'Ooups, something went wrong',
                text: message,
                sticky: false,
                time: 10000
            });
        });
        return false;
    });
</script>