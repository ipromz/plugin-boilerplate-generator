<?php
/**
 * Generate Plugin boiler plate.
 *
 * @package Plugin Generator
 */

/* error_reporting( E_ALL );
ini_set( 'display_errors', 1 ); */

require 'inc/class-generator.php';

if ( isset( $_POST['plugin_name'] ) ) {
	$plugin_name = filter_input( INPUT_POST, 'plugin_name' );
	$plugin_slug = filter_input( INPUT_POST, 'plugin_slug' );
	$plugin_url  = filter_input( INPUT_POST, 'plugin_url' );
	$author_name = filter_input( INPUT_POST, 'author_name' );
	$author_url  = filter_input( INPUT_POST, 'author_url' );

	$plugin_slug = rtrim( $plugin_slug, '_' );

	$rand            = uniqid();
	$snake_case      = $plugin_slug; // snake_case.
	$kebab_case      = PluginGenerator::get_kebab_case( $plugin_slug ); // kebab-case.
	$capitalize_case = PluginGenerator::get_capitalize_case( $plugin_slug ); // Plugin_Name.
	$uppercase       = PluginGenerator::get_upper_case( $plugin_slug ); // PLUGIN_NAME.
	$output_folder   = "./dist/$kebab_case";
	$main_file       = "./dist/{$kebab_case}/{$kebab_case}.php";
	$output_zip      = "./dist/{$kebab_case}-{$rand}.zip";

	PluginGenerator::init( $snake_case );
	PluginGenerator::delete_directory( $output_folder );
	PluginGenerator::copyFolder( $output_folder );
	$files = PluginGenerator::list_folder_files( $output_folder );

	foreach ( $files as $file ) {
		if ( is_dir( $file ) ) {
			continue;
		}

		PluginGenerator::replace_string_in_file( $file, 'Plugin_Name', $capitalize_case );
		PluginGenerator::replace_string_in_file( $file, 'PLUGIN_NAME', $uppercase );
		PluginGenerator::replace_string_in_file( $file, 'plugin-name', $kebab_case );
		PluginGenerator::replace_string_in_file( $file, '%PluginName%', $plugin_name );
	}

	// Handle main file.
	PluginGenerator::replace_string_in_file( $main_file, 'plugin_name', $snake_case );
	PluginGenerator::replace_string_in_file( $main_file, '@link              http://example.com', "@link              $plugin_url" );
	PluginGenerator::replace_string_in_file( $main_file, 'Author URI:        http://example.com/', "Author URI:        $author_url" );
	PluginGenerator::replace_string_in_file( $main_file, "http://example.com/{$kebab_case}-uri/", $plugin_url );
	PluginGenerator::replace_string_in_file( $main_file, 'WordPress Plugin Boilerplate', $plugin_name );
	PluginGenerator::replace_string_in_file( $main_file, 'Your Name or Your Company', $author_name );

	// String Replacing work done, zip the folder.
	PluginGenerator::zip( $output_folder, $output_zip );
	PluginGenerator::download_zip( $output_zip );
}
