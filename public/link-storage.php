<?php

$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

if (file_exists($link)) {
    echo "The 'storage' link already exists.";
} elseif (!function_exists('symlink')) {
    echo "ERROR: The 'symlink' function is disabled on your hosting.<br><br>";
    echo "<b>Alternative Solution:</b><br>";
    echo "1. Log in to your cPanel/Hosting Control Panel.<br>";
    echo "2. Find 'Cron Jobs'.<br>";
    echo "3. Add a new job to run <b>once</b> with this command:<br>";
    echo "<code>ln -s $target $link</code><br><br>";
    echo "4. After it runs, your images will appear!";
} else {
    if (@symlink($target, $link)) {
        echo "Congratulations! The 'storage' link has been created successfully.";
    } else {
        echo "Failed to create the link manually. Please contact your hosting support and ask them to create a symlink from $target to $link.";
    }
}
