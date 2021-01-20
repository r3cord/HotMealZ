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
</ul>

# Installation:
Before cloning/downloading repository from GitHub, you have to get and configure yourself Apache/nginx server with PHP and MySQL Database. All ready to use. You can find a lot of tutorials on the internet how to get and configure those things. When you have fulfilled all requirments, now you can download repository (Green button with the text "Code"). Download ZIP or clone repository with git. Put all files in the server folder. Create new database and user account in MySQL which you want to use with HotMealZ site. Open "database_config.php" with your favourite text editor and provide required informations.

database_config.php:
host = ip to your MySQL server
user = name of the user with privileges to database provided in "database"
password = password for user account provided in "user"
datanase = name of the database which you want to use with HotMealZ site

After that you have to import databes tables' template. With downloaded repository, you've downloaded db_hotmealz.sql file. Import this database with phpmyadmin or use shell command. Something like this -> "mysql -u <username> -p <databasename> < <db_hotmealz.sql>" (more information https://www.digitalocean.com/community/tutorials/how-to-import-and-export-databases-in-mysql-or-mariadb)

Voilà you are ready to go!
 
<br/><br/><br/>
Made with passion and without budget <3
