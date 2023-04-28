import {
	InnerBlocks,
	InspectorControls,
	InspectorAdvancedControls,
	useBlockProps,
} from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';
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

	const{ 
		tagName,
	} = attributes;

	const setTagName = ( value ) => {
		setAttributes( {
			tagName: value
		} );
	}

	const TagNameSelector = () => {

		const htmlElementMessages = {
			section: __(
				"The <section> element should represent a standalone portion of the document that can't be better represented by another element."
			),
			div: __(
				"The <div> element is the generic container for flow content."
			),
		};

		const options = [
			{ label: 'Default (<section>)', value: 'section' },
			{ label: __( '<div>' ), value: 'div' },
		];

		if( !options || !options.length ) {
			return <Spinner />;
		}

		return (
			<InspectorAdvancedControls group="advanced">
				<SelectControl
					__nextHasNoMarginBottom
					label={ __( 'HTML element' ) }
					options={ options }
					onChange={ setTagName }
					value={ tagName }
					help={ htmlElementMessages[ tagName ] }
				/>
			</InspectorAdvancedControls>
		);
	};

	const blockProps = useBlockProps( {
		className: classNames( className, 'events' ),
	} );

	return (
		<div
			{ ...blockProps } >
			<TagNameSelector />
			<InnerBlocks
				allowedBlocks={ ALLOWED_BLOCKS }
				template={ TEMPLATE }
				templateLock="all"
			/>
		</div>
	);
};

export default Edit;