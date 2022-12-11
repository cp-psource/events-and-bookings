/**
 * WordPress dependencies
 */
const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

/**
 * Register block
 */
registerBlockType( 'psource-block/editor-box',
	{
		title: __( 'PSOURCE Shortcodes', 'ps-block' ),

		category: 'widgets',

		edit() {
			return (
				<div>Das wird im Editor angezeigt</div>
			);
		},

		save() {
			return (
				<div>Das wird im Frontend angezeigt</div>
			);
		},
	}
);