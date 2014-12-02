<?php global $smof_data; ?>
<?php
if ( ! defined('THEME_TEMPLATE') AND FALSE) { ?>
    </div>
    </div>
<?php } ?>
</div>
<!-- /MAIN -->

</div>
<!-- /CANVAS -->

<!-- FOOTER -->
<div class="l-footer type_normal">
	<?php if (($smof_data['footer_show_widgets'] != 0 AND rwmb_meta('us_show_subfooter_widgets') == '') OR rwmb_meta('us_show_subfooter_widgets') == 'yes') { ?>
	<!-- subfooter: top -->
	<div class="l-subfooter at_top">
		<div class="l-subfooter-h g-cols">

			<div class="one-third">
				<?php dynamic_sidebar('footer_first') ?>
			</div>

			<div class="one-third">
				<?php dynamic_sidebar('footer_second') ?>
			</div>

			<div class="one-third">
				<?php dynamic_sidebar('footer_third') ?>
			</div>

		</div>
	</div>
	<?php } ?>
	<?php if (($smof_data['footer_show_footer'] != 0 AND rwmb_meta('us_show_footer') == '') OR rwmb_meta('us_show_footer') == 'yes') { ?>
	<!-- subfooter: bottom -->
	<div class="l-subfooter at_bottom">
		<div class="l-subfooter-h i-cf">

			<div class="w-copyright"><?php echo $smof_data['footer_copyright'] ?></div>

			<!-- NAV -->
			<nav class="w-nav layout_hor">
				<ul class="w-nav-list level_1">
					<?php wp_nav_menu(
						array(
							'theme_location' => 'impeza_footer_menu',
							'container'       => 'ul',
							'container_class' => 'w-nav-list',
							'walker' => new Walker_Nav_Menu_us(),
							'items_wrap' => '%3$s',
							'fallback_cb' => false,

						));
					?>
				</ul>
			</nav><!-- /NAV -->

		</div>
	</div>
	<?php } ?>

</div>
<!-- /FOOTER -->
<a class="w-toplink" href="#"><i class="fa fa-angle-up"></i></a>
<script type="text/javascript">
<?php if ( ! empty($smof_data['mobile_nav_width']) AND $smof_data['mobile_nav_width'] < "1024") {?>window.mobileNavWidth = "<?php echo $smof_data['mobile_nav_width']; ?>";<?php } ?>
<?php if ( ! empty($smof_data['logo_height']) AND $smof_data['logo_height'] != "30") {?>window.logoHeight = "<?php echo $smof_data['logo_height']; ?>";<?php } ?>
<?php if ( ! empty($smof_data['logo_height_sticky']) AND $smof_data['logo_height_sticky'] != "30") {?>window.logoHeightSticky = "<?php echo $smof_data['logo_height_sticky']; ?>";<?php } ?>
<?php if ( ! empty($smof_data['mobile_nav_width']) AND $smof_data['mobile_nav_width'] != "1000") {?>window.mobileNavWidth = "<?php echo $smof_data['mobile_nav_width']; ?>";<?php } ?>
</script>
<?php if($smof_data['tracking_code'] != "") { echo $smof_data['tracking_code']; } ?>
<?php wp_footer(); ?>
</body>
</html>