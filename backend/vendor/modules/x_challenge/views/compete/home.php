<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Challenge [ <?php echo $count_challenges?> ]</div>
                <span class="tools">
                </span>
            </div>

            <div class="widget-body clearfix">
                <div id="dt_example" class="example_alt_pagination mod-challenge-admin">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal modal_absolute" id="addEditChallengeAdmin" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Challenge</h3>
                    </div>

                    <?php $this->load->view('form'); ?>

                </div>
            </div>
        </div>
    </div>
</div>