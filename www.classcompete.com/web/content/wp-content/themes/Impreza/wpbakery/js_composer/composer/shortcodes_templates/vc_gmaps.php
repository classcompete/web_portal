<?php
$output = $title = $link = $size = $zoom = $type = $bubble = $el_class = '';
extract(shortcode_atts(array(
//    'title' => '',
//    'link' => 'https://maps.google.com/maps?q=New+York&hl=en&sll=40.686236,-73.995409&sspn=0.038009,0.078192',
    'address' => '',
    'latitude' => '',
    'longitude' => '',
    'marker' => '',
    'height' => 400,
    'zoom' => 13,
    'type' => 'ROADMAP',

), $atts));
//
//if ( $link == '' ) { return null; }
//
//$el_class = $this->getExtraClass($el_class);
//$bubble = ($bubble!='' && $bubble!='0') ? '&amp;iwloc=near' : '';
//
//$size = str_replace(array( 'px', ' ' ), array( '', '' ), $size);
//$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gmaps_widget wpb_content_element'.$el_class, $this->settings['base']);
//$output .= "\n\t".'<div class="'.$css_class.'">';
//$output .= "\n\t\t".'<div class="wpb_wrapper">';
//$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_map_heading'));
//$output .= '<div class="wpb_map_wraper"><iframe width="100%" height="'.$size.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$link.'&amp;t='.$type.'&amp;z='.$zoom.'&amp;output=embed'.$bubble.'"></iframe></div>';
//
//$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
//$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gmaps_widget');

$map_id = rand(99999, 999999);

if ($latitude != '' AND $longitude != '') {
	$map_location_options = 'latitude: "'.$latitude.'", longitude: "'.$longitude.'", ';
} elseif ($address != '') {
	$map_location_options = 'address: "'.$address.'", ';
} else {
	return null;
}

$map_marker_options = '';
if ($marker != '') {
	$map_marker_options = 'html: "'.$marker.'", popup: true';
}

wp_enqueue_script('gmaps');

if ($height == '') {
    $height = 400;
}

$output = '<div class="w-map" id="map_'.$map_id.'" style="height: '.$height.'px">
				<div class="w-map-h">

				</div>
			</div>
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#map_'.$map_id.'").gMap({
						'.$map_location_options.'
						zoom: '.$zoom.',
						maptype: "'.$type.'",
						markers:[
							{
								'.$map_location_options.$map_marker_options.'

							}
						]
					});
				});
			</script>';

echo $output;