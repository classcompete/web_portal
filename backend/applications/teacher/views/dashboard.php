<div class="dashboard-wrapper">

    <div class="left-sidebar">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                    <span class="tools">
                      <a class="btn btn-info btn-small" href="#" data-original-title="">Today</a>
                      <a class="btn btn-success btn-small" href="#" data-original-title="">Yesterday</a>
                      <a class="btn btn-warning2 btn-small" href="#" data-original-title="">Last week</a>
                    </span>
                    </div>
                    <div class="widget-body">
                        <div class="row-fluid">
                            <div class="metro-nav">
                                <div class="metro-nav-block nav-block-orange">
                                    <a href="#" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info">692</div>
                                        <div class="brand">Total Students</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-yellow">
                                    <a href="#" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info">45</div>
                                        <div class="brand">Total Classes</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-blue double">
                                    <a href="#" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info">99</div>
                                        <div class="brand">Total Challenges</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-green">
                                    <a href="#" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info">431</div>
                                        <div class="brand">Total Reports</div>
                                    </a>
                                </div>
                                <div class="metro-nav-block nav-block-red">
                                    <a href="#" data-original-title="">
                                        <div class="fs1" aria-hidden="true" data-icon=""></div>
                                        <div class="info">288</div>
                                        <div class="brand">Marketplace Sales</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span8">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">
                            Top 5 Challenges
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="easy-pie-charts-container" style="padding: 35px 30px;">
                            <div class="pie-chart">
                                <div class="chart1 easyPieChart" data-percent="48"
                                     style="width: 140px; height: 140px; line-height: 140px;">
                                    48%
                                    <canvas width="140" height="140"></canvas>
                                </div>
                                <p class="name">
                                    Challenge Name
                                </p>
                            </div>
                            <div class="pie-chart">
                                <div class="chart2 easyPieChart" data-percent="71"
                                     style="width: 140px; height: 140px; line-height: 140px;">
                                    71%
                                    <canvas width="140" height="140"></canvas>
                                </div>
                                <p class="name">
                                    Challenge Name
                                </p>
                            </div>
                            <div class="pie-chart">
                                <div class="chart3 easyPieChart" data-percent="87"
                                     style="width: 140px; height: 140px; line-height: 140px;">
                                    87%
                                    <canvas width="140" height="140"></canvas>
                                </div>
                                <p class="name">
                                    Challenge Name
                                </p>
                            </div>
                            <div class="pie-chart">
                                <div class="chart4 easyPieChart" data-percent="22"
                                     style="width: 140px; height: 140px; line-height: 140px;">
                                    22%
                                    <canvas width="140" height="140"></canvas>
                                </div>
                                <p class="name">
                                    Challenge Name
                                </p>
                            </div>
                            <div class="pie-chart hidden-tablet">
                                <div class="chart5 easyPieChart" data-percent="21"
                                     style="width: 140px; height: 140px; line-height: 140px;">
                                    21%
                                    <canvas width="140" height="140"></canvas>
                                </div>
                                <p class="name">
                                    Challenge Name
                                </p>
                            </div>
                            <div class="clearfix">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span4">
                <div class="widget no-margin">
                    <div class="widget-header">
                        <div class="title">
                            Top Competitors
                        </div>
                    <span class="tools">
                      <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                    </div>
                    <div class="widget-body">
                        <h5>Student Name 20% - Challenge Name</h5>

                        <div class="progress progress-info progress-striped active">
                            <div class="bar" style="width: 20%">
                            </div>
                        </div>
                        <h5>Student Name 40% - Challenge Name</h5>

                        <div class="progress progress-success progress-striped active">
                            <div class="bar" style="width: 40%">
                            </div>
                        </div>
                        <h5>Student Name 60% - Challenge Name</h5>

                        <div class="progress progress-warning progress-striped active">
                            <div class="bar" style="width: 60%">
                            </div>
                        </div>
                        <h5>Student Name 80% - Challenge Name</h5>

                        <div class="progress progress-danger progress-striped active">
                            <div class="bar" style="width: 80%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix">
        </div>
        <br>
    </div>
    <div class="right-sidebar">
        <div class="action1"></div>
        <hr class="hr-stylish-1">
        <div class="action2"></div>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        pie_chart();
    });
    //Animated Pie Charts
    function pie_chart() {
        $(function () {
            //create instance
            $('.chart1').easyPieChart({
                animate: 2000,
                barColor: '#74b749',
                trackColor: '#dddddd',
                scaleColor: '#74b749',
                size: 140,
                lineWidth: 6
            });
            //update instance after 5 sec
            setTimeout(function () {
                $('.chart1').data('easyPieChart').update(50);
            }, 5000);
            setTimeout(function () {
                $('.chart1').data('easyPieChart').update(70);
            }, 10000);
            setTimeout(function () {
                $('.chart1').data('easyPieChart').update(30);
            }, 15000);
            setTimeout(function () {
                $('.chart1').data('easyPieChart').update(90);
            }, 19000);
            setTimeout(function () {
                $('.chart1').data('easyPieChart').update(40);
            }, 32000);
        });

        $(function () {
            //create instance
            $('.chart2').easyPieChart({
                animate: 2000,
                barColor: '#ed6d49',
                trackColor: '#dddddd',
                scaleColor: '#ed6d49',
                size: 140,
                lineWidth: 6
            });
            //update instance after 5 sec
            setTimeout(function () {
                $('.chart2').data('easyPieChart').update(90);
            }, 10000);
            setTimeout(function () {
                $('.chart2').data('easyPieChart').update(40);
            }, 18000);
            setTimeout(function () {
                $('.chart2').data('easyPieChart').update(70);
            }, 28000);
            setTimeout(function () {
                $('.chart2').data('easyPieChart').update(50);
            }, 32000);
            setTimeout(function () {
                $('.chart2').data('easyPieChart').update(80);
            }, 40000);
        });

        $(function () {
            //create instance
            $('.chart3').easyPieChart({
                animate: 2000,
                barColor: '#0daed3',
                trackColor: '#dddddd',
                scaleColor: '#0daed3',
                size: 140,
                lineWidth: 6
            });
            //update instance after 5 sec
            setTimeout(function () {
                $('.chart3').data('easyPieChart').update(20);
            }, 9000);
            setTimeout(function () {
                $('.chart3').data('easyPieChart').update(59);
            }, 20000);
            setTimeout(function () {
                $('.chart3').data('easyPieChart').update(38);
            }, 35000);
            setTimeout(function () {
                $('.chart3').data('easyPieChart').update(79);
            }, 49000);
            setTimeout(function () {
                $('.chart3').data('easyPieChart').update(96);
            }, 52000);
        });

        $(function () {
            //create instance
            $('.chart4').easyPieChart({
                animate: 2000,
                barColor: '#ffb400',
                trackColor: '#dddddd',
                scaleColor: '#ffb400',
                size: 140,
                lineWidth: 6
            });
            //update instance after 5 sec
            setTimeout(function () {
                $('.chart4').data('easyPieChart').update(40);
            }, 6000);
            setTimeout(function () {
                $('.chart4').data('easyPieChart').update(67);
            }, 14000);
            setTimeout(function () {
                $('.chart4').data('easyPieChart').update(43);
            }, 23000);
            setTimeout(function () {
                $('.chart4').data('easyPieChart').update(80);
            }, 36000);
            setTimeout(function () {
                $('.chart4').data('easyPieChart').update(66);
            }, 41000);
        });


        $(function () {
            //create instance
            $('.chart5').easyPieChart({
                animate: 3000,
                barColor: '#F63131',
                trackColor: '#dddddd',
                scaleColor: '#F63131',
                size: 140,
                lineWidth: 6
            });
            //update instance after 5 sec
            setTimeout(function () {
                $('.chart5').data('easyPieChart').update(30);
            }, 9000);
            setTimeout(function () {
                $('.chart5').data('easyPieChart').update(87);
            }, 19000);
            setTimeout(function () {
                $('.chart5').data('easyPieChart').update(28);
            }, 27000);
            setTimeout(function () {
                $('.chart5').data('easyPieChart').update(69);
            }, 39000);
            setTimeout(function () {
                $('.chart5').data('easyPieChart').update(99);
            }, 47000);
        });
    }
</script>