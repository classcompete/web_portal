<form enctype="multipart/form-data" id="student_import_form" class="form-horizontal no-margin"
      method="post" accept-charset="utf-8" action="<?php echo site_url('student_import/save') ?>">
    <input type="hidden" id="stud_import_class_id" name="stud_import_class_id" value=""/>

    <div class="modal-body" style="overflow: hidden">
        <div style="border-bottom: 1px solid #eeeeee; margin-bottom: 20px;">
            <p style="font-size: 14px;">
                <strong>Step 1</strong>:
                Download <a href="<?php echo site_url('images/students_import_example_1.xlsx') ?>" style="color: #ed6d49;"
                            target="_blank">example of the import file here</a>. Please, only use this file for import.
                <br/><br/>
                <strong>Step 2</strong>:
                Remove the sample students and replace with your students. Do NOT delete the headings.
                <br/><br/>
                <strong>Step 3</strong>:
                Save the file a new name you will remember like “studentimport2015”
                <br/>
                <em>
                    *The file has to be an Excel File or CSV file. If you are using Numbers or Google Sheets please save
                    the file in these formats
                </em>
                <br/><br/>
                <strong>Upload the file and import, that’s it!</strong>
                <br/>
                The file format is important so if any issues, just try again, or if you get stuck just email our
                support. You can copy paste all the student info and we will try for you.
            </p>
        </div>

        <?php /* <div class="control-group">
            <label class="control-label">Import description</label>

            <div class="controls">
                <input type="text" id="stud_import_desc" name="stud_import_desc">
                <span class="help-inline"></span>
            </div>
        </div>*/ ?>
        <div class="control-group">
            <h5>Import file</h5>
            <input type="file" id="stud_import_file" name="stud_import_file">
        </div>
    </div>
    <div class="modal-footer">
        <button id="student_import_form_submit" class="btn btn-primary">Upload file</button>
    </div>
</form>
