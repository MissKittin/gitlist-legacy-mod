<?php

foreach (scandir(__DIR__.'/../public/_avatars_') as $dir) {
    switch($dir) {
        case '.':
        case '..':
        case 'default':
        break;
        default:
            if (file_exists(__DIR__.'/../public/_avatars_/'.$dir.'/who.txt')) {
                if (is_link(__DIR__.'/../public/_avatars_/'.$dir)) {
                    echo '[L] ';
                } else {
                    echo '[D] ';
                }

                echo trim(file_get_contents(__DIR__.'/../public/_avatars_/'.$dir.'/who.txt')).' '.$dir.PHP_EOL;
            }
    }
}
