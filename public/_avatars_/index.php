<?php

chdir (__DIR__.'/..');

header ('Pragma: cache');
header ('Cache-Control: max-age=31536000');

$_GET['s'] = filter_input (INPUT_GET, 's', FILTER_VALIDATE_INT);

if (! $_GET['s']) {
    $_GET['s'] = 'default';
}

$strtok = strtok ($_SERVER['REQUEST_URI'], '?');

if (substr ($strtok, -10) === '/index.php') {
    $strtok = substr ($strtok, 0, -9);
}

if (basename($strtok) === basename  (dirname (__FILE__))) {
    $basename = '';

    if (substr($strtok, -1) !== '/') {
        $basename = basename (dirname (__FILE__)).'/';
    }

    header (
        'Location: '.$basename.'default/default.png',
        true,
        301
    );

    exit ();
}

if (! file_exists ('.'.$strtok)) {
    $dirname = dirname ($strtok);

    while (! file_exists ('./'.$dirname.'/default')) {
        $dirname = dirname ($dirname);
    }

    if (! file_exists (__DIR__.'/default/'.$_GET['s'].'.png'))
        $_GET['s'] = 'default';

    header (
        'Location: '.$dirname.'/default/'.$_GET['s'].'.png',
        true,
        301
    );

    exit ();
}

$slash = '/';

if (substr ($strtok, -1) === '/') {
    $slash = '';
}

header (
    'Location: '.$strtok.$slash.$_GET['s'].'.png',
    true,
    301
);
