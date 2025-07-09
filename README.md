# Shoutout!
We use BrowserStack for cross-browser testing, as it provides full testing capabilities within one application.

[ ![BrowserStack](https://live.browserstack.com/favicon.ico) BrowserStack](https://www.browserstack.com)

# Recommendations
We strongly recommend using a `utf8mb4` database collation, as it has the best compatibility with emojis and other non-standard symbols. (You can't tell the end user they can't use emojis. Trust me, I tried.)

# Requirements

## Apache Modules:
* mod-rewrite

## Packages:
* php8
* php8-mysql

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

## Manual Installation

1. Create a new MySQL database. Please use `utf8_general_ci` as your collation.
2. Create a new MySQL user with permissions to modify the database.
3. Download the latest release:
   * [Tarball](https://github.com/tim-krehan/shopping-list/archive/refs/heads/master.tar.gz)
   * [ZIP](https://github.com/tim-krehan/shopping-list/archive/refs/heads/master.zip)
4. Unpack the archive and copy its contents to `/var/www/html/shopping-list`
5. Grant your web server permission to write the config file:
   ```bash
   chown www-data:www-data /var/www/html/shopping-list/config/config.php
   ```
6. Visit your server in a browser to begin the installation.
7. Enter your database credentials and create your login user.
8. That's it—you’re good to go! 🎉

## Helm Installation

You can now install the shopping list using Helm:

```bash
helm repo add shopping-list https://tim-krehan.github.io/shopping-list
helm repo update
helm install shopping-list shopping-list/shopping-list --create-namespace --namespace shopping-list
```

📄 An example `values.yaml` file can be found at:  
`charts/shopping-list/values.yaml`

⚠️ You must update the following variables in your Helm values file:
- `mysqlSecret.mysqlPassword`
- `mysqlSecret.mysqlRootPassword`
- `mysqlSecret.mysqlUser`
