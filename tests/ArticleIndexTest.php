<?php

use Tests\TestCase;

class ArticleIndexTest extends TestCase {
	public function testIndexReturnsText() : void {
		$request = $this->createRequest( 'GET', '/' );
		$res     = $this->app->handle( $request );

		self::assertEquals( 'Hello world!', (string) $res->getBody() );
	}
}
