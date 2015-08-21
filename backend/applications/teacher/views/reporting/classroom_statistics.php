<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0 reporting">

        <?php /*
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Classrooms statistic by challenge</div>
                        <span class="tools">
                            <select id="challenge_id">
                                <?php foreach ($challenges as $challenge => $val): ?>
                                    <option <?php echo ($challenge[0]['challenge_id'] === $val['challenge_id'] ? 'selected="selected"' : '')?>
                                        value="<?php echo $val['challenge_id'] ?>"><?php echo $val['challenge_name']?></option>
                                <?php endforeach;?>
                            </select>
                        </span>
                    </div>
                    <div class="widget-body clearfix">
                        <div id="column_chart" style="position: relative;"></div>
                    </div>
                </div>
            </div> */ ?>

            <div class="row-fluid">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <div class="title">Statistics for classroom by challenges</div>
                        </div>
                        <div class="widget-body clearfix">
	                        <div id="challenge_filter_selector_holder">
		                        <span class="challenge_filter_caption">Class: </span>
		                        <div class="row-fluid">
		                            <select id="report_stats_challenge_class_select">
			                            <option value="0">Choose classroom</option>
		                                <?php foreach ($teacher_classes as $class => $val): ?>
		                                    <option value="<?php echo $val->getClassId() ?>"><?php echo $val->getName()?></option>
		                                <?php endforeach;?>
		                            </select>
		                        </div>

		                        <span class="challenge_filter_caption">Period: </span>
		                        <div class="row-fluid">
		                            <select id="report_stats_challenge_period_select">
			                            <option value="1">Current week</option>
			                            <option value="2">Last week</option>
			                            <option value="3">Current month</option>
			                            <option value="4">Last month</option>
			                            <option value="5">Last 3 months</option>
			                            <option value="6">Custom period</option>
		                            </select>
		                        </div>

	                            <span class="challenge_filter_caption report-stats-date">From: </span>
	                            <div class="row-fluid report-stats-date">
	                                <div class="input-prepend">
	                                    <span class="add-on" data-icon="&#xe053;" style="line-height: 24px"></span>
	                                    <input type="text" placeholder="Date From" name="from" id="report_stats_challenge_datepicker_from"/>
	                                </div>
	                            </div>

	                            <span class="challenge_filter_caption report-stats-date">To: </span>
	                            <div class="row-fluid report-stats-date">
	                                <div class="input-prepend">
	                                    <span class="add-on" data-icon="&#xe053;" style="line-height: 24px"></span>
	                                    <input type="text" placeholder="Date To" name="to" id="report_stats_challenge_datepicker_to"/>
	                                </div>
	                            </div>

	                        </div>
                            <div id="students_in_class_stats" style="position: relative;"></div>
                        </div>

						<!-- Challenges score wheels table -->
		                <div class="widget-body clearfix">
                            <table id="report_stats_challenge_table"
                                   class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
                                <thead>
	                                <tr role="row">
	                                    <th style="width: 258px;" rowspan="1" colspan="1">
		                                    Challenge Name
	                                    </th>
	                                    <th style="width: 305px;" rowspan="1" colspan="1">
		                                    Classroom average
	                                    </th>
	                                    <th style="width: 242px;" rowspan="1" colspan="1">
	                                        Overall average
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
