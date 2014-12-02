<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Subtopic [ <?php echo $count_subtopics?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditTopic" data-backdrop="static"
                       data-toggle="modal" id="addNewTopic">Add New Subtopic</a>
                </span>
            </div>

            <div class="widget-body clearfix">
                <div id="dt_example" class="example_alt_pagination mod-topic">
                    <?php echo $table ?>
                </div>
                <div class="modal hide fade classmodal" id="addEditTopic" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Subtopic</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>