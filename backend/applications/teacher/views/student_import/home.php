<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">
            <div class="widget-header">
                <div class="title">Student imports [ <?php echo count($imports) ?> ]</div>
                <span class="tools">
                    <a data-backdrop="static" id="addNewImport" href="#" class="btn btn-small" style="color:black"
                       data-toggle="modal" data-target="#addImport" data-original-title="">
                        Add new file for import
                    </a>
                </span>
            </div>
            <div class="widget-body clearfix">
                <div class="example_alt_pagination mod-skill">
                    <table
                        class="dataTables_wrapper stdtable stdtablecb table table-condensed table-striped table-hover table-bordered pull-left no-margin">
                        <thead>
	                        <tr>
	                            <th class="head1">Import description</th>
		                        <th class="head1">Class name</th>
	                            <th class="head1">Status</th>
		                        <th class="head1">Upload date</th>
	                            <th class="head0">&nbsp;</th>
	                        </tr>
                        </thead>
                        <tfoot>
	                        <tr>
	                            <th class="head1">Import description</th>
		                        <th class="head1">Class name</th>
	                            <th class="head1">Status</th>
		                        <th class="head1">Upload date</th>
	                            <th class="head0">&nbsp;</th>
	                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($imports as $import): ?>
                            <tr>
                                <td><?php echo $import->getName() ?></td>
                                <td><?php echo $import->getClassName() ?></td>
	                            <?php
		                            switch ($import->getStatus()) {
			                            case 'pending':
				                            $statusColor = '#00cf1d';
				                            break;
			                            case 'imported':
				                            $statusColor = '#333333';
				                            break;
			                            case 'failed':
				                            $statusColor = '#ff1a11';
				                            break;
		                            }
	                            ?>
	                            <td style="color: <?php echo $statusColor ?>;"><?php echo $import->getStatus() ?></td>
	                            <td><?php echo $import->getCreatedAt('m/d/Y h:i a') ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a data-toggle="modal" title="" class="import"
                                                   href="<?php echo site_url('student_import/do_import/' . $import->getId())?>">
                                                    Import
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" title="" class="delete"
                                                   href="<?php echo site_url('student_import/delete/' . $import->getId())?>">
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>

                    <div aria-hidden="false" class="modal hide fade classmodal in"
                         aria-labelledby="addClassLabel" role="dialog" tabindex="-1" id="addImport">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h3>Prepare student import</h3>
                        </div>

	                    <?php $this->load->view('x_class/' . config_item('teacher_template'). '/form_prepare_import_students'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>