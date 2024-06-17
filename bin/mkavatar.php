<?php

if (! isset($argv[1]) && ! isset($argv[2])) {
    echo 'Usage: '.$argv[0].' "my@email.com" path/to/files'.PHP_EOL;
    exit(1);
}

foreach (['default.png', '40.png', '32.png'] as $file) {
    if (! is_file($argv[2].'/'.$file)) {
        echo $argv[2].'/'.$file.' does not exist'.PHP_EOL;
        exit(1);
    }
}

$hash=md5(strtolower($argv[1]));

mkdir(__DIR__.'/../public/avatars/'.$hash);

foreach (['default.png', '40.png', '32.png'] as $file) {
    copy($argv[2].'/'.$file, __DIR__.'/../public/avatars/'.$hash.'/'.$file);
}

file_put_contents(__DIR__.'/../public/avatars/'.$hash.'/who.txt', $argv[1]."\n");

echo $argv[1].' '.$hash.PHP_EOL;
