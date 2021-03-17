# RegattaTracker
The brand new RegattaTracker deluxe tracking system

## Test Environment Installation

### Windows
- Install [XAMPP](https://www.apachefriends.org/download.html) Apache web server, PHP and MySQL database
- Install [Composer](https://getcomposer.org/download/) PHP package manager
- Clone repo in the `C:/xampp/htdocs` folder
    ```
    cd C:/xampp/htdocs
    git clone https://github.com/IpsumCapra/regattatracker.git
    cd regattatracker
    ```
- Install deps via Composer
    ```
    cd server
    composer install
    ```
- Copy `server/.env.example` to `server/.env`
- Generate Laravel security key
    ```
    php artisan key:generate
    ```
- Register a [MapBox](https://www.mapbox.com/) account to get an MapBox access token, insert your token add the end of the `.env` file
    ```
    MAPBOX_ACCESS_TOKEN={ INSERT YOUR ACCESS TOKEN HERE }
    ```
- Add following lines to `C:/xampp/apache/conf/extra/httpd-vhosts.conf` file
    ```
    # RegattaTracker vhosts

    <VirtualHost *:80>
        ServerName regattatracker.local
        DocumentRoot "C:/xampp/htdocs/regattatracker/server/public"
    </VirtualHost>

    <VirtualHost *:80>
        ServerName www.regattatracker.local
        Redirect permanent / http://regattatracker.local/
    </VirtualHost>
    ```
- Add following lines to `C:/Windows/System32/drivers/etc/hosts` file **with administrator rights**
    ```
    # RegattaTracker local domains
    127.0.0.1 regattatracker.local
    127.0.0.1 www.regattatracker.local
    ```
- Start Apache and MySQL via XAMPP control panel
- Create MySQL user and database
- Fill in MySQL user, password and database information in `server/.env`
- Create database tables
    ```
    cd server
    php artisan migrate
    ```
- Goto http://regattatracker.local/ and you're done! 🎉

### macOS
TODO

### Linux

#### Ubuntu based distro's
- Install LAMP stack
    ```
    sudo apt install apache2 php php-dom mysql-server composer
    ```
-  Fix `/var/www/html` Unix rights hell
    ```
    # Allow Apache access to the folders and the files
    sudo chgrp -R www-data /var/www/html
    sudo find /var/www/html -type d -exec chmod g+rx {} +
    sudo find /var/www/html -type f -exec chmod g+r {} +

    # Give your owner read/write privileges to the folders and the files, and permit folder access to traverse the directory structure
    sudo chown -R $USER /var/www/html/
    sudo find /var/www/html -type d -exec chmod u+rwx {} +
    sudo find /var/www/html -type f -exec chmod u+rw {} +

    # Make sure every new file after this is created with www-data as the 'access' user.
    sudo find /var/www/html -type d -exec chmod g+s {} +
    ```
- Clone repo in the `/var/www/html` folder
    ```
    cd /var/www/html
    git clone https://github.com/IpsumCapra/regattatracker.git
    cd regattatracker
    ```
- Install deps via Composer
    ```
    cd server
    composer install
    ```
- Copy `server/.env.example` to `server/.env`
- Generate Laravel security key
    ```
    php artisan key:generate
    ```
- Register a [MapBox](https://www.mapbox.com/) account to get an MapBox access token, insert your token add the end of the `.env` file
    ```
    MAPBOX_ACCESS_TOKEN={ INSERT YOUR ACCESS TOKEN HERE }
    ```
- Create the file `/etc/apache2/sites-available/regattatracker.conf` **as root**
    ```
    # RegattaTracker vhosts

    <VirtualHost *:80>
        ServerName regattatracker.local
        DocumentRoot "/var/www/html/regattatracker/server/public"
    </VirtualHost>

    <VirtualHost *:80>
        ServerName www.regattatracker.local
        Redirect permanent / http://regattatracker.local/
    </VirtualHost>
    ```
- Enable the site
    ```
    sudo a2ensite regattatracker
    ```
- Edit this line in `/etc/apache2/apache2.conf` at `AllowOverride` from `None` to `All` **as root**
    ```
    <Directory /var/www/>
        ...
        AllowOverride All
        ...
    </Directory>
    ```
- Enable the Apache rewrite module
    ```
    sudo a2enmod rewrite
    ```
- Restart apache
    ```
    sudo service apache2 restart
    ```
- Add following lines to `/etc/hosts` file **as root**
    ```
    # RegattaTracker local domains
    127.0.0.1 regattatracker.local
    127.0.0.1 www.regattatracker.local
    ```
- Create MySQL user and database
- Fill in MySQL user, password and database information in `server/.env`
- Create database tables
    ```
    cd server
    php artisan migrate
    ```
- Goto http://regattatracker.local/ and you're done! 🎉

#### Arch based disto's (Not working yet)
- Install packages.
    ```
    # pacman -Sy
    # pacman -S apache php composer mariadb
    ```
- Setup mysql (mariadb) server.
    ```
    # mariadb-install-db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
    cd /srv/http
    ```
- Create a vhost document root, rename it to a domain name (e.g. regattadev.com)
    ```
    # git clone https://github.com/IpsumCapra/regattatracker.git
    # mv regattatracker your_domain
    # chown -R http http
    # chmod -R g+rwx http
    # cd your_domain
    # cd server
    # composer install
    ```
- Copy .env.example to .env.
- Check whether vhosts are enabled in the config. Add following to config file after enabling.
    ```
    # RegattaTracker vhosts

    <VirtualHost *:80>
        ServerName your_domain
        DocumentRoot "/srv/http/your_domain/server/public"
    </VirtualHost>

    <VirtualHost *:80>
        ServerName www.your_domain
        Redirect permanent / http://your_domain/
    </VirtualHost>
    ```
- Change AllowOverride on `/srv/http` from `None` to `All`.
    ```
    <Directory /var/www/>
        ...
        AllowOverride All
        ...
    </Directory>
    ```
- Enable PHP for apache.
- Add following lines to `/etc/hosts` file **as root**
    ```
    # RegattaTracker local domains
    127.0.0.1 your_domain
    127.0.0.1 www.your_domain
    ```
- Create MySQL user and database
- Fill in MySQL user, password and database information in `server/.env`
- Create database tables
    ```
    cd server
    php artisan migrate
    ```
- Everything should now be running under your chosen domain name! 🎉
