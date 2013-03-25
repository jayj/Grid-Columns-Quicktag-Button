<?php
/**
 * Plugin Name: Grid Columns Media Button
 * Description: Adds a media button for the <a href="http://wordpress.org/extend/plugins/grid-columns/">Grid Columns shortcode plugin</a> to easily add the [column] shortcode in the editor.
 * Author:      Jesper Johansen
 * Author URI:  http://jayj.dk
 * Version:     0.2.0
 * License:     GPLv2 or later
 */

/* Load the textdomain for translation */
load_plugin_textdomain( 'jayj-grid-column', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

/**
 * Add the Grid Column button to media buttons
 *
 * @since  0.2.0
 * @return $string
 */
function jayj_grid_column_insert_button( $context ) {

	$output = sprintf( '<a href="%s" class="%s" title="%s">%s</a>',
		'#TB_inline?width=640&inlineId=insert-grid-column',
		'thickbox button',
		esc_attr__( 'Insert Grid Column', 'jayj-grid-column' ),
		__( 'Insert Column', 'jayj-grid-column' )
	);

	return $context . $output;
}

add_filter( 'media_buttons_context', 'jayj_grid_column_insert_button' );

/**
 * Add the modal window and javascript needed
 *
 * @since 0.1.0
 */
function jayj_grid_column_quicktag_button() {

	// Check if the wp_editor() function has been called. If it hasn't, don't include the javascript
	if ( ! did_action( 'before_wp_tiny_mce' ) )
		return;
?>

	<!-- Grid Columns -->
	<script type="text/javascript">
		function insertColumn() {
			// Get the entered values
			var grid = jQuery('#jayj-grid-column-insert-grid').val(),
				span = jQuery('#jayj-grid-column-insert-span').val(),
				push = jQuery('#jayj-grid-column-insert-push').val(),
				css  = jQuery('#jayj-grid-column-insert-class').val(),
				shortcode;

			shortcode = '[column';

			if ( grid )
				shortcode = shortcode + ' grid="' + grid + '"';

			if ( span )
				shortcode = shortcode + ' span="' + span + '"';

			if ( push )
				shortcode = shortcode + ' push="' + push + '"';

			if ( css )
				shortcode = shortcode + ' class="' + css + '"';

			shortcode = shortcode + '][/column]';

			// Send the shortcode to the editor
			window.send_to_editor( shortcode );
		}
	</script>

	<div id="insert-grid-column" style="display: none;">

		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label for="jayj-grid-column-insert-grid"><?php _e( 'Grid', 'jayj-grid-column' ); ?></label>
					</th>
					<td>
						<input type="number" class="small-text" id="jayj-grid-column-insert-grid" value="4" min="1" />
						<p class="description"><?php _e( 'Number of sections in the grid.', 'jayj-grid-column' ); ?></p>
					</td>
				</tr>
				<tr>
					<th>
						<label for="jayj-grid-column-insert-span"><?php _e( 'Span', 'jayj-grid-column' ); ?></label>
					</th>
					<td>
						<input type="number" class="small-text" id="jayj-grid-column-insert-span" value="1" min="0" />
						<p class="description"><?php _e( 'Number of sections the current column should span.', 'jayj-grid-column' ); ?></p>
					</td>
				</tr>
				<tr>
					<th>
						<label for="jayj-grid-column-insert-push"><?php _e( 'Push', 'jayj-grid-column' ); ?></label>
					</th>
					<td>
						<input type="number" class="small-text" id="jayj-grid-column-insert-push" value="" min="0" />
						<p class="description"><?php _e( 'Optional: Number of sections the current column should be "pushed".', 'jayj-grid-column' ); ?></p>
					</td>
				</tr>
				<tr>
					<th>
						<label for="jayj-grid-column-insert-class"><?php _ex( 'Class', 'css class', 'jayj-grid-column' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" id="jayj-grid-column-insert-class" value="" />
						<p class="description"><?php _e( 'Optional: Input a custom CSS class.', 'jayj-grid-column' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="button" class="button-primary" value="<?php esc_attr_e( 'Insert Column', 'jayj-grid-column' ); ?>" onclick="insertColumn();" />

			<button class="button-secondary" onclick="tb_remove();" title="<?php esc_attr_e( 'Cancel', 'jayj-grid-column' ); ?>"><?php _e( 'Cancel', 'jayj-grid-column' ); ?></button>
		</p>
	</div>
	<!-- // Grid Columns --> <?php
}

add_action( 'admin_print_footer_scripts', 'jayj_grid_column_quicktag_button', 100 );

?>
