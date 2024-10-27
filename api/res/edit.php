<?php
require_once('../lib/data_file_handler.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$thread_id = $data['threadId'];
$res_id = $data['resId'];
$content = $data['content'];
$images = $data['images'];

$res_filename = "{$dir}/{$thread_id}/{$res_id}/{$res_id}.txt";
$res_lines = file($res_filename, FILE_IGNORE_NEW_LINES);
$res_lines[2] = str_replace("\n", '\n', $content);

foreach ($images as $image) {
  if (preg_match("/^data:image\\/(.*);base64,(.*)$/", $image, $matches)) {
    $image_filename = 'image' .  uniqid() . ".{$matches[1]}";
    file_put_contents("{$dir}/{$thread_id}/{$res_id}/{$image_filename}", base64_decode($matches[2]));
    array_push($res_lines, $image_filename);
  }
}

file_put_contents($res_filename, implode("\n", $res_lines));

http_response_code(202);
header('Content-Type: application/json');
print(json_encode(array(
  'threadId' => $thread_id,
  'resId' => $res_id,
  'content' => $res_lines[2],
  'images' => array_slice($res_lines, 3),
  'createdAt' => date('Y-m-d\TH:i:s+09:00', $res_id),
)));
