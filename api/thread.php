<?php
require_once('./data_file_handler.php');

$thread_id = $_GET['threadId'];
if (!isset($thread_id)) {
  return error_response(400, 'threadId not set');
}

$directories = glob("{$dir}/{$thread_id}/[!.]*", GLOB_ONLYDIR);

$res_array = array();

foreach ($directories as $directory) {
  if ($directory != "{$dir}/{$thread_id}/{$thread_id}") {
    array_push($res_array, pathinfo($directory)['basename']);
  }
}

// 日付順にソートする
rsort($res_array);

// limit, offset
$per_page = isset($_GET['perPage']) ? intval($_GET['perPage']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$sliced_array = array_slice($res_array, ($page - 1) * $per_page, $per_page);

$content_array = array_map(function ($res_id) use ($dir, $thread_id) {
  $res_lines = file("{$dir}/{$thread_id}/{$res_id}/{$res_id}", FILE_IGNORE_NEW_LINES);

  // コメント
  $comment_array = array();
  $comment_files = glob("{$dir}/{$thread_id}/{$res_id}/[!.]*");
  foreach ($comment_files as $comment_file) {
    if ($comment_file == "{$dir}/{$thread_id}/{$res_id}/file" || $comment_file == "{$dir}/{$thread_id}/{$res_id}/{$res_id}") {
      continue;
    }
    $comment_id = pathinfo($comment_file)['basename'];
    array_push($comment_array, array(
      'commentId' => $comment_id,
      'content' => file($comment_file, FILE_IGNORE_NEW_LINES)[2],
      'createdAt' => date('Y-m-d\TH:i:s+09:00', $comment_id),
    ));
  }

  return array(
    'resId' => $res_id,
    'content' => $res_lines[2],
    'createdAt' => date('Y-m-d\TH:i:s+09:00', $res_id),
    'comments' => $comment_array,
    'images' => array_filter(array(
      $res_lines[3],
      $res_lines[4],
      $res_lines[5],
      $res_lines[6],
    )),
  );
}, $sliced_array);

// 親レスの読み込み
$parent_res = file("{$dir}/{$thread_id}/{$thread_id}/{$thread_id}", FILE_IGNORE_NEW_LINES);

header('Content-Type: application/json');
// print(json_encode(array('reses' => $res_array)));
print(json_encode(array(
  'total' => count($res_array),
  'page' => $page,
  'perPage' => $per_page,
  'parent' => array(
    'threadId' => $thread_id,
    'title' => $parent_res[0],
    'content' => $parent_res[2],
    'createdAt' => date('Y-m-d\TH:i:s+09:00', intval($thread_id))
  ),
  'res' => $content_array,
)));
