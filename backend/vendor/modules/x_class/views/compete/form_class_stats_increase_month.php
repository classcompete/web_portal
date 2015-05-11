<form id="stat_increase_month_form" class="form-horizontal no-margin" method="post" accept-charset="utf-8">
	<div class="modal-body">
	    <div class="control-group">
	        <label class="control-label">Minimum score average</label>

	        <div class="controls">
	            <input type="text" id="stat_increase_min_score_average" name="min_score_average" value="0">
	            <span class="help-inline"></span>
		        <button id="btn_stat_increase_month_refresh" class="btn btn-primary" data-class-id="0">Refresh</button>
	        </div>
	    </div>

	    <div id="class_stats_increase_month_chart_wrap">
		    <img src="<?php echo AssetHelper::imageUrl('loading.gif') ?>" class="loader">
	    </div>
	</div>
</form>