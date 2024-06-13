<?php

/**
 * GitList: an elegant and modern git repository viewer
 * http://gitlist.org
 */

if (!ini_get('date.timezone')) {
    date_default_timezone_set('UTC');
}

chdir(__DIR__.'/..');

require 'vendor/autoload.php';

$config = GitList\Config::fromFile('config.ini');

if ($config->get('app', 'cache') === '1' && !is_writable(__DIR__ . DIRECTORY_SEPARATOR . 'cache')) {
    die(sprintf('The "%s" folder must be writable for GitList to run.', __DIR__ . DIRECTORY_SEPARATOR . 'cache'));
}

if ($config->get('date', 'timezone')) {
    date_default_timezone_set($config->get('date', 'timezone'));
}

$app = require 'boot.php';
$app->run();

