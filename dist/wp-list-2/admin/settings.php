<?php
/**
 * WordPress Settings Framework
 *
 * @package Wp_List_2
 */

/**
 * Define your settings
 *
 * The first parameter of this filter should be wpsf_register_settings_[options_group],
 * in this case "my_example_settings".
 *
 * Your "options_group" is the second param you use when running new WordPressSettingsFramework()
 * from your init function. It's important as it differentiates your options from others.
 *
 * To use the tabbed example, simply change the second param in the filter below to 'wpsf_tabbed_settings'
 * and check out the tabbed settings function on line 156.
 */

add_filter( 'wpsf_register_settings_wp_list_2', 'wp_list_2_settings' );

/**
 * Settings for Wp_List_2.
 *
 * @param array $wpsf_settings An array of settings.
 *
 * @return array $wpsf_settings Settings array.
 */
function wp_list_2_settings( $wpsf_settings ) {
	// Tabs.
	$wpsf_settings['tabs'] = array(
		array(
			'id'    => 'tab_1',
			'title' => __( 'Tab 1' ),
		),
		array(
			'id'    => 'tab_2',
			'title' => __( 'Tab 2' ),
		),
	);

	// Settings.
	$wpsf_settings['sections'] = array(
		array(
			'tab_id'        => 'tab_1',
			'section_id'    => 'section_1',
			'section_title' => 'Section 1',
			'section_order' => 10,
			'fields'        => array(
				array(
					'id'      => 'text-1',
					'title'   => 'Text',
					'desc'    => 'This is a description.',
					'type'    => 'text',
					'default' => 'This is default',
				),
			),
		),
		array(
			'tab_id'        => 'tab_1',
			'section_id'    => 'section_2',
			'section_title' => 'Section 2',
			'section_order' => 10,
			'fields'        => array(
				array(
					'id'      => 'text-2',
					'title'   => 'Text',
					'desc'    => 'This is a description.',
					'type'    => 'text',
					'default' => 'This is default',
				),
			),
		),
		array(
			'tab_id'        => 'tab_2',
			'section_id'    => 'section_3',
			'section_title' => 'Section 3',
			'section_order' => 10,
			'fields'        => array(
				array(
					'id'      => 'text-3',
					'title'   => 'Text',
					'desc'    => 'This is a description.',
					'type'    => 'text',
					'default' => 'This is default',
				),
			),
		),
	);

	return $wpsf_settings;
}
