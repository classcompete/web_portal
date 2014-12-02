<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Student age statistics</div>
                    </div>
                    <div class="widget-body">
                        <div id="student_age_chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Student total duration time</div>
                    </div>
                    <div class="widget-body">
                        <div id="student_total_duration_chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">User registration statistics</div>
                        <span class="tools">
                            <div class="datepicker_holder" id="datepicker_reg_stats_form">
                                <div class="input-prepend">
                                    <span class="add-on" data-icon="&#xe053;" style="line-height: 24px"></span>
                                    <input type="text" placeholder="Date From" name="from" id="datepicker_reg_stats_from"/>
                                </div>
                                <div class="input-prepend">
                                    <span class="add-on" data-icon="&#xe053;" style="line-height: 24px"></span>
                                    <input type="text" placeholder="Date To" name="to" id="datepicker_reg_stats_to"/>
                                </div>
                            </div>
                            <button class="btn btn-small btn-info" id="reg_stats_day_submit" data-type="day">
                                <span class="icon-search"></span> Daily</button>
                            <button class="btn btn-small btn-info" id="reg_stats_week_submit" data-type="week">
                                <span class="icon-search"></span> Weekly</button>
                            <button class="btn btn-small btn-info" id="reg_stats_month_submit" data-type="month">
                                <span class="icon-search"></span> Monthly</button>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div id="user_registration_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>