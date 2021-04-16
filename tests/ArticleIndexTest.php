<?php

use Tests\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class ArticleIndexTest extends TestCase {
	use MatchesSnapshots;

	public function testIndexReturnsArticles() : void {
		$request = $this->createRequest( 'GET', '/' );
		$res     = $this->app->handle( $request );

		$this->assertMatchesJsonSnapshot( (string) $res->getBody() );
	}
}
