<?php

namespace App;

abstract class ArticleCollection {
	protected array $articles;

	public function getArticles() : array {
		return $this->articles;
	}

	/**
	 * @param int $id
	 *
	 * @return array|object|null
	 */
	public function getArticleById( int $id ) {
		foreach ( $this->articles as $article ) {
			if (
				( is_object( $article ) && (int) $article->id === $id ) ||
				( is_array( $article ) && (int) $article['id'] === $id )
			) {
				return $article;
			}
		}

		return null;
	}
}
