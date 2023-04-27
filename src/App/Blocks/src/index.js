import { 
    registerBlockType,
    registerBlockCollection
} from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

/**
 * Register Custom Block Collection
 */
registerBlockCollection( 'dc-events-manager', { 
    title: __( 'Action Network Events', 'dc-events-manager' ),
	icon: 'calendar-alt'
} );

console.log( 'LOADED' );

/**
 * Register Variations
 */
import './variations';

import * as query from './eventQuery';
import * as eventsTout from './eventsTout';

// import * as date from './eventDate';
// import * as eventsComponent from './eventsComponent';
// import * as location from './eventLocation';
// import * as time from './eventTime';

const blocks = [
	eventsTout,
	query
];

/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
 const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}

	const { name, settings } = block;

	registerBlockType( name, {
		...settings,
	} );
};

/**
 * Function to register blocks
 */
 export const registerBlocks = () => {
	blocks.forEach( registerBlock );
};

registerBlocks();