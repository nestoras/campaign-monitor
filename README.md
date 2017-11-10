Campaign Monitor
=========
Prerequisites
-------------

* PHP >= 7.1

Installation Procedure
----------------------
1. Extract file

2. Installing & Setting up the Symfony Framework
----------------------------
    HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
    sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
    Go to app/config and edit file parameters.yml. You need to define path parameter and make sure you have the correct rights(read,write)

3. Install Composer
-------------------
   In order to install composer, you must have already installed the curl command line tool and run this command as root to install the latest version.

   ```
   curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin
   ```

   *For Windows users you can run the following command (as long as php.exe is in your Path)

   ```
   php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
   ```
   and then type composer install

-------------------

4. Setup your nginx conf file(included)
5. Add vhost 127.0.0.1 www.campaignmonitor.dev
6. Run this command: php app/console assets:install --symlink