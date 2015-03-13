<div class="dashboard-wrapper">
    <div class="left-sidebar">
        <div class="row-fluid">
            <div class="col-lg-12 col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">
                            Change your publisher profile Image and Biography
                        </div>
                        <span class="tools">
                            <i class="fa fa-cogs"></i>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="row-fluid">
                            <div class="span3 col-lg-5 col-md-5">
                                <h5>Profile Image</h5>
                                <hr/>
                                <div class="thumbnail">
                                    <img id="profileImage"
                                         src="<?php echo site_url('v2/profile/avatarGet') ?>"
                                         alt="300x200">
                                    <input type="hidden" id="profileImageUrl" name="teacher_avatar_url"/>
                                </div>
                                <button type="button" class="btn btn-large btn-info btn-block"
                                        id="profileImageTrigger">Upload Image
                                </button>
                            </div>
                            <div class="span9 col-lg-7 col-md-7">
                                <form class="form-horizontal" autocomplete="off" id="publisher-profile">
                                    <h5>Biography</h5>
                                    <hr/>
                                    <div class="control-group">
                                        <label class="control-label" for="biography">Bio</label>

                                        <div class="controls">
                                            <textarea rows="5" class="form-control" name="biography" id="biography"
                                                      style="height: 100px; width: 300px;"
                                                ><?php echo $profileData->getBiography() ?></textarea>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-actions">
                                        <button class="btn btn-info pull-right" type="submit">
                                            Update Publisher Profile
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
        border: 1px solid #ccc;
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

    $('#publisher-profile').on('submit', function(){
        $('#publisher-profile').find('button[type=submit]').html('Sending...');

        $.post('/v2/profile/publisherProfilePut', $('#publisher-profile').serialize(), function () {
            $.gritter.add({
                title: 'Great',
                text: 'Your publisher profile was updated successfully',
                sticky: false,
                time: 10000
            });
        }).always(function () {
            $('#publisher-profile').find('button[type=submit]').html('Update Publisher Profile');
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

    var avatarUpload = new plupload.Uploader({
        runtimes: 'html5,gears,html4',
        browse_button: 'profileImageTrigger',
        max_file_size: '512kb',
        unique_names: true,
        chunk_size: '100kb',
        multi_selection: false,
        url: BASEURL + 'v2/profile/avatarPut',
        filters: [
            {
                title: "Image files", extensions: "png"
            }
        ]
    });

    avatarUpload.init();

    avatarUpload.bind('Error', function (up, response) {
        console.log(up);
        var file_filters = up.settings.filters;
        var max_file_size = humanFileSizeAvatar(up.settings.max_file_size, 'KB');

        if (response.code === -600) {
            $.gritter.add({
                title: 'Error',
                text: response.message + ' Max file size is ' + max_file_size + '.'
            });
        } else if (response.code === -601) {
            $.gritter.add({
                title: 'Error',
                text: response.message + ' Allowed image extension is ' + file_filters.mime_types[0].extensions + '.'
            });
        } else {
            $.gritter.add({
                title: 'Error',
                text: response.message
            });
        }
    });

    avatarUpload.bind('UploadProgress', function (up, files) {
        var ajax_loader_url = BASEURL + 'assets/images/ajax_loader.gif';
        $('#profileImage').attr('src', ajax_loader_url);
    });


    avatarUpload.bind('FilesAdded', function (up, files) {
        while (up.files.length > 1) {
            up.removeFile(up.files[0]);
        }
        up.refresh();
        if (up.state != 2 & files.length > 0) {
            up.start();
        }
    });

    avatarUpload.bind('FileUploaded', function (up, file, response) {
        if (response.status === 200 && typeof response.response !== 'undefined') {

            var image_baseurl = BASEURL + 'upload/';
            var image = image_baseurl + response.response;
            $('#profileImage').attr('src', image);

            $('#profileImageUrl').val(response.response);
        }
    });

    function humanFileSizeAvatar(bytes, si) {
        var thresh = si ? 1024 : 1024;
        if (bytes < thresh) return bytes + ' B';
        var units = si ? ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        var u = -1;
        do {
            bytes /= thresh;
            ++u;
        } while (bytes >= thresh);
        return bytes.toFixed(1) + ' ' + units[u];
    }
</script>