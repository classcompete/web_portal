<form id="stat_average_month_form" class="form-horizontal no-margin" method="post" accept-charset="utf-8">
	<div class="modal-body">
	    <div class="control-group">
	        <label class="control-label">Minimum score average</label>

	        <div class="controls">
	            <input type="text" id="stat_average_min_score_average" name="min_score_average" value="0">
	            <span class="help-inline"></span>
		        <button id="btn_stat_average_month_refresh" class="btn btn-primary" data-class-id="0">Refresh</button>
	        </div>
	    </div>

        <table style="width: 100%; border: 0; margin: 5px; font-size: 14px" cellspacing="0" cellpadding="5">
            <tr>
                <td style="width: 30%">
                    Classroom Name:
                </td>
                <td>
                    <span class="class-name"></span>
                </td>
            </tr>
            <tr>
                <td>
                    Teacher Name:
                </td>
                <td>
                    <span class="teacher-name"></span>
                </td>
            </tr>
        </table>

	    <div id="class_stats_average_month_chart_wrap">
		    <img src="<?php echo AssetHelper::imageUrl('loading.gif') ?>" class="loader">
	    </div>
	</div>
</form>