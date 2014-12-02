<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Challenges statistic by played times</div>
                    </div>
                    <div class="widget-body clearfix">
                        <div id="challenge_by_played_times" style="position: relative;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Student statistic challenge</div>
                    </div>
                    <div class="widget-body clearfix">
                        <div id="students_challenge" style="position: relative;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Geochart data (home page and reporting page) Challenges by State</div>
                    </div>
                    <div class="widget-body clearfix">
                        <div id="geochart" style="position: relative;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var challengeByPlayedTimes = <?php echo json_encode($challengeStats)?>;
    var studentByChallenge = <?php echo json_encode($studentsPerChallengeStats)?>;
    var challengesPerState = <?php echo json_encode($stateStats)?>;

    google.load('visualization', '1', {packages: ['columnchart','geochart']});
    function drawVisualization() {
        var dataTable1 = google.visualization.arrayToDataTable(challengeByPlayedTimes);
        var dataView1 = new google.visualization.DataView(dataTable1);
        dataView1.setColumns([0, 1]);

        var chart1 = new google.visualization.ColumnChart(document.getElementById('challenge_by_played_times'));
        chart1.draw(dataView1, {width: (screen.availWidth - 100), height: 250});

        var dataTable2 = google.visualization.arrayToDataTable(studentByChallenge);
        var dataView2 = new google.visualization.DataView(dataTable2);

        var chart2 = new google.visualization.ColumnChart(document.getElementById('students_challenge'));
        chart2.draw(dataView2, {width: (screen.availWidth - 100), height: 250});

        /* var dataTable3 = google.visualization.arrayToDataTable(challengesPerState);

        var options = {
            region: 'US',
            enableRegionInteractivity: true,
            resolution: 'provinces',
            height: 250
        };

        var geochart = new google.visualization.GeoChart(
            document.getElementById('geochart'));
            geochart.draw(dataTable3, options); */
    }

    google.setOnLoadCallback(drawVisualization);

</script>