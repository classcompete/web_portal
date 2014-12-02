<?php
$attributes = shortcode_atts(
	array(
		'type' => 'info',
	), $atts);

$output = '<div class="g-alert with_close type_'.$attributes['type'].'"><div class="g-alert-close"> &#10005 </div><div class="g-alert-body"><p>'.do_shortcode($content).'</p></div></div>';

echo $output;
