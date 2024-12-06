<?php

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
        if (is_file(__DIR__.'/../config.php')) {
            $config = require __DIR__.'/../config.php';
        } elseif (is_file(__DIR__.'/../config.ini')) {
            $config = parse_ini_file(__DIR__.'/../config.ini');
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

/**
 * GitList: an elegant and modern git repository viewer
 * http://gitlist.org
 */

if (!ini_get('date.timezone')) {
    date_default_timezone_set('UTC');
}

chdir(__DIR__.'/..');

require 'vendor/autoload.php';

if (file_exists('./config.php')) {
    $config = GitList\Config::fromPhpFile('./config.php');
} else {
    $config = GitList\Config::fromFile('config.ini');
}

if (($config->get('app', 'cache') === '1') && (!is_writable('.' . DIRECTORY_SEPARATOR . 'cache'))) {
    die(sprintf('The "%s" folder must be writable for GitList to run.', __DIR__ . DIRECTORY_SEPARATOR . 'cache'));
}

if ($config->get('date', 'timezone')) {
    date_default_timezone_set($config->get('date', 'timezone'));
}

// Startup and configure Silex application
$app = new GitList\Application($config, __DIR__.'/..');

// Mount the controllers
$app->mount('', new GitList\Controller\MainController($app, $config));
$app->mount('', new GitList\Controller\BlobController());
$app->mount('', new GitList\Controller\CommitController());
$app->mount('', new GitList\Controller\TreeController());
$app->mount('', new GitList\Controller\NetworkController());
$app->mount('', new GitList\Controller\TreeGraphController());

$app->run();
