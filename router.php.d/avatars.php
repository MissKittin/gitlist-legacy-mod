<?php

if (substr($_SERVER['REQUEST_URI'], 0, 10) === '/_avatars_' && ! is_file(substr(strtok($_SERVER['REQUEST_URI'], '?'), 1))) {
    require __DIR__.'/../public/_avatars_/index.php';
    exit();
}
