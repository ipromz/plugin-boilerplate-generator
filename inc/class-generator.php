<?php

/**
 * Undocumented class
 */
class PluginGenerator {

	/**
	 * Files list.
	 *
	 * @var array
	 */
	public static $file_list = array();

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	public static $plugin_slug = '';

	/**
	 * Initialize.
	 *
	 * @param string $slug Plugin Slug.
	 */
	public static function init( $slug ) {
		self::$plugin_slug = $slug;
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function get_kebab_case( $slug ) {

		return str_replace( '_', '-', $slug );

	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $slug
	 *
	 * @return void
	 */
	public static function get_snake_case( $slug ) {

		return str_replace( '-', '_', $slug );

	}

	/**
	 * Undocumented function
	 *
	 * @param string $slug The Slug.
	 *
	 * @return string
	 */
	public static function get_capitalize_case( $slug ) {
		$words             = explode( '_', $slug );
		$capitalized_words = array();

		foreach ( $words as $word ) {
			$capitalized_words[] = ucfirst( $word );
		}

		return implode( '_', $capitalized_words );
	}


	/**
	 * Undocumented function
	 *
	 * @param [type] $slug
	 *
	 * @return void
	 */
	public static function get_upper_case( $slug ) {
		return strtoupper( $slug );
	}

	/**
	 * @param $dir
	 */
	public static function delete_directory( $dir ) {

		if ( ! file_exists( $dir ) ) {
			return true;
		}

		if ( ! is_dir( $dir ) ) {
			return unlink( $dir );
		}

		foreach ( scandir( $dir ) as $item ) {

			if ( '.' == $item || '..' == $item ) {
				continue;
			}

			if ( ! self::delete_directory( $dir . DIRECTORY_SEPARATOR . $item ) ) {
				return false;
			}
		}

		return rmdir( $dir );
	}



	public static function copyFolder( $destnation_folder ) {
		$src_folder = './plugin-name';
		self::xcopy( $src_folder, $destnation_folder );
	}

	/**
	 * Copy a file, or recursively copy a folder and its contents
	 *
	 * @param string $source      Source path.
	 * @param string $dest        Destination path.
	 * @param int    $permissions New folder creation permissions.
	 *
	 * @return      bool     Returns true on success, false on failure
	 */
	public static function xcopy( $source, $dest, $permissions = 0755 ) {
		// Check for symlinks.

		if ( is_link( $source ) ) {
			return symlink( readlink( $source ), $dest );
		}

		// Simple copy for a file.
		if ( is_file( $source ) ) {
			$slug_snake_case = self::get_kebab_case( self::$plugin_slug );
			$dest            = str_replace( 'plugin-name', $slug_snake_case, $dest );
			return copy( $source, $dest );
		}

		// Make destination directory.
		if ( ! is_dir( $dest ) ) {
			mkdir( $dest, $permissions );
		}

		// Loop through the folder.
		$dir = dir( $source );

		while ( false !== $entry = $dir->read() ) {

			// Skip pointers.
			if ( '.' == $entry || '..' == $entry ) {
				continue;
			}

			// Deep copy directories.
			self::xcopy( "$source/$entry", "$dest/$entry", $permissions );
		}

		// Clean up.
		$dir->close();

		return true;

	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function list_folder_files( $dir ) {
		foreach ( new DirectoryIterator( $dir ) as $file_info ) {

			if ( ! $file_info->isDot() ) {
				self::$file_list[] = $dir . '/' . $file_info->getFilename();

				if ( $file_info->isDir() ) {
					self::list_folder_files( $file_info->getPathname() );
				}
			}
		}

		return self::$file_list;
	}

	/**
	 * @param $filename
	 * @param $string_to_replace
	 * @param $replace_with
	 */
	public static function replace_string_in_file( $filename, $string_to_replace, $replace_with ) {
		$content        = file_get_contents( $filename );
		$content_chunks = explode( $string_to_replace, $content );
		$content        = implode( $replace_with, $content_chunks );
		file_put_contents( $filename, $content );
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $folder
	 *
	 * @return void
	 */
	public static function zip( $folder, $output ) {
		$root_path = realpath( $folder );

		// Initialize archive object.
		$zip = new ZipArchive();
		$zip->open( $output, ZipArchive::CREATE | ZipArchive::OVERWRITE );

		// Create recursive directory iterator.
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $root_path ),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ( $files as $name => $file ) {

			// Skip directories (they would be added automatically).
			if ( ! $file->isDir() ) {
				// Get real and relative path for current file.
				$file_path      = $file->getRealPath();
				$relative_path = substr( $file_path, strlen( $root_path ) + 1 );

				// Add current file to archive.
				$zip->addFile( $file_path, $relative_path );
			}
		}

		// Zip archive will be created only after closing object.
		$zip->close();
	}

	public static function download_zip( $filename ) {

		if ( file_exists( $filename ) ) {
			header( 'Content-Type: application/zip' );
			header( 'Content-Disposition: attachment; filename="' . basename( $filename ) . '"' );
			header( 'Content-Length: ' . filesize( $filename ) );

			flush();
			readfile( $filename );
			// delete file.
			unlink( $filename );
		}

	}

}
