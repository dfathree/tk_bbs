<?php
require_once('../lib/data_file_handler.php');

$thread_id = $_GET['threadId'];
$res_id = $_GET['resId'];

$res_filename = "{$dir}/{$thread_id}/{$res_id}/{$res_id}.txt";
$res_lines = file($res_filename, FILE_IGNORE_NEW_LINES);

header('Content-Type: application/json');
print(json_encode(array(
  'threadId' => $thread_id,
  'resId' => $res_id,
  'content' => $res_lines[2],
  'images' => array_slice($res_lines, 3),
)));
