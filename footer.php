</div> <!-- end content wrap -->
		<footer id="footer" class="clear">
			<div class="container">
				<div class="twelve columns">
					<h3>Contact Us</h3>
					<p><a href="<?php the_field( 'teamspeak', 'options' ); ?>">Join Teamspeak Server</a><br>
					<a href="<?php the_field( 'discord', 'options' ); ?>">Join Discord Server</a></p>
					<?php get_template_part( 'includes/social' ); ?>
					<p class="has-small-font-size">&copy; <?php the_field( 'footer_message', 'options' ); ?></p>
				</div>
				<div class="btt">
					<a href="#wrap"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve"><path fill="#666" d="M2.582,13.891c-0.272,0.268-0.709,0.268-0.979,0s-0.271-0.701,0-0.969l7.908-7.83c0.27-0.268,0.707-0.268,0.979,0 l7.908,7.83c0.27,0.268,0.27,0.701,0,0.969c-0.271,0.268-0.709,0.268-0.978,0L10,6.75L2.582,13.891z"/></svg>Back to top</a>
				</div>
			</div>
		</footer>
		
	</div>
	
	<?php wp_footer(); ?>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			
			jQuery(document).mouseup(function(e){
				var container = jQuery(".blogBanner #datafetch.show");
				// If the target of the click isn't the container
				if(!container.is(e.target) && container.has(e.target).length === 0){
					jQuery(".blogBanner #datafetch").removeClass( 'show' );
				}
			});
			
			jQuery('.blogBanner #searchsubmit').click(function() {
				event.preventDefault();
				jQuery("#datafetch").addClass( 'show' );
				jQuery('#datafetch').html( '<ul><li>Please wait..</li></ul>' );
				if ( jQuery('#s').val().length >= 3) {
					jQuery.ajax({
						type: 'post',
						url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
						data: {
							action: 'data_fetch',
							keyword: jQuery('#s').val(),
						},
						success: function(data) {
							jQuery('#datafetch').html( data );
						}
					});
				} else {
					jQuery('#datafetch').html( '<ul><li>Please enter 3 or more letters</li></ul>' );
				}
			});
			
		});
	</script>
	
	<script type="module">
		import PhotoSwipeLightbox from '/wp-content/themes/3cb24/js/photoswipe-lightbox.esm.min.js';
		const lightbox = new PhotoSwipeLightbox({
			gallery: '.mygallery',
			children: 'a',
			pswpModule: () => import('/wp-content/themes/3cb24/js/photoswipe.esm.min.js')
		});
		lightbox.init();
	</script>
	
</body>
</html>