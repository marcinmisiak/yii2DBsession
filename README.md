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

Example lat 5 min. login list:
```php
<?php
$query = MdlIstudentSession::find()
->andWhere(['>=', 'mdl_istudent_session.expire', time() + 60*5 ]);

$dpOstatnioZalogowani = new ActiveDataProvider([
		'query' => $query,
		'pagination' => [
				'pageSize' => 10,
		],
		'sort' => [
				'defaultOrder' => [
						'expire' => SORT_DESC,
		
				]
				]
		]
		);
		
echo yii\grid\GridView::widget([
    		'dataProvider' => $dpOstatnioZalogowani,
   		'layout'=>"{items}\n{pager}",
   		'columns'=> [ [ 'header'=>'',
   				'format'=>'raw',
   				'value' => function ($data) {
   		return Icon::show('user'). " ". $data->konto->imie ." " . $data->konto->nazwisko;
   	}
   		]]
      		]);
``` 
## Donations:
* Donation is as per your goodwill to support my development.
* If you are interested in my future developments, i would really appreciate a small donation to support this project.
* 
```html
My revolut acount
https://revolut.me/marcin1k25
```
[![Send mone to my revolut acount](https://revolut.me/marcin1k25)](https://revolut.me/marcin1k25)

