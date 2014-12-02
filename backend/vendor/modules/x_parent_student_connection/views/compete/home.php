<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Connection [ <?php echo $count_connections ?> ]</div>
                <?php /*
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditConnection" data-backdrop="static"
                       data-toggle="modal" id="addNewConnection">Add New Connection</a>
                </span>
                */ ?>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-connection">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal" id="addEditConnection" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Connection</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>