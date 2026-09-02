<?php

// 1. Chargement de l'autoloader Composer
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

// 2. Initialisation du Router
$router = new Router();

// 3. Définition des routes de l'application
$router->add('GET', '/', 'ItemController@index');
$router->add('GET', '/items/create', 'ItemController@create');
$router->add('POST', '/items/store', 'ItemController@store');

// 4. Traitement de la requête entrante
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

if ($basePath !== '' && $basePath !== '/' && substr($requestPath, 0, strlen($basePath)) === $basePath) {
	$requestPath = substr($requestPath, strlen($basePath)) ?: '/';
}

$router->dispatch($requestPath, $_SERVER['REQUEST_METHOD']);