<?php

namespace App;

// TODO: Improve the readability of this file through refactoring and documentation.

require_once dirname( __DIR__ ) . '/globals.php';

class App {
	/**
	 * Save article to file directory
	 *
	 * @param String $title
	 * @param mixed $data
	 * @return void
	 */
	public function save( String $title, mixed $data ): void {
		error_log( "Saving article $title, success!" );
 		file_put_contents( $title, $data );
	}
	/**
	 * Update article
	 * @param String $title - title of article
	 * @param Mixed $data - article contents
	 */
	public function update( String $title, mixed $data ) {
		$this->save( $title, $data );
	}

	/**
	 * Retrieve article contents by title
	 * @param Mixed $get
	 */
	public function fetch( $get ) {
		$title = $get['title'] ?? null;

		return is_array( $get ) ? file_get_contents( sprintf( 'articles/%s', $get['title'] ) ) :
			file_get_contents( 'articles/%s', $_GET['title'] );
	}

	/**
	 * Gets all articles from a article directory
	 * @param Array;
	 */
	public function getListOfArticles() {
		global $wgBaseArticlePath;
		return array_diff( scandir( $wgBaseArticlePath ), [ '.', '..', '.DS_Store' ] );
	}
}
