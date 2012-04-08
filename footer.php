		<?php $wordstrap_options = get_option( 'theme_wordstrap_options' ); ?>
		<footer>

			<div class="container">
				<div class="row">
				<?php wordstrap_footer_widgets(1); ?>
				<?php wordstrap_footer_widgets(2); ?>
				<?php wordstrap_footer_widgets(3); ?>
				<?php wordstrap_footer_widgets(4); ?>
				</div>
			</div>

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
	</body>
</html>
