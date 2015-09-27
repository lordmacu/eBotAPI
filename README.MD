# eBot API

This is an API to interact with the popular CS:GO Match Manager [eBot](http://www.esport-tools.net/ebot/). It is still a work in progress, not to be used for production quite yet.

## Install

To get the API, you need to get [Composer](http://getcomposer.org). Once you have Composer installed, run `composer require team-reflex/ebot-api` in your project directory.  This will download the API so you can use it. 

Next, you need to add our service provider to your `config/app.php`. Add it in the `'providers'` section as the following:

```php
'providers' => [
	// ...
	Reflex\eBotServiceProvider::class
];
```

After you have added the service provider, run `php artisan vendor:publish` and the config file will be available under `config/ebot-reflex.php`.

## Usage

We are assuming that you have already imported the Composer autoload file into your project. If you have not done so, read the quick-start guide on the Composer website [here](http://getcomposer.org).

### Setting up

Firstly, you need to set up a capsule instance:

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