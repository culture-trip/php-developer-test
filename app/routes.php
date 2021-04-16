<?php

use App\ArticleService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/** @noinspection PhpUndefinedVariableInspection */
$app->get( '/', function ( Request $request, Response $response, $args ) {
	$articleService = new ArticleService();
	$response->getBody()->write( json_encode( $articleService->getArticles(), JSON_THROW_ON_ERROR ) );

	return $response;
} );
