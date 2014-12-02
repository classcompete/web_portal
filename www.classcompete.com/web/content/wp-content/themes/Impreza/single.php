<?php
define('THEME_TEMPLATE', TRUE);
global $smof_data, $us_shortcodes, $post;
define('IS_POST', TRUE);
if ($smof_data['post_sidebar_pos'] == 'No Sidebar') {
	define('IS_FULLWIDTH', TRUE);
}
get_header();


// Disabling Section shortcode
global $disable_section_shortcode;
$disable_section_shortcode = TRUE;

wp_enqueue_script('comment-reply');
?>
<?php if (have_posts()) : while(have_posts()) : the_post();

	$post_format = get_post_format()?get_post_format():'standard';
	$post_content = get_the_content();

	$preview = '';
	if ($post_format == 'image')
	{
		$preview = us_post_format_image_preview('blog-big', $post_content);
	}
	elseif ($post_format == 'video')
	{
		$preview = us_post_format_video_preview($post_content);
	}
	elseif ($post_format == 'gallery')
	{
		$preview = us_post_format_gallery_preview(false, '', $post_content);
	}
	?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<div class="l-content-h i-widgets">

					<div <?php post_class("w-blogpost meta_all"); ?>>
						<div class="w-blogpost-h">

							<div class="w-blogpost-content">
								<?php echo $preview; ?>

								<?php
								if ($post_format == 'quote')
								{
									?><div class="w-blogpost-title">
										<blockquote><?php the_title(); ?></blockquote>
									</div><?php
								}
								else
								{
									?><h1 class="w-blogpost-title"><?php the_title(); ?></h1><?php
								}
								?>

								<div class="w-blogpost-meta">

									<div class="w-blogpost-meta-date">
										<i class="fa fa-clock-o"></i>
										<span class="w-blogpost-meta-date-month"><?php echo get_the_date('F') ?></span>
										<span class="w-blogpost-meta-date-day"><?php echo get_the_date('d') ?>, </span>
										<span class="w-blogpost-meta-date-year"><?php echo get_the_date('Y') ?></span>
									</div>
									<?php if ( ! isset($smof_data['post_meta_author']) OR $smof_data['post_meta_author'] == 1) { ?>
									<div class="w-blogpost-meta-author">
										<i class="fa fa-user"></i>
										<?php if (get_the_author_meta('url')) { ?>
											<a class="w-blogpost-meta-author-h" href="<?php echo esc_url( get_the_author_meta('url') ); ?>"><?php echo get_the_author() ?></a>
										<?php } else { ?>
											<span class="w-blogpost-meta-author-h"><?php echo get_the_author() ?></span>
										<?php } ?>
									</div>
									<?php } ?>
                                    <?php if ( ! isset($smof_data['post_meta_categories']) OR $smof_data['post_meta_categories'] == 1) { ?>
                                        <div class="w-blogpost-meta-tags">
                                            <i class="fa fa-folder-open"></i>
                                            <?php the_category(', '); ?>
                                        </div>
                                    <?php } ?>
									<?php if ( ! isset($smof_data['post_meta_comments']) OR $smof_data['post_meta_comments'] == 1) { ?>
									<div class="w-blogpost-meta-comments">
										<?php comments_popup_link('<i class="fa fa-comments"></i>'.__('No Comments', 'us'), '<i class="fa fa-comments"></i>'.__('1 Comment', 'us'), '<i class="fa fa-comments"></i>'.__('% Comments', 'us'), 'w-blogpost-meta-comments-h', ''); ?>
									</div>
									<?php } ?>
								</div>
								<div class="w-blogpost-text">
									<?php
									$content = apply_filters('the_content', $post_content);
									$content = str_replace(']]>', ']]&gt;', $content);
									echo $content;
									?>

								</div>
							</div>
							<?php
							$tags = wp_get_post_tags($post->ID);
							if ($tags) {
							?>
							<?php if ( ! isset($smof_data['post_meta_tags']) OR $smof_data['post_meta_tags'] == 1) { ?>
							<div class="w-tags layout_block title_atleft">
								<div class="w-tags-h">
									<div class="w-tags-title">
										<h4 class="w-tags-title-h"><?php echo __('Tags', 'us') ?>:</h4>
									</div>
									<div class="w-tags-list">
									<?php foreach ($tags as $tag) { ?>
										<div class="w-tags-item">
											<a class="w-tags-item-link" href="<?php echo get_tag_link($tag->term_id) ?>"><?php echo $tag->name ?></a><span class="w-tags-item-separator">,</span>
										</div>
									<?php } ?>
									</div>

								</div>
							</div>
							<?php } ?>
							<?php } ?>


						</div>
					</div>
					<?php if ($smof_data['post_related_posts'] == 1) { ?>
						<?php
						if ($tags) {
							$tag_ids = array();
							foreach ($tags as $tag )
							{
								$tag_ids[] = (int)$tag->term_id;
							}

							$args=array(
								'tag__in' => $tag_ids,
								'post__not_in' => array($post->ID),
								'paged' => 1,
								'showposts' => 3,
								'orderby'=>'rand',
								'ignore_sticky_posts'=>1,
								'post_type' => get_post_type($post->ID),
							);
							$related_query = new WP_Query($args);
							if( $related_query->have_posts() ) {
								?>
								<div class="w-bloglist">
									<h4 class="w-bloglist-title"><?php echo __('Related Posts', 'us') ?></h4>
									<div class="w-bloglist-list">
										<?php while ($related_query->have_posts()) { $related_query->the_post(); ?>
											<div class="w-bloglist-entry">
												<a class="w-bloglist-entry-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
												<span class="w-bloglist-entry-date"><?php the_date('F d, Y'); ?></span>
											</div>
										<?php
										}
										wp_reset_query();
										?>

									</div>
								</div>
							<?php
							}
						}
					} ?>
					<?php if (comments_open()) { comments_template(); } ?>
				</div>
			</div>
			<div class="l-sidebar at_left">
				<div class="l-sidebar-h i-widgets">
					<?php if ($smof_data['post_sidebar_pos'] != 'Right') generated_dynamic_sidebar(); ?>
				</div>
			</div>

			<div class="l-sidebar at_right">
				<div class="l-sidebar-h i-widgets">
					<?php if ($smof_data['post_sidebar_pos'] == 'Right') generated_dynamic_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endwhile; else : ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php endif; ?>
<?php get_footer(); ?>