/**
 * WordPress dependencies
 */
import icon from './icon';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import Edit from './edit';

//  Import CSS.
import './editor.scss';
// import './style.scss';

const { name, category } = metadata;

const settings = {
	icon,
	edit: Edit,
};

export { name, category, settings };