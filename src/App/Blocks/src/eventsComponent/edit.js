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
			level: 2,
			className: 'events__title',
		},
		[],
	],
	[
		'core/paragraph',
		{
			placeholder: __( 'Add Content...', 'dc-events-manager' ),
			className: 'events__content',
		},
		[],
	],
	[
		'dc-events-manager/event-query',
		{
			className: 'events__list',
		},
		[],
	],
];

const ALLOWED_BLOCKS = [ 'core/heading', 'core/paragraph', 'dc-events-manager/event-query' ];

const Edit = ( props ) => {
	const {
		attributes,
		className,
		setAttributes,
	} = props;

	const blockProps = useBlockProps( {
		className: classNames( className, 'events' ),
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