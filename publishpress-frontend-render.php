<?php

/**
 * Plugin Name:       Publishpress Frontend Render
 * Description:       Displays posts by post_status
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       publishpress-frontend-render
 *
 * @package CreateBlock
 */

namespace ppfr;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_publishpress_frontend_render_block_init()
{
    if (function_exists('wp_register_block_types_from_metadata_collection')) { // Function introduced in WordPress 6.8.
        wp_register_block_types_from_metadata_collection(__DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php');
    } else {
        if (function_exists('wp_register_block_metadata_collection')) { // Function introduced in WordPress 6.7.
            wp_register_block_metadata_collection(__DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php');
        }
        $manifest_data = require __DIR__ . '/build/blocks-manifest.php';
        foreach (array_keys($manifest_data) as $block_type) {
            register_block_type(__DIR__ . "/build/{$block_type}");
        }
    }

    \ppfr\register_custom_post_status();
    $post_statuses = \ppfr\get_post_statuses();
    wp_localize_script('create-block-publishpress-frontend-render-editor-script', 'postStatuses', $post_statuses);
}
add_action('init', '\\ppfr\create_block_publishpress_frontend_render_block_init');


function register_custom_post_status()
{
    register_post_status('in-progress', array(
        'label'                     => _x('In Progress', 'post status label'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('My Custom Status <span class="count">(%s)</span>', 'My Custom Status <span class="count">(%s)</span>'),
    ));
    register_post_status('task-complete', array(
        'label'                     => _x('Completed Tasks', 'post status label'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('My Custom Status <span class="count">(%s)</span>', 'My Custom Status <span class="count">(%s)</span>'),
    ));
}
function get_post_statuses()
{
    $statuses = get_post_stati([], 'objects');
    $status_options = [];

    foreach ($statuses as $status) {
        $status_options[] = [
            'value' => $status->name,
            'label' => $status->label,
        ];
    }
    return $status_options;
}

add_filter('display_post_states', function ($states) {
    global $post;
    $status = get_query_var('post_status');

    if ($status !== 'in-progress' && $post->post_status === 'in-progress') {
        return array_merge(array('In Progress'), $states);
    }
    if ($status !== 'task-complete' && $post->post_status === 'task-complete') {
        return array_merge(array('Task complete'), $states);
    }

    return $states;
});

add_filter('publishpress_calendar_post_statuses', function ($statuses) {
    $in_progress = new \stdClass();
    $in_progress->label = 'In Progress';
    $in_progress->description = 'In Progress';
    $in_progress->name = 'In Progress';
    $in_progress->slug = 'in-progress';
    $in_progress->position = 5;
    $statuses[] = $in_progress;

    $complete = new \stdClass();
    $complete->label = 'Task Complete';
    $complete->description = 'Task complete';
    $complete->name = 'Complete';
    $complete->slug = 'task-complete';
    $complete->position = 6;
    $statuses[] = $complete;

    return $statuses;
});
