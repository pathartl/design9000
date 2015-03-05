<?php
/**
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" class="field" name="s" id="s"  placeholder="<?php _e('Search', 'blankfolio') ?>" />
	</form>