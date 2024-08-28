<?php

if (substr($_SERVER['REQUEST_URI'], 0, 8) === '/avatars' && ! is_file(substr(strtok($_SERVER['REQUEST_URI'], '?'), 1))) {
    require __DIR__.'/public/avatars/index.php';
    exit();
}

if (is_file(substr(strtok($_SERVER['REQUEST_URI'], '?'), 1)) && basename($_SERVER['SCRIPT_NAME']) !== '.htaccess') {
    $compress=false;

    switch (pathinfo(strtok($_SERVER['REQUEST_URI'], '?'), PATHINFO_EXTENSION)) {
        case 'css':
            $mime = 'text/css';
        case 'js':
        case 'ttf':
        case 'otf':
        case 'svg':
            $compress = true;
        case 'eot':
        case 'woff':
        case 'woff2':
        case 'png':
        case 'gif':
            if (!isset($mime)) {
                $mime = mime_content_type($_SERVER['SCRIPT_FILENAME']);
            }

            header('Content-Type: '.$mime);
            header('Pragma: cache');
            header('Cache-Control: max-age=31536000');

            if ($compress && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
                header('Content-Encoding: gzip');
                ob_start('ob_gzhandler');
            }

            readfile($_SERVER['SCRIPT_FILENAME']);
            exit();
    }

    return false;
}

require __DIR__.'/public/index.php';
