<?php
/**
 * Custom search form.
 *
 * @package tcb24
 */

?>

<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="wrapper">
		<label class="screen-reader-text" for="s">Search for:</label>
		<div id="search">
			<input type="text" value="" name="s" id="s" placeholder="Search" />
		</div>
		<input type="submit" id="searchsubmit" value="GO" class="btn btn-primary"/>
	</div>
	<div class="search_result shadow" id="datafetch"></div>
</form>