/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import Edit from './edit';
import Save from './save';

//  Import CSS.
import './editor.scss';
// import './style.scss';

const { name, category } = metadata;

const settings = {
	edit: Edit,
	save: Save,
};

export { name, category, settings };
