<?php

use App\ArticleGet;
use App\JsonRead;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$data = JsonRead::init()->getJson( dirname( __DIR__ ) . '/assets/articles.json' );
$articles = ArticleGet::init();

/** @noinspection PhpUndefinedVariableInspection */
$app->get( '/', function ( Request $request, Response $response ) use( $data, $articles ) {

	$response->getBody()->write( $articles->getAll( $data ) );
	return $response;

} );

$app->get( '/{id}',
	function ( Request $request, Response $response, array $args ) use( $data, $articles ) {

		global $articles, $data;
		$response->getBody()->write( $articles->getById( $args['id'], $data ) );

		return $response;
	} );
