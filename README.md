# Shoutout!
We Use BrowserStack for cross browser testing, as it provides full testing capabillities within one application.

[ ![BrowserStack](https://live.browserstack.com/favicon.ico) BrowserStack](https://www.browserstack.com)


# Requirements

## Apache Modules:
* mod-rewrite

## Packages
* php7
* php7-mysql

# Sample Apache Config
```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName shopping.example.com

    DocumentRoot /var/www/html/shopping-list
    <Directory /var/www/html/shopping-list>

      	AllowOverride All
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

# Installation Instructions

* create a new mysql-database. Please use `utf8_general_ci` as your collation.
* create a new mysql-user that can edit the database.

* Download the latest release. You can download it [here (tar.gz)](https://gitlab.com/bluekay/shopping-list/-/archive/master/shopping-list-master.tar.gz) or [here (zip)](https://gitlab.com/bluekay/shopping-list/-/archive/master/shopping-list-master.zip)
* unpack the archive and copy its content to `/var/www/html/shopping-list`
* grant your web server permission to write the config-file
```bash
chown www-data:www-data /var/www/html/shopping-list/config/config.php
```
* visit the address of your web browser, you will be redirected to the installation page
* insert your database information and create your login user
* thats it, you are good to go. You may login now!
