<?php

namespace Tests;


class ArticleIndexTest extends TestCase {

	public function testIndexReturnsText() : void {

		$request = $this->createRequest( 'GET', '/' );
		$res     = $this->app->handle( $request );

		self::assertJson( (string) $res->getBody() );
	}
}
