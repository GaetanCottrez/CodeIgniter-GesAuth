#GesAuth
###GesAuth is a User Authorization Library for CodeIgniter 2.x, which aims to make easy some essential jobs such as login, permissions and access operations for web application.
by [Gaëtan Cottrez](http://laviedunwebdeveloper.com/)

##Description
GesAuth is based on Aauth (https://github.com/emreakay/CodeIgniter-Aauth). Thank a lot to the author =).
I created this library about an example that serves as starter kit for a web application.
It contains a CRUD for managing users and groups with permissions generated with Grocery CRUD (https://github.com/scoumbourdis/grocery-crud).
It also contains a web application design generated via a custom bookstore (template.php) created by me.
The folder package contains all files to library GesAuth

##My philosophy: an example is better than a long documentation

##Learning opportunities GesAuth an example

 - Just copy the folder GesAuth in your localhost.
 - Create a new database gesauth and import file gesauth.sql
 - (Optionnal) Change parameter gesauth.application\config\database.php by your parameters
 - (Optionnal) Change parameter $config['language'] by french or english in gesauth.application\config\config.php by your parameters

 load GesAuth Library to system
```php
$this->load->library("GesAuth");
```
##Accounts user
```php
 - username / password / group / language : gaetan.cottrez / admin / Admin / french
 - username / password / group / language : john.doe / admin / default / english
```

##Demo
```php
 	http://gesauth.laviedunwebdeveloper.com/login
```

##Most important method
```php
 - login user : $this->gesauth->login($login,$password, $remember) => see controller login.php
 - error login : $this->gesauth->get_errors()  => see controller login.php
 - check user is login : $this->gesauth->is_loggedin()  => see library Template.php
 - update activity user login : $this->gesauth->update_activity()  => see library Template.php
 - control perms user : $this->gesauth->control()  => see library Template.php
```

##Future Features
 - Mode authentification LDAP
 - Choice of mode of MySQL or LDAP authentication or both

Dont forget to watch GesAuth.
You can also contribute and help me :)