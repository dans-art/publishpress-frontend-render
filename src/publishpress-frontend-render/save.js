import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';

export default function Edit(attributes) {
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
    const borderRad = borders || 0;
    return (
        <div {...useBlockProps()} style={{borderRadius: `${borderRad}px`}}>
			<div>
				<RichText
					tagName={titleHeading}
					value={title}
					onChange={(value) => setAttributes({ title: value })}
				></RichText>
				Display: {postStatus}<br />
				{message}
			</div>
		</div>
    );
}