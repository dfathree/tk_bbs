<?php
require_once('../lib/data_file_handler.php');

$thread_id = $_GET['threadId'];
$res_id = $_GET['resId'];
$filename = $_GET['filename'];

$image_file = file_get_contents("{$dir}/{$thread_id}/{$res_id}/{$filename}");

$extension = pathinfo($filename, PATHINFO_EXTENSION);
switch ($extension) {
  case 'svg':
    $content_type = 'image/svg+xml';
    break;
  default:
    $content_type = "image/{$extension}";
    break;
}

header("Content-Type: {$content_type}");
print($image_file);
