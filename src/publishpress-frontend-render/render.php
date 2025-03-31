<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$post_status = isset($attributes['postStatus']) ? $attributes['postStatus'] : null;
$title = isset($attributes['title']) ? $attributes['title'] : '';
$heading = isset($attributes['titleHeading']) ? $attributes['titleHeading'] : 'h2';
$border_radius = isset($attributes['borders']) ? $attributes['borders'] : '0';

if (!$post_status) {
?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e('No Post status defined', 'publishpress-frontend-render'); ?>
	</p>

<?php
	return;
}

$extra_wrapper_atts = ['style' => 'border-radius: ' . $border_radius . 'px;'];
?>

<div <?php echo get_block_wrapper_attributes($extra_wrapper_atts); ?>>
	<?php
	echo "<$heading>$title</$heading>";
	$posts = get_posts(['post_status' => $post_status, 'post_type' => ['page', 'post']],);
	foreach ($posts as $post) {
		$tags = get_the_tags($post) ?: [];
		$categories = get_the_category($post->ID) ?: [];
		$content = $post->post_content ?: null;
	?>
		<?php if ($content): ?>
			<details>
				<summary>
				<?php else: ?>
					<div class="no-content">
					<?php endif ?>
					<div class="post-title"><?php echo $post->post_title; ?></div>
					<div class="post-tags-cats">
						<div>
							<?php
							foreach ($tags as $tag) {
								echo '<div class="tag tag-' . $tag->slug . '">' . $tag->name . '</div>';
							}
							?>
						</div>
						<div>
							<?php
							foreach ($categories as $cat) {
								echo '<div class="cat cat-' . $cat->slug . '">' . $cat->name . '</div>';
							}
							?>
						</div>
					</div>
					<?php if ($content): ?>
					</summary>
					<?php echo $content; ?>
			</details>
		<?php else: ?>
</div>
<?php endif ?>
<?php
	}
?>
</div>