<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/App.php';

use App\App;

$app = new App();
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($path === '/health') {
    http_response_code(200);
    header('Content-Type: text/plain; charset=utf-8');
    echo $app->health();
    return;
}

http_response_code(200);
header('Content-Type: text/plain; charset=utf-8');
echo $app->home();
