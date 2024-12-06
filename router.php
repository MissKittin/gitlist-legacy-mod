<?php

if (substr($_SERVER['REQUEST_URI'], 0, 10) === '/_avatars_' && ! is_file(substr(strtok($_SERVER['REQUEST_URI'], '?'), 1))) {
    require __DIR__.'/public/_avatars_/index.php';
    exit();
}

if (isset($_GET['raw']) && $_GET['raw'] === 'true') {
    $pos = strpos($_SERVER['REQUEST_URI'], '/blob/');

    if ($pos !== false) {
        header(
            'Location: '.substr_replace(strtok($_SERVER['REQUEST_URI'], '?'), '/raw/', $pos, 6),
            true,
            301
        );

        exit();
    }

    $pos = strpos($_SERVER['REQUEST_URI'], '/tree/');

    if ($pos !== false) {
        header(
            'Location: '.substr_replace(strtok($_SERVER['REQUEST_URI'], '?'), '/raw/', $pos, 6),
            true,
            301
        );

        exit();
    }

    $default_branch = 'master';
    $raw_path = explode('/', strtok($_SERVER['REQUEST_URI'], '?'));

    if (isset($raw_path[2]) && preg_match('/^[0-9a-f]{40}$/i', $raw_path[2]) === 1) {
        $raw_path[1] .= '/raw';
    } else {
        if (is_file(__DIR__.'/config.php')) {
            $config = require __DIR__.'/config.php';
        } elseif (is_file(__DIR__.'/config.ini')) {
            $config = parse_ini_file(__DIR__.'/config.ini');
        }

        if (isset($config['default_branch'])) {
            $default_branch = $config['default_branch'];
        }

        $raw_path[1] .= '/raw/'.$default_branch;
    }

    header(
        'Location: '.implode($raw_path, '/'),
        true,
        301
    );

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

if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    header('Content-Encoding: gzip');
    ob_start('ob_gzhandler');
}

require __DIR__.'/public/index.php';
