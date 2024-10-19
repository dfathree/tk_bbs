<?php
require_once('../lib/data_file_handler.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$thread_id = $data['threadId'];
$content = $data['content'];
$files = $data['files'];

$now = time();
$res_filename = "{$dir}/{$thread_id}/{$now}/{$now}.txt";
$ret = mkdir("{$dir}/{$thread_id}/{$now}");

$res_contents = array("", "-", str_replace("\n", '\n', $content));

foreach ($files as $file) {
  if (preg_match("/^data:image\\/(.*);base64,(.*)$/", $file, $matches)) {
    $image_filename = 'image' .  uniqid() . ".{$matches[1]}";
    file_put_contents("{$dir}/{$thread_id}/{$now}/{$image_filename}", base64_decode($matches[2]));
    array_push($res_contents, $image_filename);
  }
}

file_put_contents($res_filename, implode("\n", $res_contents));

http_response_code(201);
header('Content-Type: application/json');
print(json_encode(array(
  'threadId' => $thread_id,
  'resId' => $now,
  'content' => $res_contents[2],
  'files' => array_slice($res_contents, 3),
)));
