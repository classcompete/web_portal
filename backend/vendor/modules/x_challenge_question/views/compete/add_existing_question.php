

<div class="dashboard-wrapper">
    <div class="left-sidebar margin_right_0">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Add existing questions to challenge: <span style="color:#ed6d49"><?php echo $challenge->getName()?></span></div>
                        <span class="tools">
                            <select id="add_existing_question_subject_id">
	                            <option value="0" selected="selected">Select subject...</option>
	                            <?php foreach ($subjects as $subject): ?>
	                                <option value="<?php echo $subject->getSubjectId() ?>"><?php echo $subject->getName() ?></option>
	                            <?php endforeach;?>
                            </select>
                            <select id="add_existing_question_topic_id" disabled="disabled">
	                            <option value="0" selected="selected">Select topic...</option>
                            </select>
                            <select id="add_existing_question_grade">
	                            <option value="0" selected="selected">Select grade...</option>
								<option value="-2">Pre k</option>
								<option value="-1">K</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">High School</option>
                            </select>
                        </span>
                    </div>
                    <div class="widget-body clearfix">
                        <div class="example_alt_pagination dt_example">
                            <div role="grid" class="dataTables_wrapper" id="add_question_table_wrapper">
                                <?php
                                // A place for table of questions which is constructed in php code...
                                /*
	                            <table id="add_question_table" class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
                                    <thead>
	                                    <tr role="row">
	                                        <th style="width: 200px;" class="sorting" rowspan="1" colspan="1">
		                                        Subject
	                                        </th>
	                                        <th style="width: 200px;" class="sorting" rowspan="1" colspan="1">
		                                        Topic
	                                        </th>
	                                        <th style="width: 100px;" class="sorting" rowspan="1" colspan="1">
	                                            Grade
	                                        </th>
	                                        <th class="sorting" rowspan="1" colspan="1">
	                                            Text
	                                        </th>
	                                        <th style="width: 100px;" rowspan="1" colspan="1">
	                                            Action
	                                        </th>
	                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="gradeA info">
                                            <td>subject 1</td>
                                            <td>topic 1</td>
                                            <td>grade 1</td>
                                            <td>text 1</td>
                                            <td>
												<button class="btn btn-success btn-mini btn-add-existing-question" data-question-id="111">Add to challenge</button>
                                            </td>
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