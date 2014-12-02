<?php echo form_open_multipart('', array('method' => 'post', 'class' => 'form-horizontal no-margin', 'id' => 'image_crop_form')) ?>
    <div class="modal-body">
        <button class="btn btn-warning" id="question_image_upload" style="z-index: 999999;">Upload image</button>

        <div id="crop_wrapper" class="clearfix">
            <small class="image_zoom_slider_caption" style="display: none">Image zoom</small>
            <div id="image_zoom_slider"></div>

            <small>Drag the image to adjust its position</small>
            <div id="crop_image_wrapper">
                <img id="crop_image" class="crop_image" style="display: none"/>
            </div>

        </div>

        <small class="image_bg_colorpicker_caption">Select background color</small>
        <input type="text" class="colorPicker {styleElement:'crop_image_wrapper',pickerClosable:true}"
               title="Choose image background color" id="image_bg_colorpicker"/>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="reset_position">Reset position</button>
        <button class="btn btn-primary" id="crop_image_submit">Done</button>
    </div>

    <input type="hidden" name="image" id="crop_image_name"/>

<?php echo form_close() ?>