<?php

if (substr($_SERVER['REQUEST_URI'], 0, 8) === '/avatars' && ! is_file(substr(strtok($_SERVER['REQUEST_URI'], '?'), 1))) {
    require __DIR__.'/public/avatars/index.php';
    exit();
}

if (file_exists(substr(strtok($_SERVER['REQUEST_URI'], '?'), 1)) && basename($_SERVER['SCRIPT_NAME']) !== '.htaccess') {
    switch (pathinfo(strtok($_SERVER['REQUEST_URI'], '?'), PATHINFO_EXTENSION)) {
        case 'js':
        case 'css':
            $mime='text/css';
        case 'ttf':
        case 'eot':
        case 'woff':
        case 'woff2':
        case 'otf':
        case 'svg':
        case 'png':
        case 'gif':
            if (!isset($mime)) {
                $mime=mime_content_type($_SERVER['SCRIPT_FILENAME']);
            }

            header('Content-Type: '.$mime);
            header('Pragma: cache');
            header('Cache-Control: max-age=31536000');

            readfile($_SERVER['SCRIPT_FILENAME']);
            exit();
    }

    return false;
}

require __DIR__.'/public/index.php';
