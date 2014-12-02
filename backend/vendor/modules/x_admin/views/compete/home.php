<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Admins</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="<?php echo base_url('admin/add_new') ?>"
                       data-original-title="" data-target="#addEditAdmin"
                       data-toggle="modal" id="addNewAdmin" data-backdrop="static">Add New Admin</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-admin">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal" id="addEditAdmin" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Admin</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>