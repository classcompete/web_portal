<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Topic [ <?php echo $count_topics?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditSkill" data-backdrop="static"
                       data-toggle="modal" id="addNewSkill">Add New topic</a>
                </span>
            </div>

            <div class="widget-body clearfix">
                <div id="dt_example" class="example_alt_pagination mod-skill">
                    <?php echo $table ?>
                </div>
            </div>
            <div class="modal hide fade classmodal" id="addEditSkill" tabindex="-1" role="dialog"
                 aria-labelledby="addClassLabel"
                 aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3>Add/Edit Topic</h3>
                </div>
                <div class="modal-body">
                    <?php $this->load->view('form_skill'); ?>
                </div>
            </div>
        </div>
    </div>
</div>