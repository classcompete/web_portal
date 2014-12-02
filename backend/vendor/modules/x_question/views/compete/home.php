<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Question [ <?php echo $count_questions?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addQuestionAdmin" data-backdrop="static"
                       data-toggle="modal" id="addNewQuestionAdmin">Add New Question</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-question-admin">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal modal_absolute modal_wide" id="addQuestionAdmin" tabindex="-1"
                     role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add Question</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form_add_admin'); ?>
                    </div>
                </div>

                <div class="modal hide fade classmodal modal_absolute modal_wide" id="editQuestionAdmin" tabindex="-1"
                     role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Edit Question</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form_edit_admin'); ?>
                    </div>
                </div>
                <div class="modal hide fade classmodal modal_semiwide" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="addClassLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Resize and Crop image</h3>
                    </div>
                    <?php $this->load->view('form_crop'); ?>
                </div>
            </div>
        </div>
    </div>
</div>