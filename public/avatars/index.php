<?php

chdir(__DIR__.'/..');

$_GET['s']=filter_input(INPUT_GET, 's', FILTER_VALIDATE_INT);

if (! $_GET['s']) {
    $_GET['s']='default';
}

$strtok=strtok($_SERVER['REQUEST_URI'], '?');

if (! file_exists('.'.$strtok)) {
    $dirname=dirname($strtok);

    while (! file_exists('./'.$dirname.'/default')) {
        $dirname=dirname($dirname);
    }

    if (! file_exists(__DIR__.'/default/'.$_GET['s'].'.png'))
        $_GET['s']='default';

    header(
        'Location: '.$dirname.'/default/'.$_GET['s'].'.png',
        true,
        301
    );

    exit();
}

$slash='/';

if (substr($strtok, -1) === '/') {
    $slash='';
}

header(
    'Location: '.$strtok.$slash.$_GET['s'].'.png',
    true,
    301
);
