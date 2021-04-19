<?php

use Tests\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class ArticleSingleTest extends TestCase {
	use MatchesSnapshots;

	public function testExpectsValidId() : void {
		$request = $this->createRequest( 'GET', '/0' );
		$res     = $this->app->handle( $request );

		self::assertEquals( 400, $res->getStatusCode() );
		self::assertStringContainsString( 'ID must be a positive number', $res->getReasonPhrase() );
	}

	public function testReturnsSingleArticleById() : void {
		$ids = [ 1, 2, 3 ];

		foreach ( $ids as $id ) {
			$request = $this->createRequest( 'GET', "/$id" );
			$res     = $this->app->handle( $request );

			$this->assertMatchesJsonSnapshot( (string) $res->getBody() );
		}
	}
}
