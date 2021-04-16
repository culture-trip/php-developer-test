<?php

namespace App;

abstract class ArticleCollection {
	protected array $articles;

	public function getArticles() : array {
		return $this->articles;
	}

	public function getArticleById( int $id ) : ?array {
		foreach ( $this->articles as $article ) {
			if ( (int) $article->id === $id ) {
				return $article;
			}
		}

		return null;
	}
}
