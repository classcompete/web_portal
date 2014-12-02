<?php


/**
 * get classcompete marketplace list
 */
function get_cc_marketplace()
{
    $list = get_marketplace_list();
    return $list;
}

function the_cc_marketplace()
{
    echo get_cc_marketplace();
}

/**
 * get classcompete marketplace list by grade
 *
 * @param int $grade grade level 1-8
 * @return mixed
 */
function get_cc_marketplace_by_grade($grade)
{
    $list = get_marketplace_list($grade);
    return $list;
}

function the_cc_marketplace_by_grade($grade)
{
    echo get_cc_marketplace_by_grade($grade);
}

/** get classcompete marketplace single item by id */
function get_cc_marketplace_challange_by_id($id)
{
    $list = get_marketplace_list(null, $id);
    return $list;
}

function the_cc_marketplace_challenge_by_id($id)
{
    echo get_cc_marketplace_challange_by_id($id);
}

/** shortcodes */

function cc_marketplace_shortcode($args)
{
    if (isset($args['grade']) === true && empty($args['grade']) === false) {
        $list = get_cc_marketplace_by_grade($args['grade']);

        $html = '';
        foreach ($list as $item) {
            $html .= single_challenge_layout($item->challenge_name, $item->avatar, $item->grade);
        }

        $result = '<div>' . $html . '</div>';
    } else if (isset($args['id']) === true && empty($args['id']) === false) {
        $result = get_cc_marketplace_challange_by_id($args['id']);
    } else {
        $list = get_cc_marketplace();

        $html = '<ul class="filter clearfix">
					<li class="active"><a href="#" data-filter="*">All</a></li>
									<li><a title="2nd Grade" href="#" data-filter=".2nd-grade">2nd Grade</a></li>
									<li><a title="3rd Grade" href="#" data-filter=".3rd-grade">3rd Grade</a></li>
									<li><a title="4th Grade" href="#" data-filter=".4th-grade">4th Grade</a></li>
									<li><a title="5th Grade" href="#" data-filter=".5th-grade">5th Grade</a></li>
									<li><a title="6th Grade" href="#" data-filter=".6th-grade">6th Grade</a></li>
									<li><a title="7th Grade" href="#" data-filter=".7th-grade">7th Grade</a></li>
									<li><a title="8th Grade" href="#" data-filter=".8th-grade">8th Grade</a></li>
								</ul>';

        $html .= '<ul class="isotope challenge-list clearfix" data-type="challenge-list">';

        foreach ($list->grade as $grade_item) {
            foreach ($grade_item as $item) {
                $html .= single_challenge_layout($item);
            }
        }

        $html .= '</ul>';

        $result = '<div class="portfolio">' . $html . '</div>';

        $result .= '<!-- Modal -->
		<div id="modalbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
			</div>
		</div>';
    }

    return $result;
}


function cc_marketplace_by_grade_shortcode($args)
{
    return get_cc_marketplace_by_grade($args['grade']);
}

function cc_marketplace_challenge_by_id_shortcode($id)
{
    return get_cc_marketplace_challange_by_id($id);
}

function single_challenge_layout($item)
{
    $ordinal_no = add_ordinal_number_suffix($item->grade);

    $description = '';
    if (empty($item->description) === false) {
        $description = '<div class="tooltip_description"><span>Description</span><p>' . $item->description . '</p></div>';
    }

    $html = '<li class="item brick1 ' . $ordinal_no . '-grade isotope-item">
						<a class="cc_challenge" href="#">
							<img width="195" height="195" alt="' . $item->challenge_name . '"
							class="attachment-brick_thumb wp-post-image" src="' . blob2img($item->avatar) . '">
							<div class="hover" style="display: block; left: 0px; top: 100%;">
								<img alt="" src="' . get_template_directory_uri() . '/assets/img/ico_search.png">
								<h4>' . $item->challenge_name . '</h4>
								<p>' . $ordinal_no . ' Grade</p>
						    </div>
						</a>
						<article style="display: none" class="tooltip_content">
                                <h3 class="text_align_center"><b>' . $item->challenge_name . '</b></h3>

                                <div class="tooltip_author">
                                    <span>by:</span>
                                    <div>
                                        <span class="text_align_center">' . $item->author . '</span>
                                        <img src="' . blob2img($item->avatar) . '" class="tooltip_img">
                                    </div>
                                </div>

                                <dl class="inline">
                                    <dt>Subject:</dt>
                                    <dd>' . $item->subject . '</dd>
                                    <dt>Topic:</dt>
                                    <dd>' . $item->topic . '</dd>
                                    <dt>Subtopic:</dt>
                                    <dd>' . $item->subtopic . '</dd>
                                    <dt>Grade:</dt>
                                    <dd>' . $item->grade . '</dd>
                                    <dt>Environment:</dt>
                                    <dd>' . $item->environment . '</dd>
                                </dl>
                                ' . $description . '
                                </article>
					</li>';
    return $html;
}

function blob2img($blob)
{
    if (empty($blob) === true) {
        $blob = include dirname(__FILE__) . '/elephant-base64.php';
    }
    return 'data:image/png;base64, ' . $blob;
}

function add_ordinal_number_suffix($num)
{
    if (!in_array(($num % 100), array(11, 12, 13))) {
        switch ($num % 10) {
            // Handle 1st, 2nd, 3rd
            case 1:
                return $num . 'st';
            case 2:
                return $num . 'nd';
            case 3:
                return $num . 'rd';
        }
    }
    return $num . 'th';
}