# GitList mod: an elegant git repository viewer
GitList is an elegant and modern web interface for interacting with multiple git repositories.  
It allows you to browse repositories using your favorite browser, viewing files under different revisions, commit history, diffs.  
It also generates RSS feeds for each repository, allowing you to stay up-to-date with the latest changes anytime, anywhere.  
GitList was written in PHP, on top of the [Silex](https://github.com/silexphp/) microframework and powered by the Twig template engine.  
This means that GitList is easy to install and easy to customize.  
Also, the GitList gorgeous interface was made possible due to [Bootstrap](https://getbootstrap.com/2.3.2/).

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
* Added assets cache and compression for PHP CLI server
* Added local avatar provider
* Added dark theme
* Added smaller tabs CSS tweak
* Hidden GitList version in themes and RSS
* Extracted favicon
* Added Browse code button in commits list
* Added pre for Markdown if JavaScript is disabled
* All commit diffs are hidden
* Enabled github compatible header id in Showdown

## Original version
If you want the original build, see the Initial commit (`d62df2a047a00eb187e4a03237eeb8dd24c3f8e1`)  
and if you want the original source code, see branch `original`.

## Requirements
In order to run GitList on your server, you'll need:
* PHP 5.3+
* git
* Webserver (Apache, nginx, lighttpd, PHP cli-server)

## Installation
See [INSTALL](INSTALL.md)

## Author
* [Klaus Silveira](http://www.klaussilveira.com) (Creator, developer)

## License
[New BSD license](http://www.opensource.org/licenses/bsd-license.php)
