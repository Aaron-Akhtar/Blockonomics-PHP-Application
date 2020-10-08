# Blockonomics PHP Application
This is a web application developed in PHP that utilizes blockonomics.co's api to automate bitcoin payments.


Please follow these instructions for your merchant setup (Setting the callback URL):
```
1. Head over to https://www.blockonomics.co/ and login to your merchant account.
2. Navigate to https://www.blockonomics.co/merchants#/page3 and set the 'Account' property to the target wallet.
3. Set the 'HTTP Callback URL' to `domain.com/bitcoin/check.php?secret=your_secret_code`, replace `DOMAIN.COM` with your domain or ip address and replace `your_secret_code` with your unique secret code.
4. Press `Save Changes` and you are set.
```

To install this application on an Ubuntu machine please follow these instructions:

```
1. Update Packages: "apt update -y;"
2. Install Apache: "apt-get install apache2 -y;"
3. Install PHP & The MySQL Extention: "apt-get install php php-mysql -y;"
4. Move web assets to "/var/www/html" and access application via IP Address.
5. Edit config.php and set your blockonomics api key (https://blockonomics.co) into the '$apikey' variable and set your database information in the according positions in the '$conn' variable.
```

To setup the database please read the below documents on how to install phpmyadmin and a MySQL server:

(Ubuntu) MySQL Installation: https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-18-04

(Ubuntu) phpmyadmin Installation: https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-phpmyadmin-on-ubuntu-18-04 

(Ubuntu) Import Database (database.sql): https://www.inmotionhosting.com/support/website/databases/import-database-using-phpmyadmin/



https://www.blockonomics.co/views/api.html
