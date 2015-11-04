# eBot API

This is an API to interact with the popular CS:GO Match Manager [eBot](http://www.esport-tools.net/ebot/). It is still a work in progress, not to be used for production quite yet.

## Install

To get the API, you need to get [Composer](http://getcomposer.org). Once you have Composer installed, run `composer require team-reflex/ebot-api` in your project directory.  This will download the API so you can use it. 

## Usage

We are assuming that you have already imported the Composer autoload file into your project. If you have not done so, read the quick-start guide on the Composer website [here](http://getcomposer.org).

### Setting up

Firstly, you need to set up your config.

```php
<?php

use Reflex\Config;

$file_directory = __DIR__;
$file_name = '.env';

Config::loadEnv($file_directory, $file_name);
```

There is a config example available [here.](https://github.com/teamreflex/eBotAPI/blob/master/.env.example)

Afterwards, you should set up your capsule.

```php
use Reflex\Database\Capsule;

$capsule = new Capsule;
$capsule->addAndBoot('hostname', 'username', 'password', 'database', 'prefix');
```

Instead of `$capsule->addAndBoot()` you can also do the following:

```php
$capsule->addConnection('hostname', 'username', 'password', 'database', 'prefix');
$capsule->boot();
```

### Interacting with eBot

More information can be found on the wiki on the right.