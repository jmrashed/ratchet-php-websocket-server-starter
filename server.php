<?php

$request = $_SERVER['REQUEST_URI'];
die('login');
switch ($request) {
    case '/':
        require __DIR__ . '/views/index1.php';
        break;
    case '':
        require __DIR__ . '/views/index1.php';
        break;
    case '/about':
        require __DIR__ . '/views/about.php';
        break;
    case '/login':
        require __DIR__ . '/resources/views/login.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/resources/views/errors/404.php';
        break;
}
