<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Class Challenge [ <?php echo $count_challenge_class?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditChallengeClass" data-backdrop="static"
                       data-toggle="modal" id="addNewChallengeClass">Add New Class Challenge Class</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-challenge-class">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal" id="addEditChallengeClass" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Challenge Class</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>