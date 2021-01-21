# HotMealZ
A simple site which allows to distribute food from restaurants. Easy to use with minimalistic design.

# Used technologies:
<ul>
<li>HTML</li>
<li>CSS</li>
<li>PHP</li>
<li>SQL</li>
</ul>

# Requirements:
<ul>
<li>PHP 7.4</li>
<li>MySQL Database</li>
<li>Apache/nginx server</li>
<li>(optional, but very helpful) phpMyAdmin</li>
</ul>

# Installation:
Before cloning/downloading repository from GitHub, you have to get and configure yourself Apache/nginx server with PHP and MySQL Database. All ready to use. You can find a lot of tutorials on the internet how to get and configure those things. When you have fulfilled all requirments, now you can download repository (Green button with the text "Code"). Download ZIP or clone repository with git. Put all files in the server folder. Create new database and user account in MySQL which you want to use with HotMealZ site. After that you have to import database tables' template. With downloaded repository, you've downloaded db_hotmealz.sql file. Import this database with phpmyadmin or use shell command. Something like this -> "mysql -u <username> -p <databasename> < <db_hotmealz.sql>" (more information https://www.digitalocean.com/community/tutorials/how-to-import-and-export-databases-in-mysql-or-mariadb). *DON'T FORGET TO REMOVE db_hotmealz.sql AFTER IMPORT.* Open "database_config.php" with your favourite text editor and provide required information.

database_config.php:
<ul>
<li>host = ip to your MySQL server</li>
<li>user = name of the user with privileges to database provided in "database"</li>
<li>password = password for user account provided in "user"</li>
<li>database = name of the database which you want to use with HotMealZ site</li>
</ul>

 When you've done it, next step is to add new admin account. In your browser go to yourdomain.com/admin.php and login with default email and password. (If you can't access your site, basic troubleshooting with common errors is below) 
</br>Login: admin@admin.com
</br>Password: Admintemplate123
</br>Then click "Dodaj konto administratora" button, provide required information and click "Dodaj administratora". After that you have to delete default admin account to prevent exploits. Click "Zarządzaj kontami" and in the table named "KONTA ADMINISTRATORÓW" click "Usuń konto" in the same row with admin@admin.com. You can't delete default admin account before adding new admin account. 
</br>Instalation is almost done! The last step is to add regions to your database. You have to do it manually. Login to phpmyadmin or mysql and add new record with structure like this -> "id" (auto increment) "name" (region name). And you are done!

# Troubleshooting
Common errors with database_config.php.
<ul>
<li>SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: YES)Database <- You've provided wrong username/password or specified user does not have privileges to database</li>
<li>SQLSTATE[HY000] [1049] Unknown database 'db_hotmealzzzz'Database error <- Specified database does not exist</li>
<li>SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: Unknown host. Database error <- Specified host is not correct, check provided ip</li>
<li>SQLSTATE[HY000] [2002] Connection refused <- Your port to database is closed, open it to fix this problem</li>
</ul>


# Voilà! You are ready to go!
Made with passion and without budget <3
