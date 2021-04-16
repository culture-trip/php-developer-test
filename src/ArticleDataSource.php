<?php

namespace App;

use Exception;
use JsonException;

class ArticleDataSource extends ArticleCollection {
	/**
	 * @throws Exception
	 */
	public function __construct() {
		// Load data from JSON file.
		$fileContent = file_get_contents( dirname( __DIR__ ) . '/assets/articles.json' );

		if ( ! $fileContent ) {
			throw new Exception( 'Input file empty!' );
		}

		try {
			$this->articles = json_decode( $fileContent, true, 512, JSON_THROW_ON_ERROR );
		} catch ( JsonException $e ) {
			throw new Exception( "Could not parse data from JSON file: {$e->getMessage()}" );
		}
	}
}
