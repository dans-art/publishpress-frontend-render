/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

import { SelectControl, PanelBody, RangeControl, TextControl } from '@wordpress/components';
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { postStatus, title, titleHeading, borders } = attributes;
	const postStatuses = window.postStatuses || [];
	const headings = [
		{ label: 'H1', value: 'h1' },
		{ label: 'H2', value: 'h2' },
		{ label: 'H3', value: 'h3' },
		{ label: 'H4', value: 'h4' }
	]
	const titleTag = titleHeading || 'h2';

	const message = (postStatus) ? 'View the frontend for the posts' : 'Please select the post type';
	return (
		<p {...useBlockProps()} style={{borderRadius: `${borders}px`}}>
			<>
				<InspectorControls>
					<PanelBody title={__('Settings', 'copyright-date-block')}>
						<SelectControl
							label="Post Status"
							value={postStatus}
							options={
								(postStatuses).map(status => ({
									label: status.label,
									value: status.value
								}))
							}
							onChange={(value) => setAttributes({ postStatus: value })}
						/>
						<SelectControl
							label="Title Heading"
							value={titleHeading}
							options={headings}
							onChange={(value) => setAttributes({ titleHeading: value })}
						/>
						<TextControl
							label="Title"
							value={title}
							onChange={(value) => setAttributes({ title: value })}
						/>
						<RangeControl
							label="Borders"
							value={borders}
							onChange={(value) => setAttributes({ borders: value })}
							min={0}
							max={200}
							default={0}
						>
						</RangeControl>
					</PanelBody>
				</InspectorControls>
			</>
			<div>
				<RichText
					tagName={titleHeading}
					value={title}
					onChange={(value) => setAttributes({ title: value })}
				></RichText>
				Display: {postStatus}<br />
				{message}
			</div>
		</p>
	);
}
