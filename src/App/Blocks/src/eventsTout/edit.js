import {
	InnerBlocks,
	useBlockProps,
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import classNames from 'classnames';

const TEMPLATE = [
	[
		'core/heading',
		{
			placeholder: __( 'Add Heading...', 'dc-events-manager' ),
			level: 3,
			className: 'events-tout__title',
		},
		[],
	],
	[
		'dc-events-manager/event-query',
		{
			className: 'events-tout__list'
		},
		[],
	],
	[
		'core/button',
		{
			className: 'events-tout__button btn jade',
			content: __( 'See More Events', 'dc-events-manager' ) 
		},
		[],
	],
];

const ALLOWED_BLOCKS = [ 
	'core/heading', 
	'dc-events-manager/event-query', 
	'core/button'
];

const Edit = ( props ) => {
	const {
		attributes,
		className,
		setAttributes,
	} = props;

	const blockProps = useBlockProps( {
		className: classNames( className, 'events-tout' ),
	} );

	return (
		<div
			{ ...blockProps } >
			<InnerBlocks
				allowedBlocks={ ALLOWED_BLOCKS }
				template={ TEMPLATE }
				templateLock="all"
			/>
		</div>
	);
};

export default Edit;