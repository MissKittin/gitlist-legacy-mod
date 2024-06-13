<?php

require __DIR__.'/vendor/autoload.php';

foreach (new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(__DIR__.'/src')
    ),
    '/.+((?<!Test)+\.php$)/i',
    RecursiveRegexIterator::GET_MATCH
) as $key => $file) {
    echo '[PRELOAD] '.$file[0].PHP_EOL;
    include $file[0];
}

foreach (new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(__DIR__.'/public')
    ),
    '/.+((?<!Test)+\.php$)/i',
    RecursiveRegexIterator::GET_MATCH
) as $key => $file) {
    echo '[PRELOAD] '.$file[0].PHP_EOL;
    opcache_compile_file($file[0]);
}


echo '[PRELOAD] '.__DIR__.'/boot.php'.PHP_EOL;
opcache_compile_file(__DIR__.'/boot.php');

echo '[PRELOAD] Included files: '.count(get_included_files()).PHP_EOL;
