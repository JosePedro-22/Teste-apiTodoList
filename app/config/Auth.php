<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require '../../vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$authorization = $_SERVER['HTTP_AUTHORIZATION'];

$token = str_replace('Bearer ', '', $authorization);

try {
    // $decoded = JWT::decode($token, $_SERVER['KEY'], ['HS256']);
    $decoded = JWT::decode($token, new Key($_SERVER['KEY'], 'HS256'));
    echo json_encode($decoded);
} catch (Throwable $e) {
    if ($e->getMessage() === 'Expired token') {
        http_response_code(401);
        die('EXPIRED');
    }
}