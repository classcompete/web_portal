<?php
/*
Template Name: Page: Sidebar Right
*/
define('THEME_TEMPLATE', TRUE);
define('SIDEBAR_POS', 'right');
get_header();
global $smof_data, $us_shortcodes;

// Disabling Section shortcode
global $disable_section_shortcode;
$disable_section_shortcode = TRUE;
?>
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
	<?php get_template_part( 'templates/pagehead' ); ?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<div class="l-content-h i-widgets">

					<?php the_content(__('Read More &raquo;', 'us')); ?>
                    <?php if (@$smof_data['page_comments'] == 1 AND comments_open()) { comments_template(); } ?>
				</div>
			</div>
			<div class="l-sidebar at_left">
				<div class="l-sidebar-h i-widgets">

				</div>
			</div>

			<div class="l-sidebar at_right">
				<div class="l-sidebar-h i-widgets">
					<?php generated_dynamic_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endwhile; else : ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php endif; ?>
<?php get_footer(); ?>