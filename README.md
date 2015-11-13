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


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \marcinmisiak\dbsession\AutoloadExample::widget(); ?>```