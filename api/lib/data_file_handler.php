<?php
$dir = '../../../dat';

function error_response($status_code, $message)
{
    http_response_code($status_code);
    header('Content-Type: application/json');
    print(json_encode(array(
        'message' => $message
    )));
}

if (!is_dir($dir)) {
    return error_response(404, 'directory not found');
}
