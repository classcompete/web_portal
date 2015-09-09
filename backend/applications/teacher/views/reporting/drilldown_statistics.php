<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0 reporting">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Student Details Table</div>
                    </div>
                    <div class="widget-body clearfix">
                        <div id="challenge_filter_selector_holder">
                            <span class="challenge_filter_caption">Class: </span>

                            <div class="row-fluid">
                                <select id="stats_drilldown_class_select">
                                    <option value="0">Choose classroom</option>
                                    <?php foreach ($teacher_classes as $class => $val): ?>
                                        <option value="<?php echo $val->getClassId() ?>"
                                            <?php echo ($val->getClassId() === intval(@$params['class_id'])) ? 'selected="selected"' : (@empty($params['class_id']) === true && $class === 0) ? 'selected="selected"' : ''  ?>>
                                            <?php echo $val->getName() ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <span class="challenge_filter_caption">Student: </span>

                            <div class="row-fluid">
                                <select id="stats_drilldown_student_select"
                                    <?php echo (count($students) < 1) ? 'disabled="disabled"' : '' ?>>
                                    <?php if (count($students) < 1): ?>
                                        <option value="0" selected="selected">No students</option>
                                    <?php else: ?>
                                        <option value="0" selected="selected">Select student</option>
                                        <?php foreach ($students as $studentKey => $student): ?>
                                            <option value="<?php echo $student->getPropStudent()->getStudentId() ?>"
                                                <?php echo ($student->getPropStudent()->getStudentId() === intval(@$params['student_id'])) ? 'selected="selected"' : (@empty($params['student_id']) === true && $studentKey === 0) ? 'selected="selected"' : '' ?>>
                                                <?php echo $student->getFirstName() . ' ' . $student->getLastName() ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>

                            <span class="challenge_filter_caption">Period: </span>

                            <div class="row-fluid">
                                <select id="stats_drilldown_period_select">
                                    <option
                                        value="1" <?php echo (intval(@$params['period_type']) === 1) ? 'selected="selected"' : '' ?>>
                                        Current week
                                    </option>
                                    <option
                                        value="2" <?php echo (intval(@$params['period_type']) === 2) ? 'selected="selected"' : '' ?>>
                                        Last week
                                    </option>
                                    <option
                                        value="3" <?php echo (intval(@$params['period_type']) === 3) ? 'selected="selected"' : '' ?>>
                                        Current month
                                    </option>
                                    <option
                                        value="4" <?php echo (intval(@$params['period_type']) === 4) ? 'selected="selected"' : '' ?>>
                                        Last month
                                    </option>
                                    <option
                                        value="5" <?php echo (intval(@$params['period_type']) === 5) ? 'selected="selected"' : (@empty($params['period_type']) === true) ? 'selected="selected"' : '' ?>>
                                        Last 3 months
                                    </option>
                                    <option
                                        value="6" <?php echo (intval(@$params['period_type']) === 6) ? 'selected="selected"' : '' ?>>
                                        Custom period
                                    </option>
                                </select>
                            </div>

                            <span class="challenge_filter_caption report-stats-date">From: </span>

                            <div class="row-fluid report-stats-date">
                                <div class="input-prepend">
                                    <span class="add-on" data-icon="&#xe053;" style="line-height: 24px"></span>
                                    <input type="text" placeholder="Date From" name="from"
                                           id="stats_drilldown_datepicker_from"
                                           value="<?php echo @$params['from'] ?>"/>
                                </div>
                            </div>

                            <span class="challenge_filter_caption report-stats-date">To: </span>

                            <div class="row-fluid report-stats-date">
                                <div class="input-prepend">
                                    <span class="add-on" data-icon="&#xe053;" style="line-height: 24px"></span>
                                    <input type="text" placeholder="Date To" name="to"
                                           id="stats_drilldown_datepicker_to"
                                           value="<?php echo @$params['to'] ?>"/>
                                </div>
                            </div>

                        </div>
                        <div id="students_in_class_stats" style="position: relative;"></div>
                    </div>

                    <!-- Student drilldown table -->
                    <div class="widget-body clearfix">

                        <div class="example_alt_pagination dt_example">
                            <div role="grid" class="dataTables_wrapper" id="stats_drilldown_table_wrapper">

                            <?php /*
		                        <table id="stats_drilldown_table"
		                               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable"
		                               style="font-size:14px">
                                    <thead>
	                                    <tr role="row">
	                                        <th style="width: 200px;" class="sorting" rowspan="1" colspan="1">
		                                        Date
	                                        </th>
	                                        <th style="width: 200px;" class="sorting" rowspan="1" colspan="1">
		                                        Challenge Name
	                                        </th>
	                                        <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                                            Percentage
	                                        </th>
	                                        <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                                            Correct Answers
	                                        </th>
	                                        <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                                            Incorrect Answers
	                                        </th>
	                                        <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                                            Time on Course
	                                        </th>
	                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>07/20/2015 02:51 pm</td>
                                            <td>challenge name 1</td>
                                            <td>100</td>
                                            <td>5</td>
	                                        <td>0</td>
	                                        <td>00:05:54</td>
                                        </tr>
                                    </tbody>
                                </table>
							*/ ?>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
