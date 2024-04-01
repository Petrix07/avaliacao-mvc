<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;

echo (new Router)->direciona(getUriTratada(), $_SERVER['REQUEST_METHOD']);

/**
 * Retorna a "uri" informada pelo usuário 
 * @return string
 */
function getUriTratada(): string {
    $uri = strtolower($_SERVER['REQUEST_URI']);
    if (strpos($uri, Router::PATH_BASE) === 0) {
        $uri = substr($uri, strlen(Router::PATH_BASE));
    }

    return $uri;
}
