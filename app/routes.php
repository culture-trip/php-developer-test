<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/** @noinspection PhpUndefinedVariableInspection */
$app->get( '/', function ( Request $request, Response $response, $args ) {
	$response->getBody()->write( "Hello world!" );

	return $response;
} );
