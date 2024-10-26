<?php
require_once('../lib/data_file_handler.php');
require('../lib/util.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$thread_id = $data['threadId'];
$res_id = $data['resId'];

$image_filename = $data['image'];

removeDirectory("{$dir}/{$thread_id}/{$res_id}/{$image_filename}");

$res_filename = "{$dir}/{$thread_id}/{$res_id}/{$res_id}.txt";
$res_lines = file($res_filename, FILE_IGNORE_NEW_LINES);
$new_res_lines = array_filter($res_lines, function ($line) use ($image_filename) {
    return $line != $image_filename;
});
file_put_contents($res_filename, implode("\n", $new_res_lines));

http_response_code(204);
