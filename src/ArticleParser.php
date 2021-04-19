<?php

namespace App;

use Exception;
use ArrayObject;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;
use PHPHtmlParser\Dom\Node\AbstractNode;

class ArticleParser extends ArrayObject {
	private int $id;
	private string $title;
	private string $slug;
	private array $content;

	public function __construct( array $article ) {
		parent::__construct();

		$this->id      = (int) $article['id'];
		$this->title   = filter_var( $article['title'], FILTER_SANITIZE_STRING ) ?? '';
		$this->slug    = filter_var( $article['slug'], FILTER_SANITIZE_URL ) ?? '';
		$this->content = self::parseContent( $article['content'] );
	}

	private static function parseContent( string $rawContent ) : array {
		$dom = new Dom;
		try {
			$options = new Options();
			$options->setPreserveLineBreaks( true );
			$dom->loadStr( $rawContent, $options );
			$children = $dom->getChildren();
		} catch ( Exception $e ) {
			return [];
		}

		$content = [];

		foreach ( $children as $child ) {
			/* @var $child AbstractNode */
			$tag = $child->getTag()->name();

			switch ( strtolower( $tag ) ) {
				case 'img':
					$content[] = [
						'type' => 'image',
						'src'  => $child->getAttribute( 'src' ) ?? '',
						'alt'  => $child->getAttribute( 'alt' ) ?? '',
					];
					break;
				default:
					$text = trim( $child->innerhtml() );

					if ( empty( $text ) ) {
						break;
					}

					$text = preg_replace( '/\n{1,}/', '<br />', $text );

					$content[] = [
						'type'    => 'paragraph',
						'content' => $text,
					];
			}
		}

		return $content;
	}

	/**
	 * @return int
	 */
	public function getId() : int {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getTitle() : string {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getSlug() : string {
		return $this->slug;
	}

	/**
	 * @return array
	 */
	public function getContent() : array {
		return $this->content;
	}

	public function getArticle() : array {
		return [
			'id'      => $this->id,
			'title'   => $this->title,
			'slug'    => $this->slug,
			'content' => $this->content,
		];
	}
}
