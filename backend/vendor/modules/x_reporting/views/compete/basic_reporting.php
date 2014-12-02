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
                            <div class="title">Students statistics by classroom</div>
                        <span class="tools">
                            <select id="student_stats_class_id">
                                <?php foreach ($teacher_classes as $class => $val): ?>
                                    <option value="<?php echo $val->getClassId() ?>"><?php echo $val->getName()?></option>
                                <?php endforeach;?>
                            </select>
                        </span>
                        </div>
                        <div class="widget-body clearfix">
                            <div id="students_in_class_stats" style="position: relative;"></div>
                        </div>
                    </div>
                </div>

            <div class="span5">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Top 3 Challenges</div>
                    </div>
                    <div class="widget-body">
                        <div class="easy-pie-charts-container" style="padding: 35px 30px;">
                            <?php if (isset($top_challenges) === true && empty($top_challenges) === false): ?>
                                <?php foreach ($top_challenges as $challenge => $val): ?>
                                    <div class="pie-chart">
                                        <div class="chart<?php echo $challenge + 1 ?> easyPieChart"
                                             data-percent="<?php echo $val['played_times_percent'] ?>"
                                             style="width: 140px; height: 140px; line-height: 140px;">
                                            <?php echo $val['played_times_percent']?>%
                                            <canvas width="140" height="140"></canvas>
                                        </div>
                                        <p class="name"><?php echo $val['challenge_name']?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif?>
                            <div class="clearfix">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span5">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Top 3 classes</div>
                    </div>
                    <div class="widget-body">
                        <div class="easy-pie-charts-container" style="padding: 35px 30px;">
                            <?php if (isset($class_statistic) === true && empty($class_statistic) === false): ?>
                                <?php foreach ($class_statistic as $class => $val): ?>
                                    <div class="pie-chart">
                                        <div class="chart<?php echo $class + 1 ?> easyPieChart"
                                             data-percent="<?php echo $val['class_statistic'] ?>"
                                             style="width: 140px; height: 140px; line-height: 140px;">
                                            <?php echo $val['class_statistic']?>%
                                            <canvas width="140" height="140"></canvas>
                                        </div>
                                        <p class="name"><?php echo $val['class_name']?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif;?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span5">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Top 3 students by classroom</div>
                        <span class="tools">
                            <select id="class_id_top_3_students">
                                <?php foreach ($teacher_classes as $class => $val): ?>
                                    <option value="<?php echo $val->getClassId() ?>"><?php echo $val->getName()?></option>
                                <?php endforeach;?>
                            </select>
                        </span>
                    </div>
                    <div class="widget-body" style="min-height: 250px;">
                        <div class="easy-pie-charts-container" id="top_3_students_charts" style="padding: 35px 30px;">
                            <?php if (isset($top_three_students) === true && empty($top_three_students) === false): ?>
                                <?php foreach ($top_three_students as $student => $val): ?>
                                    <div class="pie-chart">
                                        <div class="chart<?php echo $student + 1 ?> easyPieChart"
                                             data-percent="<?php echo $val['result'] ?>"
                                             style="width: 140px; height: 140px; line-height: 140px;">
                                            <?php echo $val['result']?>%
                                            <canvas width="140" height="140"></canvas>
                                        </div>
                                        <p class="name"><?php echo $val['name']?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif;?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span5">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Bottom 3 students by classroom</div>
                        <span class="tools">
                            <select id="class_id_bottom_3_students">
                                <?php foreach ($teacher_classes as $class => $val): ?>
                                    <option value="<?php echo $val->getClassId() ?>"><?php echo $val->getName()?></option>
                                <?php endforeach;?>
                            </select>
                        </span>
                    </div>
                    <div class="widget-body" style="min-height: 250px;">
                        <div class="easy-pie-charts-container" id="bottom_3_students_charts" style="padding: 35px 30px;">
                            <?php if (isset($bottom_three_students) === true && empty($bottom_three_students) === false): ?>
                                <?php foreach ($bottom_three_students as $student => $val): ?>
                                    <div class="pie-chart">
                                        <div class="chart<?php echo $student + 1 ?> easyPieChart"
                                             data-percent="<?php echo $val['result'] ?>"
                                             style="width: 140px; height: 140px; line-height: 140px;">
                                            <?php echo $val['result']?>%
                                            <canvas width="140" height="140"></canvas>
                                        </div>
                                        <p class="name"><?php echo $val['name']?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif;?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php /* <div class="span12 margin_left_0">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title"><span data-icon="" aria-hidden="true" class="fs1"></span> States Running
                            Challenges
                        </div>
                    </div>
                    <div class="widget-body">
                        <div id="geo_chart" style="position: relative; height: 400px"></div>
                    </div>
                </div>
            </div> */ ?>
        </div>

    </div>

</div>
<script>
    var challenge_class_statistic = <?php echo json_encode($challenge_class_statistic)?>;

    /* function geochart() {
        google.load('visualization', '1', {'packages': ['geochart']});
        google.setOnLoadCallback(drawRegionsMap);


        function drawRegionsMap() {

            var data = google.visualization.arrayToDataTable(
                <?php echo json_encode($geoChartData)?>
            );


            var options = {
                region: 'US',
                enableRegionInteractivity: true,
                resolution: 'provinces'
            };

            var chart = new google.visualization.GeoChart(document.getElementById('geo_chart'));
            chart.draw(data, options);


        }
    }
    geochart(); */
</script>