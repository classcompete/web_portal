<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Teachers [ <?php echo $count_teacher?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditUser" data-backdrop="static"
                       data-toggle="modal" id="addNewTeacher">Add New Teacher</a>
                    <a style="color:black" class="btn btn-small" href="<?php echo site_url('users/teachers_export')?>"
                       >Export Teachers</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-teacher">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal modal_absolute modal_wide" id="addEditUser" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Teacher</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form_teachers'); ?>
                    </div>
                </div>
                <div class="modal hide fade classmodal" id="ProfileView" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Teacher profile view</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form_teachers_profile'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>