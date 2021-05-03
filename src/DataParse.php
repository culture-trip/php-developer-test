<?php
namespace App;

use Exception;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Options;

class DataParse {

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
	 * @param $url
	 *
	 * @return string
	 */
	public function filterUrl( $url ): string {
		return filter_var( $url, FILTER_SANITIZE_URL );
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public function filterString( $string ): string {
		return filter_var( $string, FILTER_SANITIZE_STRING );
	}

	/**
	 * @param $content
	 *
	 * @return array
	 * @throws NotLoadedException
	 * @throws Exception
	 */
	public function filterContent( $content ): array {

		$dom = new Dom;
		$dom->setOptions(
			( new Options() )
				->setPreserveLineBreaks( true )
		);

		try {
			$dom->loadStr( $content );
		} catch ( Exception $e ) {
			throw new Exception( "$e::getMessage()" );
		}

		$return   = [];
		$children = $dom->getChildren();

		foreach ( $children as $child ) {

			$tag = $child->getTag()->name();

			if ( strtolower( $tag ) === 'img' ) {

				$return[] = [
					'type' => 'image',
					'src'  => $child->getAttribute( 'src' )??'',
					'alt'  => $child->getAttribute( 'alt' )??'',
				];
			} else {
				$text = trim( $child->innerhtml() );

				if ( empty( $text ) ) {
					break;
				}

				$text = preg_replace( '/\n+/', '<br />', trim( $text ) );

				$return[] = [
					'type'    => 'paragraph',
					'content' => $text,
				];
			}
		}

		return $return;
	}

}