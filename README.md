# GitList mod: an elegant git repository viewer
GitList is an elegant and modern web interface for interacting with multiple git repositories.  
It allows you to browse repositories using your favorite browser, viewing files under different revisions, commit history, diffs.  
It also generates RSS feeds for each repository, allowing you to stay up-to-date with the latest changes anytime, anywhere.  
GitList was written in PHP, on top of the [Silex](http://silex.sensiolabs.org/) microframework and powered by the Twig template engine.  
This means that GitList is easy to install and easy to customize.  
Also, the GitList gorgeous interface was made possible due to [Bootstrap](http://twitter.github.com/bootstrap/).

## Features
* Multiple repository support
* Multiple branch support
* Multiple tag support
* Commit history, blame, diff
* RSS feeds
* Syntax highlighting
* Repository statistics

## Modifications
* Assets moved to public
* README.md has priority
* Added preload script
* Added router script
* Added assets cache for PHP CLI server
* Added local avatar provider

## Requirements
In order to run GitList on your server, you'll need:
* PHP 5.3+
* git
* Webserver (Apache, nginx, lighttpd, PHP cli-server)

## Installation
* Clone this repository to target directory:

		git clone --depth 1 "https://github.com/MissKittin/gitlist-legacy-mod.git" /var/www/gitlist

* Rename the `config.ini-example` file to `config.ini`.
* Open up the `config.ini` and configure your installation. You'll have to provide where your repositories are located.
* If you set `cache = true`, create the cache folder and give read/write permissions to your web server user:

		cd /var/www/gitlist
		mkdir cache
		chgrp www-data cache
		chmod 770 cache

* Configure the webserver to point to the `/var/www/gitlist/public` directory as document root

## Preloading
Add to `php.ini` file in opcache section:
```
[opcache]
opcache.preload=/var/www/gitlist/preload.php
```

## PHP built-in web server
```
cd /var/www/gitlist/public
php -d opcache.preload=/var/www/gitlist/preload.php -S 0.0.0.0:8080 ../router.php
```

## Local avatar provider
GitList uses Gravatar service by default to get avatar.  
You can use a local avatar provider instead.  
You need a square image in PNG format. Name it `original.png`  
Resize `original.png` to `32x32` and `40x40` px. Name them `32.png` and `40.png` respectively.
```
# create the hash (change my-email@domain.com)
hash=$(printf "my-email@domain.com" | tr '[:upper:]' '[:lower:]' | md5sum | awk '{print $1}')

# create avatar directory
cd /var/www/gitlist/public/avatars
mkdir $hash; cd $hash
ln -s ../default/index.php index.php
```
Drop the `original.png`, `32.png` and `40.png` files into the newly created directory.  
Set `url = '//gravatar.com/avatar/'` to `url = '/avatars/'` in `config.ini` (`[avatar]` section).

## Author
* [Klaus Silveira](http://www.klaussilveira.com) (Creator, developer)

## License
[New BSD license](http://www.opensource.org/licenses/bsd-license.php)
