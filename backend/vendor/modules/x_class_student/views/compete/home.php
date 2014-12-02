<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">

            <div class="widget-header">
                <div class="title">Student In Class [ <?php echo $count_class_student?> ]</div>
                <span class="tools">
                    <a style="color:black" class="btn btn-small" href="#"
                       data-original-title="" data-target="#addEditClassStudent" data-backdrop="static"
                       data-toggle="modal" id="addClassStudent">Add New Student To Class</a>
                </span>
            </div>

            <div class="widget-body clearfix">

                <div id="dt_example" class="example_alt_pagination mod-class-student">
                    <?php echo $table ?>
                </div>
                <div class="modal hide fade classmodal" id="addEditClassStudent" tabindex="-1" role="dialog"
                     aria-labelledby="addClassLabel"
                     aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add/Edit Class Students</h3>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('form'); ?>
                    </div>
                </div>

                <div aria-hidden="false" aria-labelledby="studentInfoLabel" role="dialog" tabindex="-1" id="studentInfo"
                     class="modal fade hide in modal_absolute" style="display: none;">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h3 id="studentInfoLabel">Student Information</h3>
                    </div>
                    <div class="modal-body no-padding">

                        <ul class="nav nav-tabs no-margin myTabBeauty">
                            <li class="active">
                                <a data-original-title="" href="#profile" data-toggle="tab">
                                    Profile
                                </a>
                            </li>

                        </ul>

                        <!-- student profile info -->
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane active" id="profile">

                                <div class="row-fluid">
                                    <div class="span3">

                                        <img id="profilepic" title="avatar" alt="avatar" width="227px" height="175px">

                                        <h5>User Name : <span id="student_username"></span></h5>
                                        <h5>Full Name : <span id="full_name"></span></h5>
                                        <h5>Email* : <span id="student_email"></span></h5>
                                        <h5 id="parent_email_holder">Parent Email : <span id="parent_email"></span></h5>

                                    </div>

                                    <div class="example_alt_pagination span9" id="dt_example">
                                        <div class="row-fluid column_chart_user_info">
                                            <div class="span12">
                                                <div class="widget chart_widget">
                                                    <div class="widget-header">
                                                        <div class="title">Column Chart</div>
                                                        <span class="tools"></span>
                                                    </div>
                                                    <div class="widget-body">
                                                        <div id="column_chart_student_info" style="position: relative;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div role="grid" class="dataTables_wrapper" id="class_student_stats_table_wrapper">

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>