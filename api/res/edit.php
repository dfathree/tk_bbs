<?php
require_once('../lib/data_file_handler.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$thread_id = $data['threadId'];
$res_id = $data['resId'];
$content = $data['content'];

$res_filename = "{$dir}/{$thread_id}/{$res_id}/{$res_id}.txt";
$res_file_array = file($res_filename, FILE_IGNORE_NEW_LINES);
$res_file_array[2] = $content;
file_put_contents($res_filename, implode("\n", $res_file_array));

http_response_code(202);
header('Content-Type: application/json');
print(json_encode(array(
  'threadId' => $thread_id,
  'resId' => $res_id,
  'content' => $res_file_array[2]
)));
