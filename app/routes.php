<?php

use App\ArticleService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/** @noinspection PhpUndefinedVariableInspection */
$app->get( '/', function ( Request $request, Response $response, array $args ) {
	$articleService = new ArticleService();
	$response->getBody()->write( json_encode( $articleService->getArticles(), JSON_THROW_ON_ERROR ) );

	return $response;
} );

$app->get( '/{id:[0-9]+}', function ( Request $request, Response $response, array $args ) {
	if ( (int) $args['id'] <= 0 ) {
		return $response->withStatus( 400, 'Article ID must be a positive number!' );
	}

	$articleService = new ArticleService();
	$response->getBody()->write( json_encode( $articleService->getArticleById( $args['id'] ), JSON_THROW_ON_ERROR ) );

	return $response;
} );
