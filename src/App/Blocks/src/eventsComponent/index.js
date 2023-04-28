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
					 query: {
						 per_page: 3,
						 order: 'desc',
						 orderby: 'start'
					 },
					 dateFormat: 'l F j, Y',
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
	 },
	 {
		 name: 'events-by-tag-welcome-calls',
		 title: __( 'Welcome Calls', 'dc-events-manager' ),
		 description: __( 'Display welcome call events with section header and description..', 'dc-events-manager' ),
		 icon: 'calendar-alt',
		 keywords: [
			 __( 'event', 'dc-events-manager' ),
			 __( 'grid', 'dc-events-manager' ),
			 __( 'component', 'dc-events-manager' )
		 ],
		 attributes: {
			 className: 'events-by-tag welcome-calls'
		 },
		 innerBlocks: [
			 [
				 'core/heading',
				 {
					 className: 'taxonomy-label',
					 level: 2,
					 placeholder: __( 'Add Title...', 'dc-events-manager' ),
					 content: __( 'Welcome Calls', 'dc-events-manager' )
				 },
			 ],
			 [
				 'core/paragraph',
				 {
					 className: 'taxonomy-description',
					 placeholder: __( 'Add Description...', 'dc-events-manager' ),
					 content: __( 'Are you new to the Debt Collective or the Biden Jubilee 100 campaign and want to learn more about our union and what we\'re fighting for? Join us for our welcome calls!', 'dc-events-manager' )
				 },
			 ],
			 [
				 'dc-events-manager/event-query',
				 {
					 query: {
						 per_page: 3,
						 order: 'desc',
						 orderby: 'start',
						 'event-tags': [10]
					 },
					 eventTags: '10',
					 dateFormat: 'D, M j',
					 timeFormat: 'g:ia',
					 display: {
						 showTags: false,
						 showFeaturedImage: false,
						 showTitle: false,
						 showDate: true,
						 showTime: true,
						 showEndTime: false,
						 showLocation: true
					 }
				 },
			 ],
		 ],
		 scope: [
			 'transform',
			 'inserter'
		 ],
	 }
 ];
 
 const settings = {
	 edit: Edit,
	 save: Save,
	 variations
 };
 
 export { name, category, settings };
 