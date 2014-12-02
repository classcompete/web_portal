<div class="dashboard-wrapper">

    <div class="left-sidebar">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="row-fluid">
                            <div class="metro-nav">
                                <div class="metro-nav-block nav-block-orange margin_bottom_0">
                                    <a href="<?php //echo base_url('class_student')?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $total_teacher_studetns?></div>
                                        <div class="brand">Total Students</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-yellow margin_bottom_0">
                                    <a href="<?php echo base_url('classes')?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $total_classes?></div>
                                        <div class="brand">Total Classes</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-blue double margin_bottom_0">
                                    <a href="<?php echo base_url('challenge')?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $total_teacher_challenges?></div>
                                        <div class="brand">Total Challenges</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-green margin_bottom_0">
                                    <a href="<?php echo base_url('reporting/basic') ?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"></div>
                                        <div class="brand">Reports</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-red margin_bottom_0">
                                    <a href="<?php echo base_url('marketplace') ?>" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info"><?php echo $challenges_in_market ?></div>
                                        <div class="brand">Marketplace</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span9">
<!--                <div class="widget">-->
<!--                    <div class="widget-header">-->
<!--                        <div class="title">Top 5 Challenges</div>-->
<!--                    </div>-->
<!--                    <div class="widget-body">-->
<!--                        <div class="easy-pie-charts-container" style="padding: 35px 30px;">-->
<!--                            --><?php //if(isset($top_challenges) === true && empty($top_challenges) === false):?>
<!--                                --><?php //foreach($top_challenges as $challenge=>$val):?>
<!--                                    <div class="pie-chart">-->
<!--                                        <div class="chart--><?php //echo $challenge+1?><!-- easyPieChart" data-percent="--><?php //echo $val['played_times_percent']?><!--" style="width: 140px; height: 140px; line-height: 140px;">-->
<!--                                            --><?php //echo $val['played_times_percent']?><!--%-->
<!--                                            <canvas width="140" height="140"></canvas>-->
<!--                                        </div>-->
<!--                                        <p class="name">--><?php //echo $val['challenge_name']?><!--</p>-->
<!--                                    </div>-->
<!--                                --><?php //endforeach;?>
<!--                            --><?php //endif?>
<!--                            <div class="clearfix">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="span12 margin_left_0">
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
                </div>
            </div>

            <div class="span3">
                <div class="widget class_compete_total_fit">
                    <div class="widget-header">
                        <div class="title">Class Compete Total</div>
                    </div>
                    <div class="widget-body">
                        <div class="wrapper">
                            <ul class="stats">
                                <li>
                                    <div class="left">
                                        <h4>
                                            <?php echo $total_challenge?>
                                        </h4>
                                        <p>
                                            Total challenges
                                        </p>
                                    </div>
                                    <div class="chart">
                                        <span id="total_challenges_sparkline"><?php echo $total_challenge_sparkline?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="left">
                                        <h4>
                                            <?php echo $total_teacher?>
                                        </h4>
                                        <p>
                                            Total teachers
                                        </p>
                                    </div>
                                    <div class="chart">
                                        <span id="total_teachers_sparkline"><?php echo $total_teacher_sperkline?></canvas></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="left">
                                        <h4>
                                            <?php echo $total_students?>
                                        </h4>
                                        <p>
                                            Total students
                                        </p>
                                    </div>
                                    <div class="chart">
                                        <span id="total_students_sparkline"><?php echo $total_students_sparkline?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="left">
                                        <h4>
                                        </h4>
                                        <p>
                                        </p>
                                    </div>
                                    <div class="chart">
                                    </div>
                                </li>
                                <li>
                                    <div class="left">
                                        <h4>
                                        </h4>
                                        <p>
                                        </p>
                                    </div>
                                    <div class="chart">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        <div class="clearfix">
        </div> <br>

    </div>

    <div class="right-sidebar">
        <div class="wrapper">
            <div id="scrollbar">
                <div class="scrollbar"><div class="track"><div class="thumb" ><div class="end"></div></div></div></div>
                <div class="viewport">
                    <div class="overview" >
                        <div class="featured-articles-container featured-articles-container_min_height">
                            <h5 class="heading">Class Compete Overview</h5>
                            <div class="articles">
                                <a data-original-title="">
                                    <span class="label-bullet">&nbsp;</span>
                                    Setup Classroom
                                </a>
                                <a data-original-title="">
                                    <span class="label-bullet">&nbsp;</span>
                                    Lookup Challenges in Marketplace
                                </a>
                                <a data-original-title="">
                                    <span class="label-bullet">&nbsp;</span>
                                    Assign Challenges to Classroom
                                </a>
                                <a data-original-title="">
                                    <span class="label-bullet">&nbsp;</span>
                                    Watch the Results!!!
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-stylish-1">


    </div>

</div>
    <script>

        function geochart() {
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
        geochart();
    </script>