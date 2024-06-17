<?php

foreach (scandir(__DIR__.'/../public/avatars') as $dir) {
    switch($dir) {
        case '.':
        case '..':
        case 'default':
        break;
        default:
            if (file_exists(__DIR__.'/../public/avatars/'.$dir.'/who.txt')) {
                if (is_link(__DIR__.'/../public/avatars/'.$dir)) {
                    echo '[L] ';
                } else {
                    echo '[D] ';
                }

                echo trim(file_get_contents(__DIR__.'/../public/avatars/'.$dir.'/who.txt')).' '.$dir.PHP_EOL;
            }
    }
}
