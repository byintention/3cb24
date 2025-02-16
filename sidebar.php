<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Side bar for tcb24
 *
 * @package tcb24
 */
?>

<div class="four columns">
	<ul id="sidebar">
	<?php if ( ! dynamic_sidebar( 'blog-sidebar' ) ) : ?>
		<li id="about">
			Please install some widgets
		</li>
	<?php endif; ?>
	</ul>
</div>
