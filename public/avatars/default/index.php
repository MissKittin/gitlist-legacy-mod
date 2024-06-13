<?php

if (! isset($_GET['s'])) {
    $_GET['s']='default';
}

if (! file_exists(__DIR__.'/../'.basename(strtok($_SERVER['REQUEST_URI'], '?')))) {
    header(
        'Location: '.dirname(strtok($_SERVER['REQUEST_URI'], '?')).'/default/'.$_GET['s'].'.png',
        true,
        301
    );
    exit();
}

header(
    'Location: '.strtok($_SERVER['REQUEST_URI'], '?').'/'.$_GET['s'].'.png',
    true,
    301
);
