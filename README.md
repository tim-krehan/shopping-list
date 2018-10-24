# Voraussetzungen
## Apache Moduls:
* php-rewrite
## Packages
* php7
* php7-mysql

# Beispiel Apache Config
```apache
<VirtualHost *:80>
        ServerAdmin webmaster@localhost

        DocumentRoot /var/www/html/shopping-list
        <Directory /var/www/html/shopping-list>
              AllowOverride All
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
# Installation
Um die Installation zu starten folgende Seite aufrufen:
[HOSTNAME]/install/install.php
