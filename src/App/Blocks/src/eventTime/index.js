/**
 * WordPress dependencies
 */
// import { postDate as icon } from '@wordpress/icons';
import icon from './icon';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
// import './style.scss';
// import './editor.scss';

import metadata from './block.json';
import Edit from './edit';

const { name, category } = metadata;

const settings = {
	icon,
	edit: Edit,
};

export { name, category, settings };
