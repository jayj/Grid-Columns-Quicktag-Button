<?php
/**
 * Plugin Name: Grid Columns Media Button
 * Description: Adds a media button for the <a href="http://wordpress.org/extend/plugins/grid-columns/">Grid Columns shortcode plugin</a> to easily add the [column] shortcode to the post editor.
 * Author:      Jesper Johansen
 * Author URI:  http://jayj.dk
 * Version:     1.0.0
 * License:     GPLv2 or later
 */

/* Adds a custom media button on the post editor. */
add_action( 'media_buttons', 'grid_column_media_button', 11 );

/* Loads media button popup content in the footer. */
add_action( 'admin_print_footer_scripts', 'grid_column_media_popup_content', 100 );

/* Load the textdomain for translation. */
load_plugin_textdomain( 'grid-column-media', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

/**
 * Adds a button to the Thickbox popup containing the shortcode config popup on the edit post screen.
 *
 * @since  1.0.0
 * @param  string  $editor_id
 * @return void
 */
function grid_column_media_button( $editor_id ) {

	printf( '<a href="%s" class="%s" data-editor="%s" title="%s">%s</a>',
		'#TB_inline?width=640&height=550&inlineId=grid-column-media-insert-popup',
		'thickbox button',
		esc_attr( $editor_id ),
		esc_attr__( 'Insert Grid Column', 'grid-column-media' ),
		__( 'Insert Column', 'grid-column-media' )
	);
}

/**
 * Content for the modal window when the "Insert Column" button is clicked.
 *
 * @since 0.1.0
 */
function grid_column_media_popup_content() {

	// Check if the wp_editor() function has been called. If it hasn't, don't include the javascript
	if ( ! did_action( 'before_wp_tiny_mce' ) )
		return;
?>

	<!-- Grid Columns -->
	<script type="text/javascript">
		function grid_column_media_insert_column() {
			// Get the entered values
			var grid = jQuery('#grid-column-media-insert-grid').val(),
				span = jQuery('#grid-column-media-insert-span').val(),
				push = jQuery('#grid-column-media-insert-push').val(),
				css  = jQuery('#grid-column-media-insert-class').val(),
				shortcode;

			// Generate the shortcode
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

	<div id="grid-column-media-insert-popup" style="display: none;">

		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label for="grid-column-media-insert-grid"><?php _e( 'Grid', 'grid-column-media' ); ?></label>
					</th>
					<td>
						<input type="number" class="small-text" id="grid-column-media-insert-grid" value="4" min="1" />
						<p class="description"><?php _e( 'Number of sections in the grid.', 'grid-column-media' ); ?></p>
					</td>
				</tr>
				<tr>
					<th>
						<label for="grid-column-media-insert-span"><?php _e( 'Span', 'grid-column-media' ); ?></label>
					</th>
					<td>
						<input type="number" class="small-text" id="grid-column-media-insert-span" value="1" min="0" />
						<p class="description"><?php _e( 'Number of sections the current column should span.', 'grid-column-media' ); ?></p>
					</td>
				</tr>
				<tr>
					<th>
						<label for="grid-column-media-insert-push"><?php _e( 'Push', 'grid-column-media' ); ?></label>
					</th>
					<td>
						<input type="number" class="small-text" id="grid-column-media-insert-push" value="" min="0" />
						<p class="description"><?php _e( 'Optional: Number of sections the current column should be "pushed".', 'grid-column-media' ); ?></p>
					</td>
				</tr>
				<tr>
					<th>
						<label for="grid-column-media-insert-class"><?php _ex( 'Class', 'css class', 'grid-column-media' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" id="grid-column-media-insert-class" value="" />
						<p class="description"><?php _e( 'Optional: Input a custom CSS class.', 'grid-column-media' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="button" class="button-primary" value="<?php esc_attr_e( 'Insert Column', 'grid-column-media' ); ?>" onclick="grid_column_media_insert_column();" />

			<button class="button-secondary" onclick="tb_remove();" title="<?php esc_attr_e( 'Cancel', 'grid-column-media' ); ?>"><?php _e( 'Cancel', 'grid-column-media' ); ?></button>
		</p>

	</div>
	<!-- // Grid Columns --> <?php
}

?>
