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
 import icon from './icon';

 //  Import CSS.
// import './editor.scss';
// import './style.scss';
 
 const { name, category } = metadata;
 
 const variations = [
	 {
		 name: 'events-by-tag',
		 title: __( 'Events by Tag', 'dc-events-manager' ),
		 icon: 'calendar-alt',
		 isDefault: true,
		 category: 'events',
		 description: __( 'Display events with section header and description..', 'dc-events-manager' ),
		 keywords: [
			 __( 'event', 'dc-events-manager' ),
			 __( 'grid', 'dc-events-manager' ),
			 __( 'component', 'dc-events-manager' )
		 ],
		 attributes: {
			 className: 'events-by-tag'
		 },
		 innerBlocks: [
			 [
				 'core/heading',
				 {
					 className: 'taxonomy-label',
					 level: 2,
					 placeholder: __( 'Add Title...', 'dc-events-manager' ),
				 },
			 ],
			 [
				 'core/paragraph',
				 {
					 className: 'taxonomy-description',
					 placeholder: __( 'Add Description...', 'dc-events-manager' ),
				 },
			 ],
			 [
				 'dc-events-manager/event-query',
				 {
					className: 'events-by-tag',
					query: {
						 per_page: 3,
						 order: 'desc',
						 orderby: 'start'
					 },
					 dateFormat: 'D, M j, Y',
					 wrapperTagName: 'section',
					 display: {
						 showTags: false,
						 showFeaturedImage: false,
						 showTitle: true,
						 showDate: true,
						 showTime: true,
						 showEndTime: true,
						 showLocation: true
					 }
				 },
			 ],
		 ],
		 scope: [
			 'block',
			 'inserter',
			 'transform'
		 ],
	 }
 ];
 
 const settings = {
	 edit: Edit,
	 save: Save,
	 icon,
	 variations
 };
 
 export { name, category, settings };
 