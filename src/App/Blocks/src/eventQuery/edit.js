/**
 * External dependencies
 */
import startCase from 'lodash.startcase';

/**
 * WordPress dependencies
 */
 import { 
	InnerBlocks, 
	InspectorControls, 
	useBlockProps,
	store as blockEditorStore
} from '@wordpress/block-editor';
 import { 
	CustomSelectControl,
	Panel, 
	PanelBody, 
	PanelRow,
	RangeControl,
	QueryControls,
	SelectControl,
	Spinner,
	ToggleControl
} from '@wordpress/components';
import { 
	useEffect,
	useState, 
	useMemo
} from '@wordpress/element';
import { 
	useDispatch,
	useSelect
} from '@wordpress/data';
import { 
	useInstanceId,
	withState
} from '@wordpress/compose';
import { 
	useEntityProp,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
	store as coreStore
} from '@wordpress/core-data';
import { 
	__experimentalGetSettings,
	 dateI18n 
} from '@wordpress/date';
import { __, sprintf } from '@wordpress/i18n';

import classNames from 'classnames';

const MAX_ITEMS = 24;

const Edit = ( props ) => {

	const { 
		attributes, 
		className, 
		setAttributes, 
		isSelected 
	} = props;

	const{ 
		queryId,
		taxonomy, 
		postType, 
		eventTags, 
		perPage,
		orderby,
		query,
		dateFormat,
		timeFormat,
		wrapperTagName,
		tagName,
		display,
		scope
	} = attributes;

	const {
		showTags,
		showFeaturedImage,
		showTitle,
		showDate,
		showTime,
		showEndTime,
		showLocation,
		linkWrap
	} = display;

	const instanceId = useInstanceId( Edit );

	const [ siteDateFormat ] = useEntityProp( 'root', 'site', 'date_format' );
	const [ siteTimeFormat ] = useEntityProp( 'root', 'site', 'time_format' );
	const settings = __experimentalGetSettings();
	const resolvedDateFormat = dateFormat || siteDateFormat || settings.formats.date;
	const resolvedTimeFormat = timeFormat || siteTimeFormat  || settings.formats.time;

	const dateOptions = () => {
		const date = new Date();
		let formats = [	
			'l F j, Y',
			'l, F j, Y',
			'D, M j, Y',
			'F j, Y',
			'M j, Y',
			'm/j/Y',
			'D, M j'
		];
		const options = formats
			.filter( format => format !== settings.formats.date )
			.concat( [ settings.formats.date ] )
			.map( ( format ) => ( {
				key: format,
				name: dateI18n( format, date ),
			} ) )

		return options
	}

	const timeOptions = () => {
		const date = new Date();
		let formats = [	
			'g:i a',
			'g:i A',
			'g:ia',
			'H:i',
		];
		const options = formats
			.filter( format => format !== settings.formats.time )
			.concat( [ settings.formats.time ] )
			.map( ( format ) => ( {
				key: format,
				name: dateI18n( format, date ),
			} ) )

		return options
	}

	const { __unstableMarkNextChangeAsNotPersistent } = useDispatch(
		blockEditorStore
	);

	const posts = useSelect(
		( select ) => {
			return select( 'core' ).getEntityRecords( 'postType', postType, query )
		},
		[ query ]
	);

	const setTerms = ( value ) => {
		setAttributes( {
			eventTags: value
		} );
	}

	const setPerPage = ( value ) => {
		setAttributes( {
			perPage: value
		} );
	}

	const setOrderBy = ( value ) => {
		setAttributes( {
			orderby: value
		} );
	}

	const setScope = ( value ) => {
		setAttributes( {
			scope: value
		} );
	}

	const TermSelector = () => {
		const terms = useSelect( ( select ) => {
			return select( 'core' ).getEntityRecords( 'taxonomy', taxonomy, { per_page: -1 } );
		}, [] );

		if( !terms || !terms.length ) {
			return <Spinner />;
		}

		const options = terms.map( ( { id, name } ) => ( { value: id, label: name } ) );

		return (
			<>
				<SelectControl
					label={ __( 'Tag', 'dc-events-manager' ) }
					options={ [ { value: "", label: __( 'Select a Tag', 'dc-events-manager' ) }, ...options ] }
					onChange={ setTerms }
					value={ eventTags }
				/>
			</>
		);
	};

	const PerPageSelector = () => {
		return (
			<RangeControl
				key="query-controls-range-control"
				label={ __( 'Number of Posts', 'dc-events-manager' ) }
				value={ perPage }
				onChange={ setPerPage }
				min={ 1 }
				max={ MAX_ITEMS }
			/>
		);
	};

	const OrderSelector = () => {

		const options = [
			{
				value: "start/desc",
				label: __( 'Soonest to Latest', 'dc-events-manager' )
			},
			{
				value: "start/asc",
				label: __( 'Latest to Soonest', 'dc-events-manager' )
			},
			{
				value: "title/asc",
				label: __( 'A → Z', 'dc-events-manager' )
			},
			{
				value: "title/desc",
				label: __( 'Z → A', 'dc-events-manager' )
			}
		];

		if( !options || !options.length ) {
			return <Spinner />;
		}

		return (
			<>
				<SelectControl
					label={ __( 'Order By', 'dc-events-manager' ) }
					options={ options }
					onChange={ setOrderBy }
					value={ orderby }
				/>
			</>
		);
	}; 

	const ScopeSelector = () => {
		const scopes = [	
			'future',
			'past',
			'all'
		];

		if( !scopes || !scopes.length ) {
			return <Spinner />;
		}

		const options = scopes.map( scope => ( { value: scope, label: startCase( scope ) } ) );

		return (
			<>
				<SelectControl
					label={ __( 'Scope', 'dc-events-manager' ) }
					options={ options }
					onChange={ setScope }
					value={ scope }
				/>
			</>
		);
	};

	const DateFormatSelector = () => {
		const options = dateOptions();
		
		return (
			<>
				<CustomSelectControl
					label={ __( 'Date Format', 'dc-events-manager' ) }
					options={ options }
					onChange={ ( { selectedItem } ) =>
						setAttributes( {
							dateFormat: selectedItem.key,
						} )
					}
					value={ options.find(
						( option ) => option.key === resolvedDateFormat
					) }
				/>
			</>
		);
	};

	const TimeFormatSelector = () => {
		const options = timeOptions();

		return (
			<>
				<CustomSelectControl
					label={ __( 'Time Format', 'dc-events-manager' ) }
					options={ options }
					onChange={ ( { selectedItem } ) =>
						setAttributes( {
							timeFormat: selectedItem.key,
						} )
					}
					value={ options.find(
						( option ) => option.key === resolvedTimeFormat
					) }
				/>
			</>
		);
	};

	const ShowSelectors = () => {
		const fields = Object.keys( display );	
		// console.log( display, fields );

		if( !fields || !fields.length ) {
			return null;
		}

		return (
			<>
				{ fields.map( ( field, index ) => {
					const label = startCase( field.replace( 'show', '' ) );
					let checked = attributes.display[field];

					return (
						<PanelRow key={index}>
							<ToggleControl
								label={ label }
								help={ checked ? __( 'Show', 'dc-events-manager' ) : __( 'Hide', 'dc-events-manager' ) }
								checked={ checked }
								onChange={ ( isChecked ) => {
									setAttributes( { 
										display: { 
										...display, 
										[field]: isChecked
									}  } )
								} }
							/>
						</PanelRow>
					)
				} ) }
			</>
		)
	}

	const SettingsPanel = () => {
		return (
			<InspectorControls>
				<PanelBody title={ __( 'Query Options', 'dc-events-manager' ) } initialOpen={ true }>
					<PanelRow>
						<TermSelector />
					</PanelRow>
					<PanelRow>
						<OrderSelector />
					</PanelRow>
					<PanelRow>
						<ScopeSelector />
					</PanelRow>
					<PanelRow>
						<PerPageSelector />
					</PanelRow>
				</PanelBody>
				<PanelBody title={ __( 'Display Options', 'dc-events-manager' ) } initialOpen={ true }>
					<PanelRow>
						<DateFormatSelector />
					</PanelRow>
					<PanelRow>
						<TimeFormatSelector />
					</PanelRow>
				</PanelBody>
				<PanelBody title={ __( 'Content Options', 'dc-events-manager' ) } initialOpen={ true }>
					<ShowSelectors />
				</PanelBody>
			</InspectorControls>
		)
	}

	const AdvancedControls = () => {
		return (
			<InspectorControls __experimentalGroup="advanced">
				<PanelBody title={ __( 'HTML Tag Options', 'dc-events-manager' ) } initialOpen={ true }>
					<PanelRow>
						<SelectControl
						label={ __( 'Wrapper HTML Element', 'dc-events-manager' ) }
						options={ [
							{ label: __( 'Default (<div>)', 'dc-events-manager' ), value: 'div' },
							{ label: '<main>', value: 'main' },
							{ label: '<section>', value: 'section' },
							{ label: '<ul> (list)', value: 'ul' },
						] }
						value={ wrapperTagName }
						onChange={ ( value ) =>
							setAttributes( { wrapperTagName: value } )
						}
					/>
					</PanelRow>
					<PanelRow>
						<SelectControl
							label={ __( 'Item HTML Element', 'dc-events-manager' ) }
							options={ [
								{ label: __( 'Default (<article>)', 'dc-events-manager' ), value: 'article' },
								{ label: '<div>', value: 'div' },
								{ label: '<li>', value: 'li' },
							] }
							value={ tagName }
							onChange={ ( value ) =>
								setAttributes( { tagName: value } )
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
		)
	}

	const blockProps = useBlockProps(
        {
            className: classNames( className, 'events__list' ),
        }
    );

	const Posts = () => {

		if( !posts ) {
			return <Spinner />
		}

		if( !posts.length ) {
			return (
				<NoPosts />
			)
		}

		return (
			<div { ...blockProps } >
				{ posts.map( post => {
					return (
						<Post { ...post } key={post.id} />
					);
				}) }
			</div>
		)
	}

	const Post = ( post ) => {

		const [ featuredImage, setFeaturedImage ] = useEntityProp(
			'postType',
			postType,
			'featured_media',
			post.id
		);

		const media = useSelect(
			( select ) => {
				if( !showFeaturedImage || !featuredImage ) {
					return false;
				}
				return select( 'core' ).getMedia( featuredImage, { context: 'view' } )
			},
			[ featuredImage ]
		);

		const tags = useSelect(
			( select ) => {
				return select( 'core' ).getEntityRecords( 'taxonomy', taxonomy, {
					include: post["event-tags"],
					context: 'view',
				} )
			},
			[]
		);

		const classes = () => {
			let postClassName = 'event';
			
			if( tags ) {
				let tagClasses = tags.map( tag => {
					return `${taxonomy}-${tag.slug}`;
				} );
				tagClasses = [ postClassName, ...tagClasses ];
				postClassName = tagClasses.join( ' ' );
			}

			return (
				postClassName
			)
		}

		const postClasses = classes();

		return (
			<article className={ postClasses }>
				<a link={ post.link } rel="bookmark">
				{ ( showTags && tags ) && (
					<div className="event__tag">
						<a href={ tags[0]?.link } rel="tag" dangerouslySetInnerHTML={{ __html: tags[0]?.name }}></a>
					</div>
				) }
				{ ( showFeaturedImage && media ) && (
					<picture className="event__media">
						<img
							src={ media.source_url }
							alt={ media.alt_text || __( 'Featured Image', 'dc-events-manager' ) }
						/>
					</picture>
				) }
				{ showTitle ? (
					<h3 className="event__title" dangerouslySetInnerHTML={{ __html: post?.title?.rendered }}></h3>
				) : (
					<h3 className="event__title sr-only screen-reader-text" dangerouslySetInnerHTML={{ __html: post?.title?.rendered }}></h3>
				) }
				{ showDate && (
					<div className="event__date">
						<time dateTime={ post.meta?.["_event_start"] }>{ dateI18n( dateFormat, post.meta?.["_event_start"] ) }</time>
					</div>
				) }
				{ showTime && (
					<div className="event__time">
						<time dateTime={ post.meta?.["_event_start"] }>{ dateI18n( timeFormat, post.meta?.["_event_start"] ) }</time>
						{ post.meta?.["_event_end"] && showEndTime && (
							<>
								<span className="separator"> - </span>
								<time dateTime={ post.meta?.["_event_end"] }>{ dateI18n( timeFormat, post.meta?.["_event_end"] ) }</time>
							</>
						) }
					</div>
					) }
				{ showLocation && (
					<div className="event__location" dangerouslySetInnerHTML={{ __html: post.meta?.["_event_location_type"] }}></div>
				) }
				</a>
			</article>
		)
	}

	const NoPosts = () => {
		return (
			<div className="no-posts">
				{ __( 'No events', 'dc-events-manager' ) }
			</div>
		)
	}

	const updateQuery = () => {
		let _query = query;

		const _ordering = orderby.split( '/' );
		_query = { 
			..._query, 
			per_page: parseInt( perPage ),
			order: _ordering[1],
			orderby: _ordering[0],
			scope: scope,
			"event-tags": eventTags ? [ parseInt( eventTags ) ] : [],
		}

		setAttributes( { 
			query: { 
				...query, 
				..._query 
			} 
		} );
	}

	useEffect( () => {
        updateQuery();
    }, [ eventTags, perPage, orderby, scope ] );

	useEffect( () => {
		if ( ! queryId ) {
			__unstableMarkNextChangeAsNotPersistent();
			setAttributes( { 
				queryId: instanceId 
			} );
		}
		if ( ! dateFormat ) {
			__unstableMarkNextChangeAsNotPersistent();
			setAttributes( { 
				dateFormat: resolvedDateFormat
			} );
		}
		if ( ! timeFormat ) {
			__unstableMarkNextChangeAsNotPersistent();
			setAttributes( { 
				timeFormat: resolvedTimeFormat
			} );
		}

	}, [ queryId, instanceId, dateFormat, siteTimeFormat ] );

	return (
		<>
			<SettingsPanel />
			<AdvancedControls />

			<Posts />
		</>
	);
};

export default Edit;
