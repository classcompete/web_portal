<?php
/**
 * WPBakery Visual Composer Shortcodes settings
 *
 * @package VPBakeryVisualComposer
 *
 */
$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;
// Used in "Button", "Call to Action", "Pie chart" blocks
$colors_arr = array(__("Grey", "js_composer") => "wpb_button", __("Blue", "js_composer") => "btn-primary", __("Turquoise", "js_composer") => "btn-info", __("Green", "js_composer") => "btn-success", __("Orange", "js_composer") => "btn-warning", __("Red", "js_composer") => "btn-danger", __("Black", "js_composer") => "btn-inverse");

// Used in "Button" and "Call to Action" blocks
$size_arr = array(__("Regular size", "js_composer") => "wpb_regularsize", __("Large", "js_composer") => "btn-large", __("Small", "js_composer") => "btn-small", __("Mini", "js_composer") => "btn-mini");

$target_arr = array(__("Same window", "js_composer") => "", __("New window", "js_composer") => "_blank");

$post_categories = array('All' => '');
$post_categories_raw = get_categories("hierarchical=0");
foreach ($post_categories_raw as $post_category_raw)
{
	$post_categories[$post_category_raw->name] = $post_category_raw->slug;
}
//$portfolio_categories = array('All' => '');
$portfolio_categories_raw = get_categories("taxonomy=us_portfolio_category&hierarchical=0");//print_r($portfolio_categories_raw);
foreach ($portfolio_categories_raw as $portfolio_category_raw)
{
	$portfolio_categories[$portfolio_category_raw->name] = $portfolio_category_raw->slug;
}


$add_css_animation = array(
  "type" => "dropdown",
  "heading" => __("Animation", "js_composer"),
  "param_name" => "animate",
  "admin_label" => true,
  "value" => array(
	  __("No Animation", "js_composer") => '',
	  __("Appear From Center", "js_composer") => "afc",
	  __("Appear From Left", "js_composer") => "afl",
	  __("Appear From Right", "js_composer") => "afr",
	  __("Appear From Bottom", "js_composer") => "afb",
	  __("Appear From Top", "js_composer") => "aft",
	  __("Height From Center", "js_composer") => "hfc",
	  __("Width From Center", "js_composer") => "wfc",
	  __("Rotate From Center", "js_composer") => "rfc",
	  __("Rotate From Left", "js_composer") => "rfl",
	  __("Rotate From Right", "js_composer") => "rfr",
  ),
  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
);

$add_css_animation_delay = array(
  "type" => "dropdown",
  "heading" => __("Animation Delay", "js_composer"),
  "param_name" => "animate_delay",
  "admin_label" => true,
  "value" => array(
	  __("None", "js_composer") => '',
	  __("0.2 second", "js_composer") => "0.2",
	  __("0.4 second", "js_composer") => "0.4",
	  __("0.6 second", "js_composer") => "0.6",
	  __("0.8 second", "js_composer") => "0.8",
	  __("1 second", "js_composer") => "1",
  ),
  "description" => ''
);

vc_map( array(
	"name" => __("Row", "js_composer"),
	"base" => "vc_row",
	"is_container" => true,
	"icon" => "icon-wpb-row",
	"show_settings_on_create" => false,
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "checkbox",
			"heading" => __("Separate Section", "js_composer"),
			"param_name" => "section",
			"value" => array(__("Place row in separate section", "js_composer") => "yes")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Section Color Style", "js_composer"),
			"param_name" => "background",
			"value" => array(__('Main Content (default)', "js_composer") => "", __('Alternate Content', "js_composer") => "alternate", __('Primary background color & White text color', "js_composer") => "primary", __('Secondary background color & White text color', "js_composer") => "secondary",),
			"description" => __("The section will use the color scheme you select. Color schemes are defined at Styling tab of the Theme Options", "js_composer"),
//			"dependency" => Array('element' => "section", 'not_empty' => true, 'callback' => 'us_row_section_dependency_callback')
		),
		array(
			"type" => "checkbox",
			"heading" => __("Full Width Content", "js_composer"),
			"param_name" => "full_width",
			"value" => array(__("Stretch section content to screen width", "js_composer") => "yes"),
//			"dependency" => Array('element' => "section", 'not_empty' => true)

		),
		array(
			"type" => "checkbox",
			"heading" => __("Full Height Content", "js_composer"),
			"param_name" => "full_height",
			"value" => array(__("Remove vertical indents", "js_composer") => "yes"),
//			"dependency" => Array('element' => "section", 'not_empty' => true)

		),
		array(
			"type" => "attach_image",
			"heading" => __("Section Background Image", "js_composer"),
			"param_name" => "img",
			"value" => "",
			"description" => __("Leave empty if you don't want to use the background image", "js_composer"),
//			"dependency" => Array('element' => "section", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Fade Background", "js_composer"),
			"param_name" => "bg_fade",
			"value" => array(__("None", "js_composer") => "", __("Fade with 30% black", "js_composer") => "black_30", __("Fade with 50% black", "js_composer") => "black_50", __("Fade with 30% white", "js_composer") => "white_30", __("Fade with 50% white", "js_composer") => "white_50", ),
//			"dependency" => Array('element' => "section", 'not_empty' => true)

		),
		array(
			"type" => "dropdown",
			"heading" => __("Parallax Effect", "js_composer"),
			"param_name" => "parallax",
			"value" => array(__("None", "js_composer") => "", __("Vertical Parallax", "js_composer") => "vertical", __("Horizontal Parallax", "js_composer") => "horizontal", ),
//			"dependency" => Array('element' => "section", 'not_empty' => true)

		),
		array(
			"type" => "dropdown",
			"heading" => __("Parallax Background Width", "js_composer"),
			"param_name" => "parallax_bg_width",
			"value" => array("110%" => "110", "120%" => "120", "130%" => "130", "140%" => "140", "150%" => "150", ),
			"description" => '',
			"dependency" => Array('element' => "parallax", 'value' => array('horizontal'))
		),
		array(
			"type" => "dropdown",
			"heading" => __("Parallax Speed Factor", "js_composer"),
			"param_name" => "parallax_speed",
			"value" => array(__('Normal', "js_composer") => "normal",__('Slow', "js_composer") => "slow",  __('Fast', "js_composer") => "fast",  __('None (Image not moves)', "js_composer") => "still",),
			"description" => '',
			"dependency" => Array('element' => "parallax", 'value' => array('vertical'))
		),
		array(
			"type" => "checkbox",
			"heading" => __("Reverse Parallax", "js_composer"),
			"param_name" => "parallax_reverse",
			"value" => array(__("Reverse Parallax Effect", "js_composer") => "yes"),
			"dependency" => Array('element' => "parallax", 'value' => array('vertical'))

		),
        array(
            "type" => "textfield",
            "heading" => __("Extra CSS class (optional)", "js_composer"),
            "param_name" => "class",
            "description" => '',
        ),
        array(
            "type" => "textfield",
            "heading" => __("Section ID (optional)", "js_composer"),
            "param_name" => "section_id",
            "description" => '',
//            "dependency" => Array('element' => "section", 'not_empty' => true),
        ),

	),
	"js_view" => 'VcRowView'
) );
vc_map( array(
  "name" => __("Row", "js_composer"), //Inner Row
  "base" => "vc_row_inner",
  "content_element" => false,
  "is_container" => true,
  "icon" => "icon-wpb-row",
  "show_settings_on_create" => false,
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    )
  ),
  "js_view" => 'VcRowView'
) );
vc_map( array(
  "name" => __("Column", "js_composer"),
  "base" => "vc_column",
  "is_container" => true,
  "content_element" => false,
  "params" => array(

	  $add_css_animation,
      $add_css_animation_delay
  ),
  "js_view" => 'VcColumnView'
) );

/* Text Block
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Text Block", "js_composer"),
  "base" => "vc_column_text",
  "icon" => "icon-wpb-layer-shape-text",
  "wrapper_class" => "clearfix",
  "category" => __('Content', 'js_composer'),
  "params" => array(
    array(
      "type" => "textarea_html",
      "holder" => "div",
      "heading" => __("Text", "js_composer"),
      "param_name" => "content",
      "value" => __("<p>I am text block. Click edit button to change this text.</p>", "js_composer")
    ),

  )
) );

/* Single image */
vc_map( array(
	"name" => __("Single Image", "js_composer"),
	"base" => "vc_single_image",
	"icon" => "icon-wpb-single-image",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => "attach_image",
			"heading" => __("Image", "js_composer"),
			"param_name" => "image",
			"value" => "",
			"description" => __("Select image from media library.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Alignment", "js_composer"),
			"param_name" => "align",
			"value" => array(__('Default', "js_composer") => "", __('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Image size", "js_composer"),
			"param_name" => "img_size",
			"value" => array(__("Full Size", "js_composer") => "full", __("Thumbnail", "js_composer") => "thumbnail", __("Medium", "js_composer") => "medium", ),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Open original image image in lightbox on click", "js_composer"),
			"param_name" => "img_link_large",
			"description" => "",
			"value" => Array(__("Yes, please", "js_composer") => 'yes')
		),
		array(
			"type" => "textfield",
			"heading" => __("Image link", "js_composer"),
			"param_name" => "img_link",
			"description" => __("Enter url if you want this image to have link.", "js_composer"),
			"dependency" => Array('element' => "img_link_large", 'is_empty' => true, 'callback' => 'wpb_single_image_img_link_dependency_callback')
		),
		$add_css_animation,
		$add_css_animation_delay,
	)
));

/* Gallery/Slideshow
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Image Gallery", "js_composer"),
	"base" => "vc_gallery",
	"icon" => "icon-wpb-images-stack",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => "attach_images",
			"heading" => __("Images", "js_composer"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Select images from media library.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Gallery Type", "js_composer"),
			"param_name" => "type",
			"value" => array(__("Small thumbs (190x190)", "js_composer") => "s", __("Tiny thumbs (114x114)", "js_composer") => "xs", __("Medium thumbs (228x228)", "js_composer") => "m", __("Large thumbs (285x285)", "js_composer") => "l", __("Masonry grid", "js_composer") => "masonry"),
			"description" => '',
		),

	)
) );

/* Slideshow
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Simple Slider", "js_composer"),
	"base" => "vc_simple_slider",
	"icon" => "icon-wpb-images-stack",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => "attach_images",
			"heading" => __("Images", "js_composer"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Select images from media library.", "js_composer")

		),
		array(
			"type" => "dropdown",
			"heading" => __("Auto Rotation", "js_composer"),
			"param_name" => "auto_rotation",
			"value" => array(__("Yes", "js_composer") => "1", __("No", "js_composer") => "0", ),
			"description" => ''
		),

	)
) );

/* Separator (Divider)
---------------------------------------------------------- */
vc_map( array(
  "name"		=> __("Separator", "js_composer"),
  "base"		=> "vc_separator",
  'icon'		=> 'icon-wpb-ui-separator',
  "category"  => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => "dropdown",
			"heading" => __("Separator Type", "js_composer"),
			"param_name" => "type",
			"value" => array(__('Full Width', "js_composer") => "", __('Short', "js_composer") => "short", __('Invisible', "js_composer") => "invisible"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Separator Size", "js_composer"),
			"param_name" => "size",
			"value" => array(__('Medium', "js_composer") => "", __('Small', "js_composer") => "small", __('Big', "js_composer") => "big", __('Huge', "js_composer") => "huge"),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Icon", "js_composer"),
			"param_name" => "icon",
			"value" => "star",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
		),
	),
) );

/* Button
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Button", "js_composer"),
	"base" => "vc_button",
	"icon" => "icon-wpb-ui-button",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Button Label", "js_composer"),
			"holder" => "button",
			"class" => "wpb_button",
			"param_name" => "text",
			"value" => __("Click me", "js_composer"),
			"description" => __("This is the text that appears on the button", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Button Link", "js_composer"),
			"param_name" => "url",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Color", "js_composer"),
			"param_name" => "type",
			"value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal"),
			"description" => ''
		),
        array(
            "type" => 'checkbox',
            "heading" => __("Outlined", "js_composer"),
            "param_name" => "outlined",
            "value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes'),
			"description" => ''
        ),
		array(
			"type" => "textfield",
			"heading" => __("Button Icon (optional)", "js_composer"),
			"param_name" => "icon",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Size", "js_composer"),
			"param_name" => "size",
			"value" => array(__("Normal", "js_composer") => "", __("Small", "js_composer") => "small", __("Big", "js_composer") => "big"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Position", "js_composer"),
			"param_name" => "align",
			"value" => array(__('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Link Target", "js_composer"),
			"param_name" => "target",
			"value" => $target_arr,
			"dependency" => Array('element' => "href", 'not_empty' => true)
		),

	),
	"js_view" => 'VcButtonView'
) );

/* Tabs
---------------------------------------------------------- */
$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);
vc_map( array(
	"name"  => __("Tabs", "js_composer"),
	"base" => "vc_tabs",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-ui-tab-content",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => 'checkbox',
			"heading" => __("Act as Timeline", "js_composer"),
			"param_name" => "timeline",
			"description" => '',
			"value" => Array(__("Change look and feel into Timeline", "js_composer") => 'yes')
		),

	),
	"custom_markup" => '
  <div class="wpb_tabs_holder wpb_holder vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>'
,
	'default_content' => '
  [vc_tab title="'.__('Tab 1','js_composer').'" tab_id="'.$tab_id_1.'"][/vc_tab]
  [vc_tab title="'.__('Tab 2','js_composer').'" tab_id="'.$tab_id_2.'"][/vc_tab]
  ',
	"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
) );

vc_map( array(
	"name" => __("Tab", "js_composer"),
	"base" => "vc_tab",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Tab Title", "js_composer"),
			"param_name" => "title",
			"description" => __("Enter the tab title here (better keep it short)", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Tab Icon (optional)", "js_composer"),
			"param_name" => "icon",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>'),


		),
        array(
            "type" => 'checkbox',
            "heading" => __("Active", "js_composer"),
            "param_name" => "active",
            "value" => Array(__("Tab is opened when page load", "js_composer") => 'yes')
        ),

	),
	'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
) );

/* Accordion block
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Accordion", "js_composer"),
	"base" => "vc_accordion",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-ui-accordion",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => 'checkbox',
			"heading" => __("Act as Toggles", "js_composer"),
			"param_name" => "toggle",
			"value" => Array(__("Allow several sections be open at the same time", "js_composer") => 'yes')
		),

	),
	"custom_markup" => '
  <div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
  %content%
  </div>
  <div class="tab_controls">
  <button class="add_tab" title="'.__("Add accordion section", "js_composer").'">'.__("Add accordion section", "js_composer").'</button>
  </div>
  ',
	'default_content' => '
  [vc_accordion_tab title="'.__('Section 1', "js_composer").'"][/vc_accordion_tab]
  [vc_accordion_tab title="'.__('Section 2', "js_composer").'"][/vc_accordion_tab]
  ',
	'js_view' => 'VcAccordionView'
) );

vc_map( array(
	"name" => __("Accordion Section", "js_composer"),
	"base" => "vc_accordion_tab",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Tab Title", "js_composer"),
			"param_name" => "title",
			"description" => __("Enter the tab title here (better keep it short)", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Tab Icon (optional)", "js_composer"),
			"param_name" => "icon",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')

		),
        array(
            "type" => 'checkbox',
            "heading" => __("Active", "js_composer"),
            "param_name" => "active",
            "value" => Array(__("Tab is opened when page load", "js_composer") => 'yes')
        ),
	),
	'js_view' => 'VcAccordionTabView'
) );

/* Iconbox
---------------------------------------------------------- */
vc_map( array(
    "name" => __("IconBox", "js_composer"),
    "base" => "vc_iconbox",
    "icon" => "icon-wpb-ui-separator-label",
    "category" => __('Content', 'js_composer'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Icon", "js_composer"),
            "param_name" => "icon",
            "value" => 'star',
            "description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Icon Position", "js_composer"),
            "param_name" => "iconpos",
            "value" => array(__('Top', "js_composer") => "top", __('Left', "js_composer") => "left",),
            "description" => ''
        ),
        array(
            "type" => "checkbox",
            "heading" => __("With Circle", "js_composer"),
            "param_name" => "with_circle",
            "value" => array(__("Place Icon into Circle") => 'yes' ),
        ),
        array(
            "type" => "textfield",
            "heading" => __("Title", "js_composer"),
            "param_name" => "title",
            "holder" => "div",
            "value" => __("Iconbox Title", "js_composer"),
            "description" => ''
        ),
        array(
            "type" => "textarea",
//			'admin_label' => true,
            "heading" => __("Iconbox Content", "js_composer"),
            "param_name" => "content",
            "value" => __("Click here to add your own text", "js_composer"),
            "description" => ''
        ),
        array(
            "type" => "textfield",
            "heading" => __("Link (optional)", "js_composer"),
            "param_name" => "link",
            "value" => "",
            "description" => ""
        ),
        array(
            "type" => "checkbox",
            "heading" => __("External Link", "js_composer"),
            "param_name" => "external",
            "value" => array(__("Opens in new tab") => 1 ),
            "dependency" => Array('element' => "href", 'not_empty' => true)
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Image (optional)", "js_composer"),
            "param_name" => "img",
            "value" => "",
            "description" => __("Path to 32x32 px image. Image overrides icon setting)", "js_composer")
        ),
    ),
) );

/* Icon
---------------------------------------------------------- */
//vc_map( array(
//    "name" => __("Icon", "js_composer"),
//    "base" => "vc_icon",
//    "icon" => "icon-wpb-ui-separator-label",
//    "category" => __('Content', 'js_composer'),
//    "params" => array(
//        array(
//            "type" => "textfield",
//            "heading" => __("Icon", "js_composer"),
//            "param_name" => "icon",
//            "value" => 'star',
//            "description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
//        ),
//        array(
//            "type" => "dropdown",
//            "heading" => __("Color Style", "js_composer"),
//            "param_name" => "color",
//            "value" => array(__("Text Color", "js_composer") => "", __("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Faded (theme color)", "js_composer") => "fade", __("Border (theme color)", "js_composer") => "border"),
//            "description" => '',
//        ),
//        array(
//            "type" => "dropdown",
//            "heading" => __("Size", "js_composer"),
//            "param_name" => "size",
//            "value" => array(__("Tiny", "js_composer") => "tiny", __("Small", "js_composer") => "small", __("Medium", "js_composer") => "medium", __("Big", "js_composer") => "big", __("Huge", "js_composer") => "huge"),
//        ),
//        array(
//            "type" => "checkbox",
//            "heading" => __("With Circle", "js_composer"),
//            "param_name" => "with_circle",
//            "value" => array(__("Place Icon into Circle") => 'yes' ),
//        ),
//        array(
//            "type" => "textfield",
//            "heading" => __("Link (optional)", "js_composer"),
//            "param_name" => "link",
//            "value" => "",
//            "description" => ""
//        ),
//        array(
//            "type" => "checkbox",
//            "heading" => __("External Link", "js_composer"),
//            "param_name" => "external",
//            "value" => array(__("Opens in new tab") => 1 ),
//            "dependency" => Array('element' => "href", 'not_empty' => true)
//        ),
//    ),
//) );

/* Testimonial
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Testimonial", "js_composer"),
	"base" => "vc_testimonial",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Name", "js_composer"),
			"param_name" => "author",
			"value" => __("Name", "js_composer"),
			"description" => __("Enter the Name of the Person to quote", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Subtitle", "js_composer"),
			"param_name" => "company",
			"value" => '',
			"description" => __("Can be used for a job description", "js_composer")
		),
		array(
			"type" => "textarea",
			'admin_label' => true,
			"heading" => __("Quote", "js_composer"),
			"param_name" => "content",
			"value" => __("Text goes here", "js_composer"),
			"description" => ''
		),
	),
) );

/* Team Member
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Team Member", "js_composer"),
	"base" => "vc_member",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Team Member Name", "js_composer"),
			"param_name" => "name",
			"holder" => "div",
			"value" => __("John Doe", "js_composer"),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Team Member Role", "js_composer"),
			"param_name" => "role",
			"value" => '',
			"description" => ''
		),
		array(
			"type" => "attach_image",
			"heading" => __("Team Member Photo", "js_composer"),
			"param_name" => "img",
			"value" => "",
			"description" => __("Either upload a new, or choose an existing image from your media library", "js_composer")
		),
		array(
			"type" => "textarea",
//			'admin_label' => true,
			"heading" => __("Team Member Description (optional)", "js_composer"),
			"param_name" => "content",
			"value" => '',
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Link (optional)", "js_composer"),
			"param_name" => "link",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Email (optional)", "js_composer"),
			"param_name" => "email",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Facebook profile (optional)", "js_composer"),
			"param_name" => "facebook",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Twitter profile (optional)", "js_composer"),
			"param_name" => "twitter",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Google+ profile (optional)", "js_composer"),
			"param_name" => "google_plus",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("LinkedIn profile (optional)", "js_composer"),
			"param_name" => "linkedin",
			"value" => "",
			"description" => '',
		),
	),
) );

/* Portfolio
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Portfolio", "js_composer"),
	"base" => "vc_portfolio",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Columns", "js_composer"),
            "param_name" => "columns",
            "value" => array('5' => '5', '4' => '4', '3' => '3', '2' => '2',),
            "description" => ''
        ),
        array(
            "type" => "textfield",
            "heading" => __("Items Quantity", "js_composer"),
            "param_name" => "items",
            "value" => '',
            "description" => __("If left blank, equals amount of Columns", "js_composer"),
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Pagination", "js_composer"),
            "param_name" => "pagination",
            "description" => __("If checked, Items Quantity parameter sets amount of Items per page", "js_composer"),
            "value" => Array(__("Turn on pagination", "js_composer") => 'yes')
        ),
		array(
			"type" => "dropdown",
			"heading" => __("Item Ratio", "js_composer"),
			"param_name" => "ratio",
			"value" => array('3:2 (landscape)' => '3:2', '4:3 (landscape)' => '4:3', '1:1 (square)' => '1:1', '2:3 (portrait)' => '2:3', '3:4 (portrait)' => '3:4',),
			"description" => ''
		),
        array(
            "type" => 'checkbox',
            "heading" => __("Item Indents", "js_composer"),
            "param_name" => "no_indents",
            "description" => "",
            "value" => Array(__("Remove indents between Items", "js_composer") => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Filtering", "js_composer"),
            "param_name" => "filters",
            "description" => "",
            "value" => Array(__("Display bar with filtering by category", "js_composer") => 'yes')
        ),
		array(
			"type" => "checkbox",
			"heading" => __("Display Items of selected categories", "js_composer"),
			"param_name" => "category",
			"value" => $portfolio_categories,
			"description" => ''
		),
	),

) );/* Blog
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Blog", "js_composer"),
	"base" => "vc_blog",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Layout Type", "js_composer"),
			"param_name" => "type",
			"value" => array('Large Image' => 'large_image', 'Small Square Image' => 'small_square_image', 'Small Circle Image' => 'small_circle_image', 'Masonry Grid' => 'masonry_paginated',),
			"description" => ''
		),
        array(
            "type" => "textfield",
            "heading" => __("Posts Quantity", "js_composer"),
            "param_name" => "items",
            "value" => '',
            "description" => ''
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Pagination", "js_composer"),
            "param_name" => "pagination",
            "description" => __("If checked, Posts Quantity parameter sets amount of Posts per page", "js_composer"),
            "value" => Array(__("Turn on pagination", "js_composer") => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Date", "js_composer"),
            "param_name" => "show_date",
            "description" => "",
            "value" => Array(__("Show Post Date", "js_composer") => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Author", "js_composer"),
            "param_name" => "show_author",
            "description" => "",
            "value" => Array(__("Show Post Author", "js_composer") => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Categories", "js_composer"),
            "param_name" => "show_categories",
            "description" => "",
            "value" => Array(__("Show Post Categories", "js_composer") => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Tags", "js_composer"),
            "param_name" => "show_tags",
            "description" => "",
            "value" => Array(__("Show Post Tags", "js_composer") => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Comments", "js_composer"),
            "param_name" => "show_comments",
            "description" => "",
            "value" => Array(__("Show Post Comments", "js_composer") => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Read More", "js_composer"),
            "param_name" => "show_read_more",
            "description" => "",
            "value" => Array(__("Show Read More Buttons", "js_composer") => 'yes')
        ),
		array(
			"type" => "checkbox",
			"heading" => __("Display Posts of selected categories", "js_composer"),
			"param_name" => "category",
			"value" => $post_categories,
			"description" => ''
		),
	),

) );

/* Clients
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Client Logos", "js_composer"),
	"base" => "vc_clients",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
    "params" => array(
        array(
            "type" => 'checkbox',
            "heading" => __("Auto Scroll", "js_composer"),
            "param_name" => "auto_scroll",
//      "description" => __("Select checkbox to allow for all sections to be be collapsible.", "js_composer"),
            "value" => Array(__("Scroll Clients Logos automatically", "js_composer") => 'yes')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Auto Scroll Interval", "js_composer"),
            "param_name" => "interval",
//            "holder" => "div",
            "value" => 1,
            "description" => 'Interval in seconds for Auto Scroll',
//            "dependency" => Array('element' => "auto_scroll", 'not_empty' => true)
        ),
    ),

) );

/* ActionBox
---------------------------------------------------------- */
vc_map( array(
	"name" => __("ActionBox", "js_composer"),
	"base" => "vc_actionbox",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("ActionBox Color", "js_composer"),
			"param_name" => "type",
			"value" => array(__('Primary Color', "js_composer") => "primary", __('Alternate Color', "js_composer") => "alternate",),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("ActionBox Title", "js_composer"),
			"param_name" => "title",
			"holder" => "div",
			"value" => __("This is ActionBox", "js_composer"),
			"description" => ''
		),
		array(
			"type" => "textarea",
//			'admin_label' => true,
			"heading" => __("ActionBox Text", "js_composer"),
			"param_name" => "message",
			"value" => '',
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Button 1 Label", "js_composer"),
			"param_name" => "button1",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Button 1 Link", "js_composer"),
			"param_name" => "link1",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 1 Color", "js_composer"),
			"param_name" => "style1",
			"value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal"),
			"description" => '',
		),
        array(
            "type" => 'checkbox',
            "heading" => __("Button 1 Outlined", "js_composer"),
            "param_name" => "outlined1",
//      "description" => __("Select checkbox to allow for all sections to be be collapsible.", "js_composer"),
            "value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes')
        ),
		array(
			"type" => "dropdown",
			"heading" => __("Button 1 Size", "js_composer"),
			"param_name" => "size1",
			"value" => array(__("Normal", "js_composer") => "", __("Small", "js_composer") => "small", __("Big", "js_composer") => "big"),

		),
        array(
            "type" => "textfield",
            "heading" => __("Button 1 Icon (optional)", "js_composer"),
            "param_name" => "icon1",
            "description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Button 1 Target", "js_composer"),
            "param_name" => "target1",
            "value" => $target_arr,
        ),
		array(
			"type" => "textfield",
			"heading" => __("Button 2 Label", "js_composer"),
			"param_name" => "button2",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Button 2 Link", "js_composer"),
			"param_name" => "link2",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 2 Color", "js_composer"),
			"param_name" => "style2",
			"value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal"),
			"description" => '',
		),
        array(
            "type" => 'checkbox',
            "heading" => __("Button 2 Outlined", "js_composer"),
            "param_name" => "outlined2",
//      "description" => __("Select checkbox to allow for all sections to be be collapsible.", "js_composer"),
            "value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes')
        ),
		array(
			"type" => "dropdown",
			"heading" => __("Button 2 Size", "js_composer"),
			"param_name" => "size2",
			"value" => array(__("Normal", "js_composer") => "", __("Small", "js_composer") => "small", __("Big", "js_composer") => "big"),

		),
        array(
            "type" => "textfield",
            "heading" => __("Button 2 Icon (optional)", "js_composer"),
            "param_name" => "icon2",
            "description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Button 2 Target", "js_composer"),
            "param_name" => "target2",
            "value" => $target_arr,
        ),
	),
) );

/* Video element
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Video Player", "js_composer"),
	"base" => "vc_video",
	"icon" => "icon-wpb-film-youtube",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => "textfield",
			"heading" => __("Video link", "js_composer"),
			"param_name" => "link",
			"admin_label" => true,
			"description" => sprintf(__('Link to the video. More about supported formats at %s.', "js_composer"), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Ratio", "js_composer"),
			"param_name" => "ratio",
			"value" => array('16x9' => "16-9", '4x3' => "4-3", '3x2' => "3-2", '1x1' => "1-1", ),
			"description" => ''
		),

	)
) );

/* Message box
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Message Box", "js_composer"),
  "base" => "vc_message",
  "icon" => "icon-wpb-information-white",
  "wrapper_class" => "alert",
  "category" => __('Content', 'js_composer'),
  "params" => array(
    array(
      "type" => "dropdown",
      "heading" => __("Message Box Color", "js_composer"),
      "param_name" => "type",
      "value" => array(__('Notification (blue)', "js_composer") => "info", __('Attention (yellow)', "js_composer") => "attention", __('Success (green)', "js_composer") => "success", __('Error (red)', "js_composer") => "error"),
      "description" => ''
    ),
    array(
      "type" => "textarea",
      "holder" => "div",
      "class" => "content",
      "heading" => __("Message Text", "js_composer"),
      "param_name" => "content",
      "value" => __("I am message box. Click edit button to change this text.", "js_composer")
    ),
  ),
  "js_view" => 'VcMessageView'
) );



/* Button
---------------------------------------------------------- */
$icons_arr = array(
    __("None", "js_composer") => "none",
    __("Address book icon", "js_composer") => "wpb_address_book",
    __("Alarm clock icon", "js_composer") => "wpb_alarm_clock",
    __("Anchor icon", "js_composer") => "wpb_anchor",
    __("Application Image icon", "js_composer") => "wpb_application_image",
    __("Arrow icon", "js_composer") => "wpb_arrow",
    __("Asterisk icon", "js_composer") => "wpb_asterisk",
    __("Hammer icon", "js_composer") => "wpb_hammer",
    __("Balloon icon", "js_composer") => "wpb_balloon",
    __("Balloon Buzz icon", "js_composer") => "wpb_balloon_buzz",
    __("Balloon Facebook icon", "js_composer") => "wpb_balloon_facebook",
    __("Balloon Twitter icon", "js_composer") => "wpb_balloon_twitter",
    __("Battery icon", "js_composer") => "wpb_battery",
    __("Binocular icon", "js_composer") => "wpb_binocular",
    __("Document Excel icon", "js_composer") => "wpb_document_excel",
    __("Document Image icon", "js_composer") => "wpb_document_image",
    __("Document Music icon", "js_composer") => "wpb_document_music",
    __("Document Office icon", "js_composer") => "wpb_document_office",
    __("Document PDF icon", "js_composer") => "wpb_document_pdf",
    __("Document Powerpoint icon", "js_composer") => "wpb_document_powerpoint",
    __("Document Word icon", "js_composer") => "wpb_document_word",
    __("Bookmark icon", "js_composer") => "wpb_bookmark",
    __("Camcorder icon", "js_composer") => "wpb_camcorder",
    __("Camera icon", "js_composer") => "wpb_camera",
    __("Chart icon", "js_composer") => "wpb_chart",
    __("Chart pie icon", "js_composer") => "wpb_chart_pie",
    __("Clock icon", "js_composer") => "wpb_clock",
    __("Fire icon", "js_composer") => "wpb_fire",
    __("Heart icon", "js_composer") => "wpb_heart",
    __("Mail icon", "js_composer") => "wpb_mail",
    __("Play icon", "js_composer") => "wpb_play",
    __("Shield icon", "js_composer") => "wpb_shield",
    __("Video icon", "js_composer") => "wpb_video"
);



/* Counter
---------------------------------------------------------- */
vc_map( array(
    "name"		=> __("Counter", "js_composer"),
    "base"		=> "vc_counter",
    'icon'		=> 'icon-wpb-ui-separator',
    "category"  => __('Content', 'js_composer'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Number for Counter", "js_composer"),
            "param_name" => "count",
            "value" => "99",
            "description" => ''
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Number Color", "js_composer"),
            "param_name" => "color",
            "value" => array(__("Default (theme color)", "js_composer") => "", __("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary",),
            "description" => '',
        ),
        array(
            "type" => "textfield",
            "heading" => __("Title for Counter", "js_composer"),
            "param_name" => "title",
            "value" => "Projects completed",
            "description" => ''
        ),
        array(
            "type" => "textfield",
            "heading" => __("Prefix (optional)", "js_composer"),
            "param_name" => "prefix",
            "value" => "",
            "description" => 'Text before number'
        ),
        array(
            "type" => "textfield",
            "heading" => __("Suffix (optional)", "js_composer"),
            "param_name" => "suffix",
            "value" => "",
            "description" => 'Text after number'
        ),
    ),
) );


/* Contact form
---------------------------------------------------------- */
vc_map( array(
	"name"		=> __("Contact Form", "js_composer"),
	"base"		=> "vc_contact_form",
	'icon'		=> 'icon-wpb-ui-separator',
	"category"  => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Reciever Email", "js_composer"),
			"param_name" => "form_email",
			"value" => "",
			"description" => sprintf(__('Contact requests will be sent to this Email.', "js_composer"))
		),
		array(
			"type" => "dropdown",
			"heading" => __("Name Field State", "js_composer"),
			"param_name" => "form_name_field",
			"value" => array(__('Shown, required', "js_composer") => "required", __('Shown, not required', "js_composer") => "show", __('Hidden', "js_composer") => "not_show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Email Field State", "js_composer"),
			"param_name" => "form_email_field",
			"value" => array(__('Shown, required', "js_composer") => "required", __('Shown, not required', "js_composer") => "show", __('Hidden', "js_composer") => "not_show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Phone Field State", "js_composer"),
			"param_name" => "form_phone_field",
			"value" => array(__('Shown, required', "js_composer") => "required", __('Shown, not required', "js_composer") => "show", __('Hidden', "js_composer") => "not_show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Captcha", "js_composer"),
			"param_name" => "form_captcha",
			"value" => array(__('Don\'t Display Captcha', "js_composer") => "", __('Display Captcha', "js_composer") => "show"),
			"description" => ''
		),
        array(
            "type" => "dropdown",
            "heading" => __("Button Color", "js_composer"),
            "param_name" => "button_type",
            "value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal"),
            "description" => ''
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Outlined Button", "js_composer"),
            "param_name" => "button_outlined",
            "value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes'),
            "description" => ''
        ),
	),
) );



/* Contacts
---------------------------------------------------------- */
vc_map( array(
	"name"		=> __("Contacts", "js_composer"),
	"base"		=> "vc_contacts",
	'icon'		=> 'icon-wpb-ui-separator',
	"category"  => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Address", "js_composer"),
			"param_name" => "address",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Phone", "js_composer"),
			"param_name" => "phone",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Fax", "js_composer"),
			"param_name" => "fax",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Email", "js_composer"),
			"param_name" => "email",
			"value" => "",
			"description" => ''
		),
	),
) );

/* Social Links
---------------------------------------------------------- */
vc_map( array(
	"name"		=> __("Social Links", "js_composer"),
	"base"		=> "vc_social_links",
	'icon'		=> 'icon-wpb-ui-separator',
	"category"  => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Icons Size", "js_composer"),
			"param_name" => "size",
			"value" => array(__('Small', "js_composer") => "", __('Normal', "js_composer") => "normal", __('Big', "js_composer") => "big"),
			"description" => ''
		),
        array(
            "type" => "dropdown",
            "heading" => __("Alignment", "js_composer"),
            "param_name" => "align",
            "value" => array(__('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
            "description" => ''
        ),
		array(
			"type" => "textfield",
			"heading" => __("Email", "js_composer"),
			"param_name" => "email",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Facebook", "js_composer"),
			"param_name" => "facebook",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Twitter", "js_composer"),
			"param_name" => "twitter",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Google+", "js_composer"),
			"param_name" => "google",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("LinkedIn", "js_composer"),
			"param_name" => "linkedin",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("YouTube", "js_composer"),
			"param_name" => "youtube",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Vimeo", "js_composer"),
			"param_name" => "vimeo",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Flickr", "js_composer"),
			"param_name" => "flickr",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Instagram", "js_composer"),
			"param_name" => "instagram",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Behance", "js_composer"),
			"param_name" => "behance",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Xing", "js_composer"),
			"param_name" => "xing",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Pinterest", "js_composer"),
			"param_name" => "pinterest",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Skype", "js_composer"),
			"param_name" => "skype",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Tumblr", "js_composer"),
			"param_name" => "tumblr",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Dribbble", "js_composer"),
			"param_name" => "dribbble",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Vkontakte", "js_composer"),
			"param_name" => "vk",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("RSS", "js_composer"),
			"param_name" => "rss",
			"value" => "",
			"description" => ''
		),
	),
) );

/* Google maps element
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Google Maps", "js_composer"),
	"base" => "vc_gmaps",
	"icon" => "icon-wpb-map-pin",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Map Address", "js_composer"),
			"holder" => "div",
			"param_name" => "address",
			"value" => "1600 Amphitheatre Parkway, Mountain View, CA 94043, United States",
			"description" => ''
		),

		array(
			"type" => "textfield",
			"heading" => __("Map Marker text", "js_composer"),
			"param_name" => "marker",
			"description" => __("Leave blank to hide the Marker", "js_composer"),
		),
		array(
			"type" => "textfield",
			"heading" => __("Map height", "js_composer"),
			"param_name" => "height",
			"description" => __('Enter map height in pixels. Default: 400.', "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Map type", "js_composer"),
			"param_name" => "type",
			"value" => array(__("Roadmap", "js_composer") => "ROADMAP", __("Satellite", "js_composer") => "SATELLITE", __("Map + Terrain", "js_composer") => "HYBRID", __("Terrain", "js_composer") => "TERRAIN"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Map zoom", "js_composer"),
			"param_name" => "zoom",
			"value" => array(__("14 - Default", "js_composer") => 14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20)
		),
		array(
			"type" => "textfield",
			"heading" => __("Map Latitude", "js_composer"),
			"param_name" => "latitude",
			"description" => __("If Longitude and Latitude are set, they override the Address for Google Map.", "js_composer"),
		),
		array(
			"type" => "textfield",
			"heading" => __("Map Longitude", "js_composer"),
			"param_name" => "longitude",
			"description" => __("If Longitude and Latitude are set, they override the Address for Google Map.", "js_composer"),
		),
	)
) );

/* Latest posts
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Latest Posts", "js_composer"),
	"base" => "vc_latest_posts",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Posts Number", "js_composer"),
			"param_name" => "posts",
			"value" => array(2 => 2, 1 =>1, 3 =>3,),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Caregory", "js_composer"),
			"param_name" => "category",
			"value" => $post_categories,
			"description" => ''
		),
	),

) );

/* Raw HTML
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Raw HTML", "js_composer"),
	"base" => "vc_raw_html",
	"icon" => "icon-wpb-raw-html",
	"category" => __('Structure', 'js_composer'),
	"wrapper_class" => "clearfix",
	"params" => array(
		array(
  		"type" => "textarea_raw_html",
			"holder" => "div",
			"heading" => __("Raw HTML", "js_composer"),
			"param_name" => "content",
			"value" => base64_encode("<p>I am raw html block.<br/>Click edit button to change this html</p>"),
			"description" => __("Enter your HTML content.", "js_composer")
		),
	)
) );

/* Raw JS
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Raw JS", "js_composer"),
	"base" => "vc_raw_js",
	"icon" => "icon-wpb-raw-javascript",
	"category" => __('Structure', 'js_composer'),
	"wrapper_class" => "clearfix",
	"params" => array(
  	array(
  		"type" => "textarea_raw_html",
			"holder" => "div",
			"heading" => __("Raw js", "js_composer"),
			"param_name" => "content",
			"value" => __(base64_encode("<script type='text/javascript'> alert('Enter your js here!'); </script>"), "js_composer"),
			"description" => __("Enter your JS code.", "js_composer")
		),
	)
) );


/* Support for 3rd Party plugins
---------------------------------------------------------- */
// Contact form 7 plugin
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
  global $wpdb;
  $cf7 = $wpdb->get_results(
  	"
  	SELECT ID, post_title
  	FROM $wpdb->posts
  	WHERE post_type = 'wpcf7_contact_form'
  	"
  );
  $contact_forms = array();
  if ($cf7) {
    foreach ( $cf7 as $cform ) {
      $contact_forms[$cform->post_title] = $cform->ID;
    }
  } else {
    $contact_forms["No contact forms found"] = 0;
  }
  vc_map( array(
    "base" => "contact-form-7",
    "name" => __("Contact Form 7", "js_composer"),
    "icon" => "icon-wpb-contactform7",
    "category" => __('Content', 'js_composer'),
    "params" => array(
      array(
        "type" => "textfield",
        "heading" => __("Form title", "js_composer"),
        "param_name" => "title",
        "admin_label" => true,
        "description" => __("What text use as form title. Leave blank if no title is needed.", "js_composer")
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Select contact form", "js_composer"),
        "param_name" => "id",
        "value" => $contact_forms,
        "description" => __("Choose previously created contact form from the drop down list.", "js_composer")
      )
    )
  ) );
} // if contact form7 plugin active

if (is_plugin_active('LayerSlider/layerslider.php')) {
  global $wpdb;
  $ls = $wpdb->get_results(
  	"
  	SELECT id, name, date_c
  	FROM ".$wpdb->prefix."layerslider
  	WHERE flag_hidden = '0' AND flag_deleted = '0'
  	ORDER BY date_c ASC LIMIT 100
  	"
  );
  $layer_sliders = array();
  if ($ls) {
    foreach ( $ls as $slider ) {
      $layer_sliders[$slider->name] = $slider->id;
    }
  } else {
    $layer_sliders["No sliders found"] = 0;
  }
  vc_map( array(
    "base" => "layerslider_vc",
    "name" => __("Layer Slider", "js_composer"),
    "icon" => "icon-wpb-layerslider",
    "category" => __('Content', 'js_composer'),
    "params" => array(
      array(
        "type" => "textfield",
        "heading" => __("Widget title", "js_composer"),
        "param_name" => "title",
        "description" => __("What text use as a widget title. Leave blank if no title is needed.", "js_composer")
      ),
      array(
        "type" => "dropdown",
        "heading" => __("LayerSlider ID", "js_composer"),
        "param_name" => "id",
        "admin_label" => true,
        "value" => $layer_sliders,
        "description" => __("Select your LayerSlider.", "js_composer")
      ),
//      array(
//        "type" => "textfield",
//        "heading" => __("Extra class name", "js_composer"),
//        "param_name" => "el_class",
//        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//      )
    )
  ) );
} // if layer slider plugin active

if (is_plugin_active('revslider/revslider.php')) {
  global $wpdb;
  $rs = $wpdb->get_results(
  	"
  	SELECT id, title, alias
  	FROM ".$wpdb->prefix."revslider_sliders
  	ORDER BY id ASC LIMIT 100
  	"
  );
  $revsliders = array();
  if ($rs) {
    foreach ( $rs as $slider ) {
      $revsliders[$slider->title] = $slider->alias;
    }
  } else {
    $revsliders["No sliders found"] = 0;
  }
  vc_map( array(
    "base" => "rev_slider_vc",
    "name" => __("Revolution Slider", "js_composer"),
    "icon" => "icon-wpb-revslider",
    "category" => __('Content', 'js_composer'),
    "params"=> array(
      array(
        "type" => "textfield",
        "heading" => __("Widget title", "js_composer"),
        "param_name" => "title",
        "description" => __("What text use as a widget title. Leave blank if no title is needed.", "js_composer")
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Revolution Slider", "js_composer"),
        "param_name" => "alias",
        "admin_label" => true,
        "value" => $revsliders,
        "description" => __("Select your Revolution Slider.", "js_composer")
      ),
//      array(
//        "type" => "textfield",
//        "heading" => __("Extra class name", "js_composer"),
//        "param_name" => "el_class",
//        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//      )
    )
  ) );
} // if revslider plugin active

if (is_plugin_active('gravityforms/gravityforms.php')) {
  $gravity_forms_array[__("No Gravity forms found.", "js_composer")] = '';
  if ( class_exists('RGFormsModel') ) {
    $gravity_forms = RGFormsModel::get_forms(1, "title");
    if ($gravity_forms) {
      $gravity_forms_array = array(__("Select a form to display.", "js_composer") => '');
      foreach ( $gravity_forms as $gravity_form ) {
        $gravity_forms_array[$gravity_form->title] = $gravity_form->id;
      }
    }
  }
  vc_map( array(
    "name" => __("Gravity Form", "js_composer"),
    "base" => "gravityform",
    "icon" => "icon-wpb-vc_gravityform",
    "category" => __("Content", "js_composer"),
    "params" => array(
      array(
        "type" => "dropdown",
        "heading" => __("Form", "js_composer"),
        "param_name" => "id",
        "value" => $gravity_forms_array,
        "description" => __("Select a form to add it to your post or page.", "js_composer"),
        "admin_label" => true
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Display Form Title", "js_composer"),
        "param_name" => "title",
        "value" => array( __("No", "js_composer") => 'false', __("Yes", "js_composer") => 'true' ),
        "description" => __("Would you like to display the forms title?", "js_composer"),
        "dependency" => Array('element' => "id", 'not_empty' => true)
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Display Form Description", "js_composer"),
        "param_name" => "description",
        "value" => array( __("No", "js_composer") => 'false', __("Yes", "js_composer") => 'true' ),
        "description" => __("Would you like to display the forms description?", "js_composer"),
        "dependency" => Array('element' => "id", 'not_empty' => true)
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Enable AJAX?", "js_composer"),
        "param_name" => "ajax",
        "value" => array( __("No", "js_composer") => 'false', __("Yes", "js_composer") => 'true' ),
        "description" => __("Enable AJAX submission?", "js_composer"),
        "dependency" => Array('element' => "id", 'not_empty' => true)
      ),
      array(
        "type" => "textfield",
        "heading" => __("Tab Index", "js_composer"),
        "param_name" => "tabindex",
        "description" => __("(Optional) Specify the starting tab index for the fields of this form. Leave blank if you're not sure what this is.", "js_composer"),
        "dependency" => Array('element' => "id", 'not_empty' => true)
      )
    )
  ) );
} // if gravityforms active

/* WordPress default Widgets (Appearance->Widgets)
---------------------------------------------------------- */
vc_map( array(
  "name" => 'WP ' . __("Search"),
  "base" => "vc_wp_search",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );

vc_map( array(
  "name" => 'WP ' . __("Meta"),
  "base" => "vc_wp_meta",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );

vc_map( array(
  "name" => 'WP ' . __("Recent Comments"),
  "base" => "vc_wp_recentcomments",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "textfield",
      "heading" => __("Number of comments to show", "js_composer"),
      "param_name" => "number",
      "admin_label" => true
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );

vc_map( array(
  "name" => 'WP ' . __("Calendar"),
  "base" => "vc_wp_calendar",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );

vc_map( array(
  "name" => 'WP ' . __("Pages"),
  "base" => "vc_wp_pages",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Sort by", "js_composer"),
      "param_name" => "sortby",
      "value" => array(__("Page title", "js_composer") => "post_title", __("Page order", "js_composer") => "menu_order", __("Page ID", "js_composer") => "ID"),
      "admin_label" => true
    ),
    array(
      "type" => "textfield",
      "heading" => __("Exclude", "js_composer"),
      "param_name" => "exclude",
      "description" => __("Page IDs, separated by commas.", "js_composer"),
      "admin_label" => true
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );

$tag_taxonomies = array();
foreach ( get_taxonomies() as $taxonomy ) :
  $tax = get_taxonomy($taxonomy);
	if ( !$tax->show_tagcloud || empty($tax->labels->name) )
  	continue;
	$tag_taxonomies[$tax->labels->name] = esc_attr($taxonomy);
endforeach;
vc_map( array(
  "name" => 'WP ' . __("Tag Cloud"),
  "base" => "vc_wp_tagcloud",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Taxonomy", "js_composer"),
      "param_name" => "taxonomy",
      "value" => $tag_taxonomies,
      "admin_label" => true
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );

//$custom_menus = array();
//$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
//if ( is_array($menus) ) {
//  foreach ( $menus as $single_menu ) {
//    $custom_menus[$single_menu->name] = $single_menu->term_id;
//  }
//  vc_map( array(
//    "name" => 'WP ' . __("Custom Menu"),
//    "base" => "vc_wp_custommenu",
//    "icon" => "icon-wpb-wp",
//    "category" => __("WordPress Widgets", "js_composer"),
//    "class" => "wpb_vc_wp_widget",
//    "params" => array(
//      array(
//        "type" => "textfield",
//        "heading" => __("Widget title", "js_composer"),
//        "param_name" => "title",
//        "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
//      ),
//      array(
//        "type" => "dropdown",
//        "heading" => __("Menu", "js_composer"),
//        "param_name" => "nav_menu",
//        "value" => $custom_menus,
//        "description" => __("Select menu", "js_composer"),
//        "admin_label" => true
//      ),
//      array(
//        "type" => "textfield",
//        "heading" => __("Extra class name", "js_composer"),
//        "param_name" => "el_class",
//        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//      )
//    )
//  ) );
//}

vc_map( array(
  "name" => 'WP ' . __("Text"),
  "base" => "vc_wp_text",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "textarea",
      "heading" => __("Text", "js_composer"),
      "param_name" => "text",
      "admin_label" => true
    ),
    /*array(
      "type" => "checkbox",
      "heading" => __("Automatically add paragraphs", "js_composer"),
      "param_name" => "filter"
    ),*/
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );


vc_map( array(
  "name" => 'WP ' . __("Recent Posts"),
  "base" => "vc_wp_posts",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "textfield",
      "heading" => __("Number of posts to show", "js_composer"),
      "param_name" => "number",
      "admin_label" => true
    ),
    array(
      "type" => "checkbox",
      "heading" => __("Display post date?", "js_composer"),
      "param_name" => "show_date",
      "value" => array(__("Display post date?") => true )
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );


$link_category = array(__("All Links", "js_composer") => "");
$link_cats = get_terms( 'link_category' );
if ( is_array($link_cats) ) {
  foreach ( $link_cats as $link_cat ) {
    $link_category[$link_cat->name] = $link_cat->term_id;
  }
}
  vc_map( array(
    "name" => 'WP ' . __("Links"),
    "base" => "vc_wp_links",
    "icon" => "icon-wpb-wp",
    "category" => __("WordPress Widgets", "js_composer"),
    "class" => "wpb_vc_wp_widget",
    "params" => array(
      array(
        "type" => "dropdown",
        "heading" => __("Link Category", "js_composer"),
        "param_name" => "category",
        "value" => $link_category,
        "admin_label" => true
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Sort by", "js_composer"),
        "param_name" => "orderby",
        "value" => array(__("Link title", "js_composer") => "name", __("Link rating", "js_composer") => "rating", __("Link ID", "js_composer") => "id", __("Random", "js_composer") => "rand")
      ),
      array(
        "type" => "checkbox",
        "heading" => __("Options", "js_composer"),
        "param_name" => "options",
        "value" => array(__("Show Link Image", "js_composer") => "images", __("Show Link Name", "js_composer") => "name", __("Show Link Description", "js_composer") => "description", __("Show Link Rating", "js_composer") => "rating")
      ),
      array(
        "type" => "textfield",
        "heading" => __("Number of links to show", "js_composer"),
        "param_name" => "limit"
      ),
//      array(
//        "type" => "textfield",
//        "heading" => __("Extra class name", "js_composer"),
//        "param_name" => "el_class",
//        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//      )
    )
  ) );

vc_map( array(
  "name" => 'WP ' . __("Categories"),
  "base" => "vc_wp_categories",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "checkbox",
      "heading" => __("Options", "js_composer"),
      "param_name" => "options",
      "value" => array(__("Display as dropdown", "js_composer") => "dropdown", __("Show post counts", "js_composer") => "count", __("Show hierarchy", "js_composer") => "hierarchical")
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );


vc_map( array(
  "name" => 'WP ' . __("Archives"),
  "base" => "vc_wp_archives",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "checkbox",
      "heading" => __("Options", "js_composer"),
      "param_name" => "options",
      "value" => array(__("Display as dropdown", "js_composer") => "dropdown", __("Show post counts", "js_composer") => "count")
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );

vc_map( array(
  "name" => 'WP ' . __("RSS"),
  "base" => "vc_wp_rss",
  "icon" => "icon-wpb-wp",
  "category" => __("WordPress Widgets", "js_composer"),
  "class" => "wpb_vc_wp_widget",
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank to use default widget title.", "js_composer")
    ),
    array(
      "type" => "textfield",
      "heading" => __("RSS feed URL", "js_composer"),
      "param_name" => "url",
      "description" => __("Enter the RSS feed URL.", "js_composer"),
      "admin_label" => true
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Items", "js_composer"),
      "param_name" => "items",
      "value" => array(__("10 - Default", "js_composer") => '', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20),
      "description" => __("How many items would you like to display?", "js_composer"),
      "admin_label" => true
    ),
    array(
      "type" => "checkbox",
      "heading" => __("Options", "js_composer"),
      "param_name" => "options",
      "value" => array(__("Display item content?", "js_composer") => "show_summary", __("Display item author if available?", "js_composer") => "show_author", __("Display item date?", "js_composer") => "show_date")
    ),
//    array(
//      "type" => "textfield",
//      "heading" => __("Extra class name", "js_composer"),
//      "param_name" => "el_class",
//      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
//    )
  )
) );
/*
//BETA: Not ready for use on live website
vc_map( array(
    "name" => __("Items", "js_composer"),
    "base" => "vc_items",
    "as_parent" => array('only' => 'vc_item'),
    "content_element" => true,
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
    ),
    "js_view" => 'VcColumnView'
) );
vc_map( array(
    "name" => __("Item", "js_composer"),
    "base" => "vc_item",
    "content_element" => true,
    "as_child" => array('only' => 'vc_items'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
    )
) );
// TODO: create abstract class with parent as WPBakeryShortCode_VC_Column and custom css and html settings for admin
class WPBakeryShortCode_VC_Items extends WPBakeryShortCode_VC_Column {

}*/
/**
 * New teaser grid !!
 */
/*
vc_map( array(
    "name" => __("Posts Grid", "js_composer"),
    "base" => "vc_posts_grid",
    "is_container" => true,
    "icon" => "icon-wpb-application-icon-large",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "js_composer"),
            "param_name" => "title",
            "description" => __("What text use as a widget title. Leave blank if no title is needed.", "js_composer")
        ),
        array(
            "type" => "loop",
            "heading" => __("Loop", "js_composer"),
            "param_name" => "loop",
            'settings' => array(
                'size' => array('hidden' => false, 'value' => 90),
                'order_by' => array('value' => 'date'),
            ),
            "description" => __("Create super mega query.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Columns count", "js_composer"),
            "param_name" => "grid_columns_count",
            "value" => array(6, 4, 3, 2, 1),
            "admin_label" => true,
            "description" => __("Select columns count.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Content", "js_composer"),
            "param_name" => "grid_content",
            "value" => array(__("Teaser (Excerpt)", "js_composer") => "teaser", __("Full Content", "js_composer") => "content"),
            "description" => __("Teaser layout template.", "js_composer")
        ),
        array(
            "type" => "teaser_template",
            "heading" => __("Layout", "js_composer"),
            "param_name" => "grid_layout",
            "description" => __("Teaser layout.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link", "js_composer"),
            "param_name" => "grid_link",
            "value" => array(__("Link to post", "js_composer") => "link_post", __("Link to bigger image", "js_composer") => "link_image", __("Thumbnail to bigger image, title to post", "js_composer") => "link_image_post", __("No link", "js_composer") => "link_no"),
            "description" => __("Link type.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link target", "js_composer"),
            "param_name" => "grid_link_target",
            "value" => $target_arr,
            "dependency" => Array('element' => "grid_link", 'value' => array('link_post', 'link_image_post'))
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Show filter", "js_composer"),
            "param_name" => "filter",
            "value" => array(__("Yes", "js_composer") => "yes"),
            "description" => __("use filter for settings.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Layout mode", "js_composer"),
            "param_name" => "grid_layout_mode",
            "value" => array(__("Fit rows", "js_composer") => "fitRows", __('Masonry', "js_composer") => 'masonry'),
            "description" => __("Teaser layout template.", "js_composer")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Thumbnail size", "js_composer"),
            "param_name" => "grid_thumb_size",
            "description" => __('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).', "js_composer")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        ),
        array(
            "type" => "teaser_template",
            "heading" => __("Layout", "js_composer"),
            "param_name" => "grid_layout",
            "description" => __("Teaser layout.", "js_composer")
        )
)
// 'html_template' => dirname(__DIR__).'/composer/shortcodes_templates/vc_posts_grid.php'
) );
VcTeaserTemplates::getInstance('vc_posts_grid', 'teaser_template');
*/

/*
vc_map( array(
    "name" => __("Carousel", 'vc_extend'),
    "base" => "vc_carousel",
    "class" => "",
    "icon" => "icon-wpb-vc_carousel",
    "category" => __('Content', 'js_composer'),
    "params" => array(
        array(
            "type" => "loop",
            "heading" => __("Data query", "js_composer"),
            "param_name" => "posts_query",
            'settings' => array(
                'size' => array('hidden' => false, 'value' => 90),
                'order_by' => array('value' => 'date')
            ),
            "description" => __("Setup database query", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Content", "js_composer"),
            "param_name" => "content",
            "value" => array(__("Teaser (Excerpt)", "js_composer") => "teaser", __("Full Content", "js_composer") => "content"),
            "description" => __("Teaser layout template.", "js_composer")
        ),
        array(
            "type" => "teaser_template",
            "heading" => __("Layout", "js_composer"),
            "param_name" => "layout",
            "description" => __("Teaser layout.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link", "js_composer"),
            "param_name" => "link",
            "value" => array(__("Link to post", "js_composer") => "link_post", __("Link to bigger image", "js_composer") => "link_image", __("Thumbnail to bigger image, title to post", "js_composer") => "link_image_post", __("No link", "js_composer") => "link_no"),
            "description" => __("Link type.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link target", "js_composer"),
            "param_name" => "link_target",
            "value" => $target_arr,
            "dependency" => Array('element' => "grid_link", 'value' => array('link_post', 'link_image_post'))
        ),
        array(
            "type" => "textfield",
            "heading" => __("Thumbnail size", "js_composer"),
            "param_name" => "thumb_size",
            "description" => __('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).', "js_composer")
        ),
        array(
            "type" => "options",
            "heading" => __("Slider options", "js_composer"),
            "param_name" => "bxslider_options",
            "description" => __("", "js_composer"),
            "options" => array(
                array(
                    "type" => "separator",
                    "label" => "General"
                ),
                array(
                    "type" => "select",
                    "label" => __("Mode", "js_composer"),
                    "name" => "mode",
                    "options" => array(
                        array("horizontal", __('Horizontal', "js_composer")),
                        array("vertical", __('Vertical', "js_composer")),
                        array("fade", __('Fade', "js_composer")),
                    ),
                    "description" => __("Type of transition between slides", "js_composer")
                ),
                array(
                    "type" => "input",
                    "label" => __("Speed", "js_composer"),
                    "name" => "speed",
                    "description" => __("Slide transition duration (in ms)", "js_composer"),
                    "value" => "500"
                ),
                array(
                    "type" => "input",
                    "label" => __("Slide Margin", "js_composer"),
                    "name" => "slideMargin",
                    "description" => __("Margin between each slide", "js_composer"),
                    "value" => "0"

                ),
                array(
                    "type" => "input",
                    "label" => __("Start Slide", "js_composer"),
                    "name" => "startSlide",
                    "description" => __("Starting slide index (zero-based)", "js_composer"),
                    "value" => "0"
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Random start", "js_composer"),
                    "name" => "randomStart",
                    "description" => __("Start slider on a random slide", "js_composer"),
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Infinite loop", "js_composer"),
                    "name" => "infiniteLoop",
                    "description" => __('If Yes, clicking "Next" while on the last slide will transition to the first slide and vice-versa', "js_composer"),
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Hide Control on end", "js_composer"),
                    "name" => "hideControlOnEnd",
                    "description" => __('If Yes, "Next" control will be hidden on last slide and vice-versa. Note: Only used when not infinite loop', "js_composer"),
                ),
                array(
                    "type" => "select",
                    "label" => __("Easing", "js_composer"),
                    "name" => "easing",
                    "options" => array(
                        "linear", "ease", "ease-in", "ease-out", "ease-in-out"
                    ),
                    "description" => __('The type of "easing" to use during transitions', "js_composer")
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Adaptive height", "js_composer"),
                    "name" => "adaptiveHeight",
                    "description" => __("Dynamically adjust slider height based on each slide's height", "js_composer"),
                ),
                array(
                    "type" => "input",
                    "label" => __("Adaptive height speed", "js_composer"),
                    "name" => "adaptiveHeightSpeed",
                    "description" => __("Slide height transition duration (in ms). Note: only used if adaptive height is enabled", "js_composer"),
                    "value" => "500"
                ),
                array(
                    "type" => "separator",
                    "label" => "Pager"
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Pager", "js_composer"),
                    "name" => "pager",
                    "description" => __("If Yes, a pager will be added", "js_composer"),
                    "value" => "true"
                ),
                array(
                    "type" => "select",
                    "label" => __("Pager type", "js_composer"),
                    "name" => "pagerType",
                    "options" => array(
                        'full', 'short'
                    ),
                    "description" => __('If "full", a pager link will be generated for each slide. If "short", a x / y pager will be used (ex. 1 / 5)', "js_composer")
                ),
                array(
                    "type" => "input",
                    "label" => __("Short pager separator", "js_composer"),
                    "name" => "pagerShortSeparator",
                    "description" => __('If pagerType: "short", pager will use this value as the separating character', "js_composer"),
                    "value" => " / "
                ),
                array(
                    "type" => "separator",
                    "label" => "Controls"
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Controls", "js_composer"),
                    "name" => "controls",
                    "description" => __('If Yes, "Next" / "Prev" controls will be added', "js_composer"),
                    "value" => "true"
                ),
                array(
                    "type" => "input",
                    "label" => __("Next text", "js_composer"),
                    "name" => "nextText",
                    "description" => __('Text to be used for the "Next" control', "js_composer"),
                    "value" => "Next"
                ),
                array(
                    "type" => "input",
                    "label" => __("Prev text", "js_composer"),
                    "name" => "prevText",
                    "description" => __('Text to be used for the "Prev" control', "js_composer"),
                    "value" => "Prev"
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Auto controls", "js_composer"),
                    "name" => "autoControls",
                    "description" => __('If Yes, "Start" / "Stop" controls will be added', "js_composer"),
                ),
                array(
                    "type" => "input",
                    "label" => __("Start text", "js_composer"),
                    "name" => "startText",
                    "description" => __('Text to be used for the "Start" control', "js_composer"),
                    "value" => "Start"
                ),
                array(
                    "type" => "input",
                    "label" => __("Stop text", "js_composer"),
                    "name" => "stopText",
                    "description" => __('Text to be used for the "Stop" control', "js_composer"),
                    "value" => "Stop"
                ),
                array(
                    "type" => "boolean",
                    "label" => __("Auto controls combine", "js_composer"),
                    "name" => "autoControlsCombine",
                    "description" => __('When slideshow is playing only "Stop" control is displayed and vice-versa', "js_composer")
                ),
                array(
                    "type" => "separator",
                    "label" => "Carousel"
                ),
                array(
                    "type" => "input",
                    "label" => __("Minimum slides", "js_composer"),
                    "name" => "minSlides",
                    "description" => __('The minimum number of slides to be shown. Slides will be sized down if carousel becomes smaller than the original size.', "js_composer"),
                    "value" => "1"
                ),
                array(
                    "type" => "input",
                    "label" => __("Maximum slides", "js_composer"),
                    "name" => "maxSlides",
                    "description" => __('The maximum number of slides to be shown. Slides will be sized up if carousel becomes larger than the original size.', "js_composer"),
                    "value" => "1"
                ),
                array(
                    "type" => "input",
                    "label" => __("Move slides", "js_composer"),
                    "name" => "moveSlides",
                    "description" => __('The number of slides to move on transition. This value must be >= minSlides, and <= maxSlides. If zero (default), the number of fully-visible slides will be used.', "js_composer"),
                    "value" => "0"
                ),
                array(
                    "type" => "input",
                    "label" => __("Slide width", "js_composer"),
                    "name" => "slideWidth",
                    "description" => __('The width of each slide. This setting is required for all horizontal carousels!', "js_composer"),
                    "value" => "0"
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
    )
));
*/
/*
WPBMap::layout(array('id'=>'column_12', 'title'=>'1/2'));
WPBMap::layout(array('id'=>'column_12-12', 'title'=>'1/2 + 1/2'));
WPBMap::layout(array('id'=>'column_13', 'title'=>'1/3'));
WPBMap::layout(array('id'=>'column_13-13-13', 'title'=>'1/3 + 1/3 + 1/3'));
WPBMap::layout(array('id'=>'column_13-23', 'title'=>'1/3 + 2/3'));
WPBMap::layout(array('id'=>'column_14', 'title'=>'1/4'));
WPBMap::layout(array('id'=>'column_14-14-14-14', 'title'=>'1/4 + 1/4 + 1/4 + 1/4'));
WPBMap::layout(array('id'=>'column_16', 'title'=>'1/6'));
WPBMap::layout(array('id'=>'column_11', 'title'=>'1/1'));

*/