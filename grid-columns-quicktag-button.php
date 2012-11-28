<?php
/**
 * Plugin Name: Grid Columns Quicktag Button
 * Description:	Adds a button, with settings, for the <a href="http://wordpress.org/extend/plugins/grid-columns/">Grid Columns shortcode plugin</a> to the WordPress editor.
 * Author:      Jesper Johansen
 * Author URI:  http://jayj.dk
 * Version:     0.1.0
 * License: 	GPLv2 or later
 */

/**
 * Add the Grid Column button to editor
 *
 * @since 0.0.1
 */
function jayj_grid_column_quicktag_button() {

	// Check if the wp_editor() function has been called. If it hasn't, don't include the Quicktags javascript
	if ( ! did_action( 'before_wp_tiny_mce' ) )
		return;
?>

	<!-- Grid Columns Quicktag button -->
	<script type="text/javascript">
		if (typeof(QTags) != 'undefined') {

			// Add the [column] Quicktag button
			QTags.GridColumns = function() {
				QTags.TagButton.call(this, 'Column', 'Grid Columns', '', '', 'm' );
			};

			QTags.GridColumns.prototype = new QTags.TagButton();
			QTags.GridColumns.prototype.callback = function(e, c, ed) {

				// The different parameters and their default value
				var grid = prompt( 'Required: Number of sections in the grid', 4 ),
					span = prompt( 'Required: Number of sections the current column should span', 0 ),
					push = prompt( 'Optional: Number of sections the current column should be "pushed". Basically, you are creating an empty space.', '' ),
					custom = prompt( 'Optional: This is for inputting a custom CSS class', '' );

				// Check for the required inputs
				if ( grid && span ) {

						// Start the shortcode
						this.tagStart = '[column grid="' + grid  + '" span="' + span + '"';

						// Add push
						if ( push )
							this.tagStart = this.tagStart + ' push="' + push + '"';

						// Add custom class
						if ( custom )
							this.tagStart = this.tagStart + ' class="' + custom + '"';

						// End shortcode
						this.tagStart = this.tagStart + '][/column]';

						QTags.TagButton.prototype.callback.call(this, e, c, ed);
				}
			};

			// Add the button
			edButtons[150] = new QTags.GridColumns();
		}
	</script>
	<!-- // Grid Columns Quicktag button --> <?php
}

add_action( 'admin_print_footer_scripts', 'jayj_grid_column_quicktag_button', 101 );

?>
