<?php
$attributes = shortcode_atts(
	array(
		'type' => "",
		'size' => "",
		'icon' => "",
	), $atts);

$simple_class = '';
if ($attributes['icon'] == '') {
    $simple_class = ' type_simple';
}

$type_class = ($attributes['type'] != '')?' type_'.$attributes['type']:'';
$size_class = ($attributes['size'] != '')?' size_'.$attributes['size']:'';

$output = 	'<div class="g-hr'.$type_class.$size_class.$simple_class.'">
						<span class="g-hr-h">
							<i class="fa fa-'.$attributes['icon'].'"></i>
						</span>
					</div>';

echo $output;