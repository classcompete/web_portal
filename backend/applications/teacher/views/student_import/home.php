<div class="dashboard-wrapper">
    <div class="left-sidebar no-margin">
        <div class="widget">
            <div class="widget-header">
                <div class="title">Student imports [ <?php echo count($imports) ?> ]</div>
                <span class="tools">
                    <a data-backdrop="static" id="addNewImport" href="#" class="btn btn-small" style="color:black"
                       data-toggle="modal" data-target="#addImport" data-original-title="">
                        Add New
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
	                            <th class="head1 hidden-phone">Status</th>
	                            <th class="head0">&nbsp;</th>
	                        </tr>
                        </thead>
                        <tfoot>
	                        <tr>
	                            <th class="head1">Import description</th>
	                            <th class="head1 hidden-phone">Status</th>
	                            <th class="head0">&nbsp;</th>
	                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($imports as $import): ?>
                            <tr>
                                <td><?php echo $import->getName() ?></td>
                                <td class="hidden-phone"><?php echo $import->getStatus() ?></td>
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
                        <form enctype="multipart/form-data" id="student_import_form" class="form-horizontal no-margin"
                              method="post" accept-charset="utf-8" action="<?php echo site_url('student_import/save')?>">
                            <div class="modal-body">
                                <div class="control-group">
                                    <label class="control-label">Import description</label>

                                    <div class="controls">
                                        <input type="text" id="name" name="name">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">File to import students</label>

                                    <div class="controls">
                                        <input type="file" id="file" name="file">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="student_import_form_submit" class="btn btn-primary">Upload file</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>