# RegattaTracker
The brand new RegattaTracker deluxe tracking system

## Database structure idea

### Users
- id
- firstname
- lastname
- email
- password
- role
    - 0: Normal
    - 1: Admin

### Boats
- id
- user_id
- name
- description
- api key

### boat_types
- id
- name

### boat_types_connection?
- boat_id
- boat_type_id

### boat_positions
- boat_id
- lat
- lng
- time

### buoys
- id
- name
- api key

### buoy_positions
- buoy_id
- lat
- lng
- time

## Installation

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
- Goto http://regattatracker.local/ and your done 🎉

### macOS
TODO

### Linux
TODO
