<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0 reporting">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Statistics for Student by Challenges</div>
		                <span class="tools">
		                    <a class="btn btn-small btn-info" href="<?php echo site_url('statistics/drilldown') ?>"
		                       id="btnShowStatsDrilldown">Details</a>
		                </span>
                    </div>
                    <div class="widget-body clearfix">
                        <div id="challenge_filter_selector_holder">
                            <span class="challenge_filter_caption">Class: </span>

                            <div class="row-fluid">
                                <select id="stats_student_class_select">
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
                                <select id="stats_student_student_select"
                                    <?php echo (count($students) < 1) ? 'disabled="disabled"' : '' ?>>
                                    <?php if (count($students) < 1): ?>
                                        <option value="0" selected="selected">No students</option>
                                    <?php else: ?>
                                        <option value="0" selected="selected">Select student</option>
                                        <?php foreach ($students as $studentKey => $student): ?>
                                            <option value="<?php echo $student->getPropStudent()->getStudentId() ?>"
                                                <?php echo ($student->getPropStudent()->getStudentId() === intval(@$params['student_id'])) ? 'selected="selected"' : (@empty($params['student_id']) === true && $studentKey === 0) ? 'selected="selected"' : ''  ?>>
                                                <?php echo $student->getFirstName() . ' ' . $student->getLastName() ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>

                            <span class="challenge_filter_caption">Period: </span>

                            <div class="row-fluid">
                                <select id="stats_student_period_select">
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
                                           id="stats_student_datepicker_from"
                                           value="<?php echo @$params['from'] ?>"/>
                                </div>
                            </div>

                            <span class="challenge_filter_caption report-stats-date">To: </span>

                            <div class="row-fluid report-stats-date">
                                <div class="input-prepend">
                                    <span class="add-on" data-icon="&#xe053;" style="line-height: 24px"></span>
                                    <input type="text" placeholder="Date To" name="to"
                                           id="stats_student_datepicker_to"
                                           value="<?php echo @$params['to'] ?>"/>
                                </div>
                            </div>

                        </div>
                        <div id="students_in_class_stats" style="position: relative;"></div>
                    </div>

                    <!-- Challenges score wheels table -->
                    <div class="widget-body clearfix">
                        <table id="stats_student_table"
                               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable"
                               style="font-size:14px">
                            <thead>
                            <tr role="row">
                                <th style="width: 200px;" rowspan="1" colspan="1">
                                    Challenge Name
                                </th>
                                <th style="width: 250px; text-align: center" rowspan="1" colspan="1">
                                    Pre-test Score
                                </th>
                                <th style="width: 250px; text-align: center" rowspan="1" colspan="1">
                                    Average Score
                                </th>
                                <th style="width: 250px; text-align: center" rowspan="1" colspan="1">
                                    Classroom Average
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /*
									<tr>
										<td>Challenge</td>
										<td>
				                            <div class="pie-chart">
				                                <div class="chart-score-class-tab easyPieChart" data-percent="20"
				                                     style="width: 140px; height: 140px; line-height: 140px;">
				                                    20
				                                    <canvas width="140" height="140"></canvas>
				                                </div>
				                            </div>
										</td>
										<td>
				                            <div class="pie-chart">
				                                <div class="chart-score-overall-tab easyPieChart" data-percent="10"
				                                     style="width: 140px; height: 140px; line-height: 140px;">
				                                    10
				                                    <canvas width="140" height="140"></canvas>
				                                </div>
				                            </div>
										</td>
									</tr>
									*/ ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
