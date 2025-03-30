<?php
// This file is generated. Do not modify it manually.
return array(
	'publishpress-frontend-render' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/publishpress-frontend-render',
		'version' => '0.1.0',
		'title' => 'Publishpress Frontend Render',
		'category' => 'widgets',
		'icon' => 'welcome-add-page',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'color' => array(
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => true
			),
			'align' => array(
				'full',
				'center',
				'left',
				'wide',
				'right'
			)
		),
		'attributes' => array(
			'postStatus' => array(
				'type' => 'string',
				'default' => 'publish'
			),
			'title' => array(
				'type' => 'string',
				'default' => 'Archive'
			),
			'titleHeading' => array(
				'type' => 'string',
				'default' => 'h2'
			),
			'borders' => array(
				'type' => 'number',
				'default' => '0'
			)
		),
		'textdomain' => 'publishpress-frontend-render',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	)
);
