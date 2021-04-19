<?php

namespace App;

class ArticleService extends ArticleCollection {
	/**
	 * @param array|null $articles
	 */
	public function __construct( array $articles = null ) {
		if ( ! $articles ) {
			$articles = ( new ArticleDataSource() )->getArticles();
		}

		foreach ( $articles as $article ) {
			$parser = new ArticleParser( $article );

			if ( empty( $parser->getId() ) || empty( $parser->getSlug() ) ) {
				continue;
			}

			$this->articles[] = $parser->getArticle();
		}
	}
}
