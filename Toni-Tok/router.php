<?php 

session_set_cookie_params(0);
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    "/Toni-Tok/" => "controllers/discover.php",
    "/Toni-Tok/forYou" => "controllers/forYou.php",
    "/Toni-Tok/following" => "controllers/following.php",
    "/Toni-Tok/discover" => "controllers/forYou.php",
    "/Toni-Tok/add" => "controllers/add.php",
    "/Toni-Tok/profile" => "controllers/profile.php"
];

function guideToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {

    $root = $_SERVER['DOCUMENT_ROOT'];

    require("{$root}/Toni-Tok/{$routes[$uri]}");

    } else {

    abort();

    }
}

function abort($code = 404) {
    http_response_code($code);

    $root = $_SERVER['DOCUMENT_ROOT'];

    require("{$root}/Toni-Tok/HTML/{$code}.php");

    die();
}

guideToController($uri, $routes);