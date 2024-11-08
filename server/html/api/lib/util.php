<?php

// 再帰的にディレクトリーを削除する関数
function removeDirectory($directory)
{
    if (is_dir($directory)) {
        $files = glob("{$directory}/[!.]*");
        foreach ($files as $file) {
            removeDirectory($file);
        }
        rmdir($directory);
    } else {
        unlink($directory);
    }
}
