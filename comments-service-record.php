<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tcb24
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area white padded">
	<?php
	if ( have_comments() ) {
		?>
		<h3 class="comments-title">
			<?php
			$arch_comment_count = get_comments_number();
			echo esc_html(
				sprintf(
					// Translators: 1. number of comments, 2. post title.
					_nx(
						'%1$s comment on &ldquo;%2$s&rdquo;',
						'%1$s comments on &ldquo;%2$s&rdquo;',
						$arch_comment_count,
						'Comments Title',
						'tcb24'
					),
					number_format_i18n( $arch_comment_count ),
					get_the_title()
				)
			);
			?>
		</h3>
		<?php the_comments_navigation(); ?>
		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 64,
					'callback'    => 'tcb24_comment',
				)
			);
			?>
		</ol><!-- .comment-list -->
		<?php
		the_comments_navigation();
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) {
			?>
			<p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'tcb24' ); ?></p>
			<?php
		}
	} // Check for have_comments().
	$args = array(
		'title_reply' => __( 'Disciplinary record', 'textdomain' ),
	);
	comment_form( $args );
	?>
</div><!-- #comments -->
