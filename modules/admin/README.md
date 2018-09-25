Docotel CMS
===========
RBAC, CMS

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either add

```
"docotel/yii2-dcms": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
"repositories": [
   {
        "type": "package",
        "package": {
            "name": "docotel/yii2-dcms",
            "version": "1.0",
            "type": "yii2-extension",
            "source": {
                "url": "http://gitlab.docotel.net/docotel/yii2-dcms.git",
                "type": "git",
                "reference": "master"
            },
            "require": {
                "yiisoft/yii2": "*"
            },
            "autoload": {
                "psr-4": {
                    "docotel\\dcms\\": ""
                }
            }
        }
    }
]


For authentication is via an `auth.json` file
located in your `COMPOSER_HOME` or besides your `composer.json`.

```php
{
    "http-basic": {
        "gitlab.docotel.net": {
            "username": "my-username1",
            "password": "my-secret-password1"
        }
    }
}