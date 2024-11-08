<?php
$dir = '../../../dat';

if (!is_dir($dir)) {
    return error_response(404, 'directory not found');
}

function error_response($status_code, $message)
{
    http_response_code($status_code);
    header('Content-Type: application/json');
    print(json_encode(array(
        'message' => $message
    )));
}

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// プリフライトリクエストの場合、ここで終了
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
