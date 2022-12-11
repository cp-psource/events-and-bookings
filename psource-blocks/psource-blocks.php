<?php
/**
 *
 * Plugin Name: PSOURCE BLOCKS
 * Description: PSOURCE Blöcke für WordPress 5.0+.
 * Version:     0.1
 * Author:      DerN3rd
 * Author URI:  https://n3rds.work
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: ps-block
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register block script and backend stylesheet
 */
	wp_register_script(
		'ps-gutenberg-blocks-editor-script',
		plugins_url( 'assets/js/editor.blocks.js', __FILE__ ),
		[ 'wp-blocks', 'wp-element', 'wp-edit-post', 'lodash' ]
	);
	wp_register_style(
		'ps-gutenberg-blocks-editor-style',
		plugins_url( 'assets/css/editor.blocks.css', __FILE__ )
	);

/**
 * Register block styles for frontend
 */
	wp_register_style(
		'ps-gutenberg-blocks-frontend-style',
		plugins_url( 'assets/css/frontend.blocks.css', __FILE__ )
	);

/**
 * Enqeue scripts and styles for info-box block
 */
register_block_type(
	'psource-block/editor-box', array(
		'style'         => 'ps-gutenberg-blocks-frontend-style',
		'editor_script' => 'ps-gutenberg-blocks-editor-script',
		'editor_style'  => 'ps-gutenberg-blocks-editor-style',
	)
);