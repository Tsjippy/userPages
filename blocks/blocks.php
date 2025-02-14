<?php
namespace SIM\USERPAGES;
use SIM;

add_action('init', __NAMESPACE__.'\blockInit');
function blockInit() {
	register_block_type(
		__DIR__ . '/user_description/build',
		array(
			'render_callback' => __NAMESPACE__.'\linkedUserDescription',
			'attributes'      => [
				'id' => [
					'type' => 'integer'
				],
				'picture'  => [
					'type'  	=> 'boolean',
					'default' 	=> true,
				],
				'phone'  => [
					'type'  	=> 'boolean',
					'default' 	=> true,
				],
				'email'  => [
					'type'  	=> 'boolean',
					'default' 	=> true,
				],
				'style'  => [
					'type'  	=> 'string',
					'default' 	=> '',
				],
			]
		)
	);
}