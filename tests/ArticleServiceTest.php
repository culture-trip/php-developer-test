<?php

use Tests\TestCase;
use App\ArticleService;
use Spatie\Snapshots\MatchesSnapshots;

class ArticleServiceTest extends TestCase {
	use MatchesSnapshots;

	public function testArticleFiltering() : void {
		$articles = [
			[
				'id'      => 1,
				'title'   => 'Test title 1',
				'slug'    => 'test-slug-1',
				'content' => '',
			],
			[
				'id'      => 2,
				'title'   => '',
				'slug'    => 'test-slug-2',
				'content' => '',
			],
			[
				'id'      => 3,
				'title'   => 'Test title 3',
				'slug'    => '',
				'content' => '',
			],
			[
				'id'      => null,
				'title'   => 'Test title 4',
				'slug'    => 'test-slug-4',
				'content' => '',
			],
		];

		$this->assertMatchesJsonSnapshot( ( new ArticleService( $articles ) )->getArticles() );
	}
}
