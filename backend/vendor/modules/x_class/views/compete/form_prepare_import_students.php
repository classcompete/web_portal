<form enctype="multipart/form-data" id="student_import_form" class="form-horizontal no-margin"
      method="post" accept-charset="utf-8" action="<?php echo site_url('student_import/save')?>">
	<input type="hidden" id="stud_import_class_id" name="stud_import_class_id" value=""/>
    <div class="modal-body">
	    <div style="border-bottom: 1px solid #eeeeee; margin-bottom: 20px;">
		    <p>
			    First, upload Excel file (.xls, .xlsx) with the list of students you want to import. After that
			    list of all your's uploaded files will be shown. Next to the file you just uploaded click on Action/Import to import students.
		    </p>
		    <p>
			    You can download <a href="<?php echo site_url('images/students_import_example_1.xlsx') ?>" style="color: #ed6d49;">example of the well formed file here.</a> Please, assure exactly the same spreadsheet structure in your file for import.
		    </p>
	    </div>

        <div class="control-group">
            <label class="control-label">Import description</label>

            <div class="controls">
                <input type="text" id="stud_import_desc" name="stud_import_desc">
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">File to import students</label>

            <div class="controls">
                <input type="file" id="stud_import_file" name="stud_import_file">
                <span class="help-inline"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button id="student_import_form_submit" class="btn btn-primary">Upload file</button>
    </div>
</form>
