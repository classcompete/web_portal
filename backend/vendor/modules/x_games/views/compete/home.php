<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Environment [ <?php echo $count_games?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="<?php echo base_url('games/add_new') ?>"
                       data-original-title="" data-target="#addEditGame" data-backdrop="static"
                       data-toggle="modal" id="addNewGame">Add New Environment</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-games">
                    <?php echo $table ?>
                </div>
                <div class="modal hide fade classmodal" id="addEditGame" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Environment</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>