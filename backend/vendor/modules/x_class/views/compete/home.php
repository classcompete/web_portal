<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Class [ <?php echo $count_classes?>]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditClass"
                       data-toggle="modal" id="addNewClass" data-backdrop="static">Add New Class</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-classes">
                    <?php echo $table ?>
                </div>

                <div class="modal hide fade classmodal" id="addEditClass" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Class</h3>
                    </div>

                    <?php $this->load->view('form'); ?>
                </div>

                <div class="modal hide fade modal_wide classmodal" id="adminClassStatistic" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Class statistic</h3>
                    </div>
                    <?php $this->load->view('form_students_class_stats'); ?>
                </div>

	                <!-- Dialog: Average class scores by month -->
                <div class="modal hide fade modal_wide classmodal" id="adminClassStatsAverageMonth" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Average Class Scores by Month</h3>
                    </div>
                    <?php $this->load->view('form_class_stats_average_month'); ?>
                </div>

	                <!-- Dialog: Class scores increase by month -->
                <div class="modal hide fade modal_wide classmodal" id="adminClassStatsIncreaseMonth" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Class Scores Increase by Month</h3>
                    </div>
                    <?php $this->load->view('form_class_stats_increase_month'); ?>
                </div>

            </div>
        </div>
    </div>
</div>