<?php

const CONFIG_INI_TRUE = '1';
const CONFIG_INI_FALSE = '';

return array(
    'git' => array(
        'client' => '/usr/bin/git', // Your git executable path
        //'client' => '"C:\Program Files (x86)\Git\bin\git.exe"', // Your git executable path (windows)
        'default_branch' => 'master', // Default branch when HEAD is detached
        'repositories' => array( // Path to your repositories
            '/home/git/repositories/' // If you wish to add more repositories, just add a new line
            //'C:\Path\to\Repos\' // If you wish to add more repositories, just add a new line (windows)
        ),
        'strip_dot_git' => CONFIG_INI_FALSE, // Remove usual bare repo .git extension from displayed name
        'hidden' => array( // You can hide repositories from GitList, just copy this for each repository you want to hide or add a regex (including delimiters), eg. hidden[] = '/(.+)\.git/'
            //'/home/git/repositories/BetaTest'
        )
    ),
    'app' => array(
        'cache' => CONFIG_INI_FALSE,
        'cache_homepage' => CONFIG_INI_FALSE, // Remove cache/index.html to refresh
        'theme' => 'default',
        'title' => ''
    ),
    'clone_button' => array(
        'show_ssh_remote' => CONFIG_INI_FALSE, // display remote URL for SSH
        'ssh_host' => '', // host to use for cloning via HTTP (default: none => uses gitlist web host)
        'ssh_url_subdir' => '', // if cloning via SSH is triggered using special dir (e.g. ssh://example.com/git/repo.git), has to end with trailing slash
        'ssh_port' => '', // port to use for cloning via SSH (default: 22 => standard ssh port)
        'ssh_user' => 'git', // user to use for cloning via SSH
        'ssh_user_dynamic' => CONFIG_INI_FALSE, // when enabled, ssh_user is set to $_SERVER['PHP_AUTH_USER']
        'show_http_remote' => CONFIG_INI_FALSE, // display remote URL for HTTP
        'http_host' => '', // host to use for cloning via HTTP (default: none => uses gitlist web host)
        'use_https' => CONFIG_INI_TRUE, // generate URL with https://
        'http_url_subdir' => 'git/', // if cloning via HTTP is triggered using virtual dir (e.g. https://example.com/git/repo.git), has to end with trailing slash
        'http_user' => '', // user to use for cloning via HTTP (default: none)
        'http_user_dynamic' => CONFIG_INI_FALSE // when enabled, http_user is set to $_SERVER['PHP_AUTH_USER']
    ),
    'filetypes' => array( //If you need to specify custom filetypes for certain extensions, do this here
        //'extension' => 'type',
        //'dist' => 'xml'
    ),
    'binary_filetypes' => array( // If you need to set file types as binary or not, do this here
        //'extension' => CONFIG_INI_TRUE,
        //'svh' => CONFIG_INI_FALSE,
        //'map' => CONFIG_INI_TRUE
    ),
    'date' => array( // set the timezone
        //'timezone' => 'UTC',
        //'format' => 'd/m/Y H:i:s'
    ),
    'avatar' => array( // custom avatar service
        //'url' => '//gravatar.com/avatar/',
        //'query' => array(
        //    'd=identicon'
        //)
    )
);
