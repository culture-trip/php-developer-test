<?php

namespace App;

use Exception;

class ArticleService extends ArticleCollection {
	/**
	 * @throws Exception
	 */
	public function __construct() {
		$rawArticles = ( new ArticleDataSource() )->getArticles();

		foreach ( $rawArticles as $article ) {
			$parser = new ArticleParser( $article );
			$this->articles[] = $parser->getArticle();
		}
	}
}
