<div class="dashboard-wrapper">
    <div class="left-sidebar">
        <div class="row-fluid">
            <div class="span9">
                <div class="widget">

                    <div class="widget-header">
                        <div class="title">Class Management</div>
                        <span class="tools">
                            <a class="btn btn-small btn-info" href="#"
                               data-original-title="" data-target="#addEditClassTeacher"
                               data-toggle="modal" id="addNewClassTeacher" data-backdrop="static">+ Add new class
                            </a>
                            <?php /* <a href="<?php echo site_url('student_import') ?>"
                               class="btn btn-small btn-info">
                               List of student imports
                            </a>*/ ?>
                        </span>
                    </div>

                    <div class="widget-body clearfix">

                        <div class="accordion no-margin mod-classes" id="accordion1">
                            <?php foreach ($class_list as $class): ?>
                                <div class="accordion-group">

                                    <div class="accordion-heading">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                                           data-parent="#accordion1"
                                           href="#collapse<?php echo $class['class_id'] ?>" data-original-title=""
                                           id="<?php echo $class['class_id'] ?>">
                                            <i class="icon-home"
                                               data-original-title=""></i>&nbsp;<?php echo $class['class_name'] ?>
                                        </a>
                                        <span class="tools">
                                            <a data-toggle="modal" data-target="#studentsInClassStats" data-icon="&#xe096"
                                               aria-hidden="true" class="fs1 students_in_class_stats_accordion"
                                               data-class-id="<?php echo $class['class_id'] ?>" data-backdrop="static"
                                               title="Stats for students in this class" href="#"></a>

                                            <a href="<?php echo site_url('#classes/refresh') . '/' . $class['class_id'] ?>"
                                               class="refresh" data-icon="&#xe11c;" title="Refresh Class"></a>
                                            <a data-toggle="modal" data-target="#addEditClassTeacher"
                                               data-original-title="" data-icon="&#xe023" aria-hidden="true" class="fs1 edit"
                                               title="Edit <?php echo $class['class_name'] ?>" data-backdrop="static"
                                               href="<?php echo site_url('#classes/edit') . '/' . $class['class_id'] ?>"></a>
                                        </span>
                                    </div>

                                    <div style="height: 0px;" id="collapse<?php echo $class['class_id'] ?>"
                                         class="accordion-body collapse">
                                        <div class="accordion-inner">
                                            <span class="tools" style="margin-right: -10px">
                                                <a href="<?php echo site_url('store')?>"
                                                   style="background: #ed6d49; font-weight: bold"
                                                   class="btn btn-small btn-info">
                                                    <?php echo $class['licenses_text'] ?> | Add More
                                                </a>

                                                <a class="btn btn-small btn-info btn-import-students-file" href="#"
					                               style="background: #ed6d49; font-weight: bold"
					                               data-original-title="" data-target="#dlgImportStudents"
					                               data-toggle="modal" data-backdrop="static"
					                               data-class-id="<?php echo $class['class_id'] ?>">
						                           Import students to this class
					                            </a>
                                            </span>
                                            <div class="span9">
                                                <h5>
                                                    <span id="accordion_list_count<?php echo $class['class_id'] ?>">
                                                    </span> Students Enrolled
                                                </h5>
                                                <ul id="accordion_list<?php echo $class['class_id'] ?>"
                                                    data-classid="<?php echo $class['class_id'] ?>"></ul>
                                            </div>
                                            <div class="span3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="modal hide fade classmodal" id="addEditClassTeacher" tabindex="-1" role="dialog"
                             aria-labelledby="addClassLabel"
                             aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                <h3>Add/Edit Class</h3>
                            </div>

                            <?php $this->load->view('form'); ?>
                        </div>

							<!-- Import students dialog -->
	                    <div class="modal hide fade classmodal" id="dlgImportStudents" tabindex="-1" role="dialog"
                             aria-labelledby="addClassLabel"
                             aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Prepare student import</h3>
	                            <h4>for class <span class="import-class-name" style="color: #ed6d49;"></span></h4>
                            </div>

                            <?php $this->load->view('x_class/' . config_item('teacher_template'). '/form_prepare_import_students'); ?>
                        </div>

                        <div class="modal hide fade classmodal" id="addEditClassStudent" tabindex="-1" role="dialog"
                             aria-labelledby="addClassLabel"
                             aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                <h3>Add/Edit Class Students</h3>
                            </div>

                            <?php $this->load->view('form_students'); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Classroom Averages</div>
                    </div>
                    <div class="widget-body">
                        <div class="wrapper">
                            <ul class="progress-statistics">
                                <?php if (isset($class_statistic) === true && empty($class_statistic) === false): ?>
                                    <?php foreach ($class_statistic as $class => $val): ?>
                                        <li>
                                            <div class="details">
                                                <span><?php echo $val['class_name']?></span>
                                                <span class="pull-right"><?php echo $val['class_statistic']?>%</span>
                                            </div>
                                            <div class="progress  progress-striped active">
                                                <div style="width: <?php echo $val['class_statistic'] ?>%;" class="bar">
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-sidebar">
        <div class="wrapper">
            <div class="viewport">
                <div class="overview">
                    <div class="featured-articles-container featured-articles-container_min_height">
                        <h5 class="heading">Video Support - Classroom</h5>
                        <div>
                            <a href="#" data-toggle="modal" data-target="#introVideo">
                                <img src="http://i.ytimg.com/vi/krsBMGULJKw/mqdefault.jpg" />
                            </a>
                            <br/><br/>
                        </div>

	                    <?php /*
                        <h5 class="heading">Classroom Wizard</h5>
                        <div class="articles">
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('classes')?>">Click "Add Class"</a>
                            </a>
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('classes')?>">Create a Fun Class Name</a>
                            </a>
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('classes')?>">Give Your Class Code to Students</a>
                            </a>
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('marketplace')?>">Assign Challenges</a>
                            </a>
                            <a data-original-title="">
                                <span class="label-bullet">&nbsp;</span>
                                <a href="<?php echo site_url('reporting/basic')?>">See the Results</a>
                            </a>
                        </div>
                        */ ?>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-stylish-1">
    </div>
</div>
<div aria-hidden="false" aria-labelledby="studentInfoLabel" role="dialog" tabindex="-1" id="studentInfo"
     class="modal fade hide in modal_absolute" style="display: none; top: 95px!important;">
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

                        <h5>User Name : <span id="username"></span></h5>
                        <h5>Full Name : <span id="full_name"></span></h5>
                        <h5>Email* : <span id="email"></span></h5>
                        <h5 id="parent_email_holder">Parent Email : <span id="parent_email"></span></h5>

                    </div>

                    <div class="example_alt_pagination span9" id="dt_example">
                        <div class="row-fluid column_chart_user_info">
                            <div class="span12">
                                <div class="widget chart_widget">
                                    <div class="widget-header">
                                        <div class="title">Averages</div>
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

<div class="modal hide fade classmodal" id="passwordChange" tabindex="-1" role="dialog" aria-labelledby="addClassLabel"
     aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Password change</h3>
    </div>

    <?php $this->load->view('form_change_student_password'); ?>
</div>

<div class="modal hide fade classmodal" id="profileChange" tabindex="-1" role="dialog" aria-labelledby="addClassLabel"
     aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Change student details</h3>
    </div>

    <?php $this->load->view('form_change_student_profile'); ?>

</div>

<div class="modal hide fade classmodal" id="removeStudentFromClass" tabindex="-1" role="dialog"
     aria-labelledby="addClassLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Remove student</h3>
    </div>

    <?php $this->load->view('form_remove_student'); ?>

</div>

<div class="modal hide fade modal_wide classmodal" id="studentsInClassStats" tabindex="-1" role="dialog"
     aria-labelledby="addClassLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Classroom averages</h3>
    </div>

    <?php $this->load->view('form_students_class_stats'); ?>

</div>

<div class="modal hide fade" id="introVideo" tabindex="-1" role="dialog" style="width: 830px; margin-left: -415px; top:5px" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    How to use ClassCompete?
                </div>
            </div>
            <div class="widget-body">
                <iframe width="800" height="600" src="//www.youtube-nocookie.com/embed/U3gmOE4KOVQ?rel=0&amp;showinfo=0"
                        frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
	    $('a.accordion-toggle:first').trigger('click');
    });

    <?php if(isset($_GET['failure']) && empty($_GET['failure']) === false): ?>
        setTimeout(function(){
            var error = '<?php echo str_replace("\n",'\n', base64_decode($_GET['failure']))?>';
            alert(error.replace('\n', "\n"));
        }, 500);
    <?php endif ?>

    <?php if(isset($_GET['success']) && empty($_GET['success']) === false): ?>
    setTimeout(function(){
        var error = '<?php echo str_replace("\n",'\n', base64_decode($_GET['success']))?>';
        alert(error.replace('\n', "\n"));
    }, 500);
    <?php endif ?>
</script>