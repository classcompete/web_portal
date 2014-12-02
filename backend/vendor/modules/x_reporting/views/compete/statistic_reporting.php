

<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Student statistic in a classroom & each challenges</div>
                        <span class="tools">
                            <select id="student_class_challenge_class_id">
                                <?php foreach ($classrom as $stat => $val): ?>
                                    <option <?php echo ($classrom[0]['class_id'] === $val['class_id'] ? 'selected="selected"' : '')?>
                                        value="<?php echo $val['class_id'] ?>"><?php echo $val['class_name']?></option>
                                <?php endforeach;?>
                            </select>

                            <select id="student_class_challenge_student_id"
                                <?php echo (empty($student_statistic_class_student) === true) ? 'disabled="disabled"' : '' ?>>
                                <?php if (isset($student_statistic_class_student) === true && empty($student_statistic_class_student) === false): ?>
                                    <?php foreach ($student_statistic_class_student as $student => $val): ?>
                                        <option <?php echo ($student_statistic_class_student[0]['user_id'] === $val['user_id'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $val['user_id'] ?>"><?php echo $val['first_name'] . ' ' . $val['last_name']?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option>No students in this class</option>
                                <?php endif ?>
                            </select>
                        </span>
                    </div>
                    <div class="widget-body clearfix">
                        <div class="example_alt_pagination dt_example">
                            <div role="grid" class="dataTables_wrapper" id="class_student_stats_table_wrapper">
                                <table id="class_student_stats_table"
                                       class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
                                    <thead>
                                    <tr role="row">
                                        <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Challenge Name
                                        </th>
                                        <th style="width: 305px;" class="sorting" rowspan="1" colspan="1">Correct
                                            Answers
                                        </th>
                                        <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">
                                            Incorrect Answers
                                        </th>
                                        <th class="hidden-phone sorting" style="width: 242px;" rowspan="1" colspan="1">
                                            Time on Course
                                        </th>
                                        <th class="hidden-phone sorting_desc" style="width: 242px;" rowspan="1"
                                            colspan="1">
                                            Coins Collected
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="class_student_stats_tbody">
                                    <?php if (isset($student_statistic) === true && empty($student_statistic) === false): ?>
                                        <?php foreach ($student_statistic as $k => $v): ?>
                                            <tr class="gradeA info odd">
                                                <td class=""><?php echo $v['challenge_name']?></td>
                                                <td class=""><?php echo $v['correct_answers']?></td>
                                                <td class=""><?php echo $v['incorrect_answers']?></td>
                                                <td class="hidden-phone"><?php echo $v['total_duration']?></td>
                                                <td class="hidden-phone sorting_1"><?php echo $v['coins_collected']?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row-fluid">

            <div class="span6">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Challenges statistic by played times</div>
                    </div>
                    <div class="widget-body clearfix">
                        <div class="example_alt_pagination dt_example">
                            <div role="grid" class="dataTables_wrapper"
                                 id="challenge_stats_by_played_time_table_wrapper">
                                <table id="challenge_stats_by_played_time_table"
                                       class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
                                    <thead>
                                    <tr role="row">
                                        <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Challenge Name
                                        </th>
                                        <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Class Name
                                        </th>
                                        <th style="width: 305px;" class="sorting" rowspan="1" colspan="1">Played times
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="class_student_stats_tbody">
                                    <?php if (isset($played_times) === true && empty($played_times) === false): ?>
                                        <?php foreach ($played_times as $k => $v): ?>
                                            <tr class="gradeA info odd">
                                                <td class=""><?php echo $v['challenge_name']?></td>
                                                <td class=""><?php echo $v['class_name']?></td>
                                                <td class="hidden-phone sorting_1"><?php echo $v['played_times']?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span6">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Student statistic challenges</div>
                         <span class="tools">
                             <?php if (isset($classrom) === true && empty($classrom) === false): ?>
                                 <select id="stats_class_id">
                                     <?php foreach ($classrom as $stat => $val): ?>
                                         <option <?php echo ($classrom[0]['class_id'] === $val['class_id'] ? 'selected="selected"' : '')?>
                                             value="<?php echo $val['class_id'] ?>"><?php echo $val['class_name']?></option>
                                     <?php endforeach;?>
                                 </select>
                             <?php endif;?>
                        </span>
                    </div>
                    <div class="widget-body clearfix">
                        <div class="example_alt_pagination dt_example">
                            <div role="grid" class="dataTables_wrapper" id="student_stats_table_wrapper">
                                <table id="student_stats_table"
                                       class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
                                    <thead>
                                    <tr role="row" class="thead">
                                        <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">First name
                                        </th>
                                        <th style="width: 305px;" class="sorting" rowspan="1" colspan="1">Last name</th>
                                        <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">Played
                                            challenges
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="class_student_stats_tbody">
                                    <?php if (isset($student_played_times) === true && empty($student_played_times) === false): ?>
                                        <?php foreach ($student_played_times as $k => $v): ?>
                                            <tr class="gradeA info odd" data-student='<?php echo $v['user_id'] ?>'>
                                                <td class=""><?php echo $v['student_firstname']?></td>
                                                <td class=""><?php echo $v['student_lastname']?></td>
                                                <td class=""><?php echo $v['number_of_challenges']?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal hide fade classmodal modal_wide" id="studentDetailsModal" tabindex="-1" role="dialog"
             aria-labelledby="addClassLabel"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Student Stats Details</h3>
            </div>
            <div class="modal-body">
                <?php $this->load->view('student_stats_details_modal'); ?>
            </div>
        </div>
    </div>