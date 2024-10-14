<?php
require_once('../lib/data_file_handler.php');

$thread_array = array();

$directories = glob("{$dir}/[!.]*", GLOB_ONLYDIR);

$thread_array = array_map(function ($directory) {
  return array(
    'threadId' => pathinfo($directory)['basename'],
    'lastModifiedUnixTime' => filemtime($directory)
  );
}, $directories);

// 日付順にソートする
usort($thread_array, function ($a, $b) {
  return $b['lastModifiedUnixTime'] - $a['lastModifiedUnixTime'];
});

$sorted_array = array_map(function ($thread) {
  return array(
    'threadId' => $thread['threadId'],
    'lastModified' => date('Y-m-d\TH:i:s+09:00', $thread['lastModifiedUnixTime'])
  );
}, $thread_array);

header('Content-Type: application/json');
print(json_encode(array('threads' => $sorted_array)));
