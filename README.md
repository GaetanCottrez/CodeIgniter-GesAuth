#GesAuth

###GesAuth is a User Authorization Library for CodeIgniter 2.x and 3.x, which aims to make easy some essential jobs such as login, permissions and access operations for web application.
by [Gaëtan Cottrez](http://laviedunwebdeveloper.com/)

##Description

GesAuth is a fork to Aauth (https://github.com/emreakay/CodeIgniter-Aauth). Thank a lot to the author =).
I created this library about an example that serves as starter kit for a web application.
It contains a CRUD for managing users and roles with permissions generated with Grocery CRUD (https://github.com/scoumbourdis/grocery-crud).
It also contains a web application design generated via a custom bookstore (template.php) created by me.
The folder package contains all files to library GesAuth

##Latest release

GesAuth 2.0.1 (16/08/2015)

##What is new in version 2.0

 - Upgrade the library for a comptability with CodeIgniter 2.x and 3.x
 - Add new field in table user : login. login is the copy of field id. the field id becomes a real PRIMARY KEY
 - Add a new config : authentification with the email (just for the mode MySQL)
 - fix bug with the method login LDAP

##If you migrate Gesauth 1.X to 2.x

 - In your application, replace the file Gesauth.php in the folder libraries, gesauth_model.php in the folder models and gesauth_lang in your different folder languages.
 - Apply the file gesauth-migrate-version-1-to-2.sql in your database. My database have a prefix (gesauth_). Adapt the content in sql table names to be defined this works on your database.
 - The file sql add the field login and the field id PRIMARY KEY. It updates the table user_to_role with new id
 - If you use the field id of the table users with others table in your database, you must create your upgrade request on your tables yourself

##My philosophy

```sh
An example is better than a long documentation
```

##Requirements

 - This library use session in database, active this option in file config.php in the folder config

```php
$config['sess_use_database'] = TRUE;
```

 - If you use the LDAP connection, you need to enable the PHP extension on your LDAP server
 - Create all tables gesauth in your application, execute gesauth.sql in the folder package


##Learning opportunities GesAuth an example

 - Just copy the folder GesAuth in your localhost.
 - Create a new database gesauth and import file gesauth.sql
 - (Optionnal) Change parameter gesauth.application\config\database.php by your parameters
 - (Optionnal) Change parameter $config['language'] by french or english in gesauth.application\config\config.php by your parameters
 - Consult GesAuth library and config file to learn more

##Load GesAuth Library to system

```php
$this->load->library("GesAuth");
```

##Accounts user

```php
 - username / password / role / language : gaetan.cottrez / admin / Admin / french
 - username / password / role / language : john.doe / admin / default / english
```

##Demo

[http://gesauth.laviedunwebdeveloper.com/](http://gesauth.laviedunwebdeveloper.com/)

##Most important method
```php
 - login user : $this->gesauth->login($login,$password, $remember, $gesauth_mode) => see controller login.php
 - error login : $this->gesauth->get_errors()  => see controller login.php
 - check user is login : $this->gesauth->is_loggedin()  => see library Template.php
 - update activity user login : $this->gesauth->update_activity()  => see library Template.php
 - control perms user : $this->gesauth->control()  => see library Template.php
 - check status server LDAP : $this->gesauth->get_status_server() => see controller login.php
```

##History version

##What is new in version 1.1

 - Add logs authentification and perms in database
 - Check disabled user to
 - Deleting some unnecessary methods
 - Deleting users sessions where the browser was closed
 - Closing all sessions connected to the same users
 - Disconnect the user if the IP address has changed
 - Login form multi-language based on the browser language
 - Adding LDAP connection mode
 - Check status server LDAP
 - Adding the choice of connection type (MySQL and/or LDAP)
 - Improved dos protection
 - Adding logic error messages to the user

Dont forget to watch GesAuth.
You can also contribute and help me :
