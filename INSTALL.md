# GitList installation
* If you want to install GitList in `/var/www`, clean this directory first  
	if you are using Apache, configure the public directory to `/var/www/public` and disable ignoring `.htaccess` files:

		# in /etc/apache2/sites-available/000-default.conf
		DocumentRoot /var/www/public

		# in /etc/apache2/apache2.conf
		<Directory /var/www/>
			#something
			AllowOverride All
			#something
		</Directory>

* Download zipball or clone this repository to target directory:

		git clone --depth 1 "https://github.com/MissKittin/gitlist-legacy-mod.git" /var/www

* Rename the `config.ini-example` file to `config.ini`.
* Open up the `config.ini` and configure your installation. You'll have to provide where your repositories are located.
* If you set `cache = true`, create the cache folder and give read/write permissions to your web server user:

		cd /var/www
		mkdir cache
		chgrp www-data cache
		chmod 770 cache

* You can also enable the repository list cache (`cache_homepage = true`). To invalidate the cache, remove `cache/index.html`.
* Set file permissions for `.htaccess`:

		cd /var/www
		chmod 644 public/.htaccess
		chmod 644 public/_avatars_/.htaccess

* Configure the webserver to point to the `/var/www/public` directory as document root

### Configuration via PHP script
Instead of `config.ini` you can use `config.php`.  
The advantage of this solution is the ability to cache the configuration via OPcache.  
The `config.php` file always takes precedence over the `config.ini`.  
If you set OPcache to not check if php files have been modified, it will always load compiled code - and that's the point.

* Rename the `config-example.php` file to `config.php`.
* Open up the `config.php` and configure your installation. You'll have to provide where your repositories are located.

### Preloading
Add to `php.ini` file in `[opcache]` section:
```
[opcache]
opcache.preload=/var/www/preload.php
```

### PHP built-in web server
If you see strange behavior after entering `router.php` in the url, rename `router.php` or play around with mktemp and sed
```
cd /var/www/public
php -d opcache.preload=/var/www/preload.php -S 0.0.0.0:8080 ../router.php
```

### Local avatar provider
GitList uses Gravatar service by default to get avatar.  
You can use a local avatar provider instead.  
You need a square image in PNG format. Name it `original.png`  
Resize `original.png` to `32x32` and `40x40` px. Name them `32.png` and `40.png` respectively and move to a new directory.  
Run:
```
php /var/www/gitlist/bin/mkavatar.php "my-email@domain.com" ./new-directory
```
Set `url = '//gravatar.com/avatar/'` to `url = '/_avatars_/'` in `config.ini` (`[avatar]` section).

### Updating GitList
If you want to be able to update GitList, your only option is to clone the repository.  
All you need to do is execute the command from time to time (e.g. via cron):
```
git -C /var/www pull --ff-only
# optionally you can
git -C /var/www reset --hard
```
but be careful: if you do `git clean `, you will lose your configuration files.


# Webserver configuration
Apache is the "default" webserver for GitList.  
You need to `a2enmod rewrite`  
You will find the configuration inside the `public/.htaccess` and `public/_avatars_/.htaccess` files.  
However, nginx and lighttpd are also supported.

### nginx server.conf
```
server {
    server_name MYSERVER;
    access_log /var/log/nginx/MYSERVER.access.log combined;
    error_log /var/log/nginx/MYSERVER.error.log error;

    root /var/www/public;
    index index.php;

#   auth_basic "Restricted";
#   auth_basic_user_file .htpasswd;

    location = /robots.txt {
        allow all;
        log_not_found off;
        access_log off;
    }

    location / {
        try_files $uri @gitlist;
    }
    location /_avatars_ {
        try_files $uri @avatars;
    }

    location ~ \.php$ {
		include snippets/fastcgi-php.conf;

        # if you're using php5-fpm via tcp
        fastcgi_pass 127.0.0.1:9000;

        # if you're using php5-fpm via socket
        #fastcgi_pass unix:/var/run/php/php5-fpm.sock;
    }
    location ~* \.(css|js|ttf|otf|svg|eot|woff|woff2|png|gif)$ {
        add_header Vary "Accept-Encoding";
        expires max;
        try_files $uri @gitlist;
        tcp_nodelay off;
        tcp_nopush on;
    }

#   location ~* \.(git|svn|patch|htaccess|log|route|plist|inc|json|pl|po|sh|ini|sample|kdev4)$ {
#       deny all;
#   }

    location @gitlist {
        rewrite ^/.*$ /index.php;
    }
    location @avatars {
        rewrite ^/.*$ /_avatars_/index.php;
    }
}
```

### lighttpd
You need to `lighttpd-enable-mod fastcgi-php-fpm`  
and `lighttpd-enable-mod redirect`

```
# GitList is located in /var/www
server.document-root = "/var/www/public"

url.rewrite-if-not-file = (
    "^/_avatars_/(.*)" => "/_avatars_/index.php/$1"
)
url.rewrite-once = (
    "^/_themes_/(.*)" => "/_themes_/$1",
    "^/(?!_avatars_).*" => "/index.php/$1"
)
```
