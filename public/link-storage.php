<?php

$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

if (file_exists($link)) {
    echo "The 'storage' link already exists.";
} else {
    if (symlink($target, $link)) {
        echo "Congratulations! The 'storage' link has been created successfully.";
    } else {
        echo "Failed to create the link. You may need to ask your hosting support to create a symlink from $target to $link.";
    }
}
