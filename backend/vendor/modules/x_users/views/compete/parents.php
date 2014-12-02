<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Parents [ <?php echo $count_parents ?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditUser" data-backdrop="static"
                       data-toggle="modal" id="addNewParent">Add New Parent</a>
                    <a style="color:black" class="btn btn-small" href="<?php echo site_url('users/parents_export')?>"
                        >Export Parents</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-student">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal" id="addEditUser" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Parent</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form_parents'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>