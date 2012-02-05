		<?php $wordstrap_options = get_option( 'theme_wordstrap_options' ); ?>
		<footer>
			<div class="container">
				<div class="row">
					<div class="span12">
						<?php 
						echo $wordstrap_options['footer_text'];
						?>
					</div>
				</div>
			</div>
		</footer>

		<?php wp_footer(); ?>
		<?php if ($wordstrap_options['js']['transition']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-transition.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['alert']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-alert.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['modal']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-modal.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['dropdown']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-dropdown.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['scrollspy']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-scrollspy.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['tab']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-tab.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['tooltip']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-tooltip.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['popover']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-popover.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['button']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-button.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['collapse']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-collapse.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['carousel']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-carousel.js"></script>
		<?php endif; ?>
		<?php if ($wordstrap_options['js']['typeahead']) : ?>
		    <script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap-typeahead.js"></script>
		<?php endif; ?>
	</body>
</html>
