<?php

namespace App;

use Exception;
use JsonException;

class ArticleGet {
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
	public function getAll( $data ): string {

		$return = [];

		$parse = DataParse::init();

		foreach ( $data as $article ) {

			$return[]['id']      = $article['id'];
			$return[]['slug']    = $parse->filterUrl( $article['slug'] );
			$return[]['title']   = $parse->filterString( $article['title'] );
			$return[]['content'] = $parse->filterContent( $article['content'] );
		}

		try {
			return json_encode( $return, JSON_THROW_ON_ERROR );
		} catch ( JsonException $e ) {
			throw new JsonException( "$e::getMessage()" );
		}

	}

	/**
	 * @throws Exception
	 */
	public function getById( $id, $data ): string {

		$return = [];
		$found  = false;

		$parse = DataParse::init();

		foreach ( $data as $article ) {

			if ( $id === $article['id'] ) {

				$found = true;

				$return[]['id']      = $article['id'];
				$return[]['slug']    = $parse->filterUrl( $article['slug'] );
				$return[]['title']   = $parse->filterString( $article['title'] );
				$return[]['content'] = $parse->filterContent( $article['content'] );

				break;
			}
		}

		if ( ! $found ) {
			$return['message'] = 'No articles found';
		}

		try {
			return json_encode( $return, JSON_THROW_ON_ERROR );
		} catch ( JsonException $e ) {
			throw new JsonException( "$e::getMessage()" );
		}

	}
}