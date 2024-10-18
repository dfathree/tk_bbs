<?php
require_once('../lib/data_file_handler.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$thread_id = $data['threadId'];
$res_id = $data['resId'];
$comment_id = $data['commentId'];

unlink("{$dir}/{$thread_id}/{$res_id}/{$comment_id}.txt");

http_response_code(204);
