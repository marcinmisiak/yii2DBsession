Use session to get login users list
===================================
Use session to get login users list. We have model: user_id = user->getId()

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist marcinmisiak/yii2-dbsession "*"
```

or add

```
"marcinmisiak/yii2-dbsession": "*"
```

to the require section of your `composer.json` file.

After install create session table in your DB, MySQL eg:

CREATE TABLE IF NOT EXISTS `mdl_istudent_session` (
  `id` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_activity` datetime NOT NULL,
  `last_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

Example table name: mdl_istudent_session

Fields:
id - sesssion id
expire - wher sesson end
data - session data
user_id - User id get from User model - function \Yii::$app->user->getId();
last_activity - last acvivito of user in fromat Y-m-d H:i:s
last_ip - user IP of session login

In config/web.php add:

..............
'components' => [
...

'session' => [
    			'class' => 'marcinmisiak\dbsession\Sesja',
    			'db' => 'dbmoodle',  // the application component ID of the DB connection. Defaults to 'db'.
    			'sessionTable' => 'mdl_istudent_session', // session table name. Defaults to 'session'.
    		//	'timeout' => 60*30,
    		//	'gCProbability' => 50, procent szans ze czyscimy tabele dbsession domysle 1
    	],
    	...
 ]
..................

Where:
  db  - session database, it's could be difren or the same of naim DB
  sessionTable - Session table
  timeout - auto logoff user atret seconds. If not set yii2 will use rememberMe - from login view
  gCProbability - clenup table of session will run 1% script execution, if you what have cleaner table (becouse you have to many records) you can set 50  	

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \marcinmisiak\dbsession\AutoloadExample::widget(); ?>```