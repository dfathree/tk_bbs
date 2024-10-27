<?php
require_once('../lib/data_file_handler.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$title = $data['title'];
$content = $data['content'];

$now = time();
$res_filename = "{$dir}/{$now}/{$now}/{$now}.txt";
$ret = mkdir("{$dir}/{$now}/{$now}", 0777, true);

file_put_contents($res_filename, implode("\n", [$title, "-", $content]));

http_response_code(201);
header('Content-Type: application/json');
print(json_encode(array(
  'threadId' => $now,
  'title' => $title,
  'content' => $content,
  'createdAt' => date('Y-m-d\TH:i:s+09:00', $now),
)));
