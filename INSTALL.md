# GitList installation
* If you want to install GitList in `/var/www`, clean this directory first
* Clone this repository to target directory:

		git clone --depth 1 "https://github.com/MissKittin/gitlist-legacy-mod.git" /var/www

* Rename the `config.ini-example` file to `config.ini`.
* Open up the `config.ini` and configure your installation. You'll have to provide where your repositories are located.
* If you set `cache = true`, create the cache folder and give read/write permissions to your web server user:

		cd /var/www
		mkdir cache
		chgrp www-data cache
		chmod 770 cache

* Set file permissions for `.htaccess`:

		cd /var/www
		chmod 644 public/.htaccess
		chmod 644 public/_avatars_/.htaccess

* Configure the webserver to point to the `/var/www/public` directory as document root

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


# Webserver configuration
Apache is the "default" webserver for GitList.  
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
        # if you're using php5-fpm via tcp
        fastcgi_pass 127.0.0.1:9000;

        # if you're using php5-fpm via socket
        #fastcgi_pass unix:/var/run/php5-fpm.sock;

        include /etc/nginx/fastcgi_params;
    }
    location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
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
```
# GitList is located in /var/www
server.document-root        = "/var/www/public"

url.rewrite-once = (
    "^/favicon\.ico$" => "$0",
    "^/_avatars_/(/[^\?]*)(\?.*)?" => "/_avatars_/index.php$1$2"
    "^/(/[^\?]*)(\?.*)?" => "/index.php$1$2"
)
```

### hiawatha (not tested)
```
UrlToolkit {
    ToolkitID = gitlist
    RequestURI isfile Return
    Match ^/_avatars_/.* Rewrite /_avatars_/index.php
    Match ^/.* Rewrite /index.php
}
```
