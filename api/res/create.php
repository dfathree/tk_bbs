<?php
require_once('../lib/data_file_handler.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$thread_id = $data['threadId'];
$content = $data['content'];

$now = time();
$res_filename = "{$dir}/{$thread_id}/{$now}/{$now}.txt";
$ret = mkdir("{$dir}/{$thread_id}/{$now}");

file_put_contents($res_filename, implode("\n", ["", "-", str_replace("\n", '\n', $content)]));

http_response_code(201);
header('Content-Type: application/json');
print(json_encode(array(
  'threadId' => $thread_id,
  'resId' => $now,
  'content' => $content
)));
