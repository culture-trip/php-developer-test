<?php

namespace App;

use Exception;
use JsonException;

class JsonRead {

	/**
	 * @var object|null
	 */
	private static ?object $instance = null;

	/**
	 * @return self
	 * @throws Exception
	 */
	public static function init(): self {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @throws Exception
	 */
	public function getJson( $filename ) {

		$data = file_get_contents( $filename );

		if ( ! $data ) {
			throw new Exception( 'Get file content error' );
		}

		try {
			$return = json_decode( $data, true, 512, JSON_THROW_ON_ERROR );
		} catch ( JsonException $e ) {
			throw new JsonException( "$e::getMessage()" );
		}

		return $return;
	}
}