<?php
require_once('../lib/data_file_handler.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$thread_id = $data['threadId'];
$title = $data['title'];
$content = $data['content'];

$res_filename = "{$dir}/{$thread_id}/{$thread_id}/{$thread_id}.txt";
$res_lines = file($res_filename, FILE_IGNORE_NEW_LINES);
$res_lines[0] = $title;
$res_lines[2] = str_replace("\n", '\n', $content);

file_put_contents($res_filename, implode("\n", $res_lines));

http_response_code(202);
header('Content-Type: application/json');
print(json_encode(array(
  'threadId' => $thread_id,
  'title' => $res_lines[0],
  'content' => $res_lines[2],
  'createdAt' => date('Y-m-d\TH:i:s+09:00', $thread_id),
)));
