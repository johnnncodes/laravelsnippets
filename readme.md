## LaravelSnippets.com website

Live site - http://laravelsnippets.com/

Twitter - https://twitter.com/laravelsnippets

Facebook Page - https://www.facebook.com/LaravelSnippets

Don't forget to star this repository :) And feel free to fork it.

### Core Developers
- John Kevin M. Basco - https://twitter.com/johnkevinmbasco
- Christopher Pitt - https://twitter.com/followchrisp
- Ionut Tanasa - https://twitter.com/ionutz2k
- David Knight - https://twitter.com/davidnknight

### How to contribute?

#### Bug fixes
- Just fork the repository, apply your bug fix and send a pull request.

#### Features
- File an issue on this repo with a title that looks like this: [Proposal] Admin Dashboard.
- Once the proposal is approved you can go ahead and implement your proposal and send a pull request.

You can also contribute features by visiting the issues page on the repository, you'll see issues
tagged with "request", if you want to implement it, just leave a comment that you will implement it and
just send a pull request.

### Contributors

#### A huge thanks to these developers who contributed to the development of the site:
- Martin Dilling-Hansen
- Sercan Çakır
- Nico Romero Peñaredondo
- Davide Bellini

### Requirements

1. PHP 5.4
2. Redis

### Local Installation (Warning: Outdated)

1. Clone Repo

2. Add hostname in bootstrap/start.php for environment detection:

```PHP
<?php
$env = $app->detectEnvironment(array(

    'local' => array('JOHNs-MacBook-Pro.local'),

));
```

3. Create config/local/database.php and configure Mysql and Redis in database.php:

```PHP
<?php
return array(

    'default' => 'mysql',

    'connections' => array(

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'larasnipp',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

    ),

    'redis' => array(

        'cluster' => false,

        'default' => array(
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 1,
        ),

    ),

);
```

4. (OPTIONAL) Create config/local/app.php if you want to turn on the Profiler:

```PHP
<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => true,

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\CommandCreatorServiceProvider',
        'Illuminate\Session\CommandsServiceProvider',
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        'Illuminate\Routing\ControllerServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Illuminate\Foundation\Providers\KeyGeneratorServiceProvider',
        'Illuminate\Log\LogServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Foundation\Providers\MaintenanceServiceProvider',
        'Illuminate\Database\MigrationServiceProvider',
        'Illuminate\Foundation\Providers\OptimizeServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Foundation\Providers\PublisherServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Reminders\ReminderServiceProvider',
        'Illuminate\Foundation\Providers\RouteListServiceProvider',
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Foundation\Providers\ServerServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Foundation\Providers\TinkerServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Workbench\WorkbenchServiceProvider',

        // app specific
        'LaraSnipp\Repo\RepoServiceProvider',
        'LaraSnipp\Service\Form\FormServiceProvider',
        'LaraSnipp\Observer\ObserverServiceProvider',
        'LaraSnipp\LaraSnippServiceProvider',

        // 3rd party
        'Cviebrock\EloquentSluggable\SluggableServiceProvider',
        'Profiler\ProfilerServiceProvider',

    ),

    'aliases' => array(

        'App'             => 'Illuminate\Support\Facades\App',
        'Artisan'         => 'Illuminate\Support\Facades\Artisan',
        'Auth'            => 'Illuminate\Support\Facades\Auth',
        'Blade'           => 'Illuminate\Support\Facades\Blade',
        'Cache'           => 'Illuminate\Support\Facades\Cache',
        'ClassLoader'     => 'Illuminate\Support\ClassLoader',
        'Config'          => 'Illuminate\Support\Facades\Config',
        'Controller'      => 'Illuminate\Routing\Controllers\Controller',
        'Cookie'          => 'Illuminate\Support\Facades\Cookie',
        'Crypt'           => 'Illuminate\Support\Facades\Crypt',
        'DB'              => 'Illuminate\Support\Facades\DB',
        'Eloquent'        => 'Illuminate\Database\Eloquent\Model',
        'Event'           => 'Illuminate\Support\Facades\Event',
        'File'            => 'Illuminate\Support\Facades\File',
        'Form'            => 'Illuminate\Support\Facades\Form',
        'Hash'            => 'Illuminate\Support\Facades\Hash',
        'HTML'            => 'Illuminate\Support\Facades\HTML',
        'Input'           => 'Illuminate\Support\Facades\Input',
        'Lang'            => 'Illuminate\Support\Facades\Lang',
        'Log'             => 'Illuminate\Support\Facades\Log',
        'Mail'            => 'Illuminate\Support\Facades\Mail',
        'Paginator'       => 'Illuminate\Support\Facades\Paginator',
        'Password'        => 'Illuminate\Support\Facades\Password',
        'Queue'           => 'Illuminate\Support\Facades\Queue',
        'Redirect'        => 'Illuminate\Support\Facades\Redirect',
        'Redis'           => 'Illuminate\Support\Facades\Redis',
        'Request'         => 'Illuminate\Support\Facades\Request',
        'Response'        => 'Illuminate\Support\Facades\Response',
        'Route'           => 'Illuminate\Support\Facades\Route',
        'Schema'          => 'Illuminate\Support\Facades\Schema',
        'Seeder'          => 'Illuminate\Database\Seeder',
        'Session'         => 'Illuminate\Support\Facades\Session',
        'Str'             => 'Illuminate\Support\Str',
        'URL'             => 'Illuminate\Support\Facades\URL',
        'Validator'       => 'Illuminate\Support\Facades\Validator',
        'View'            => 'Illuminate\Support\Facades\View',

        // 3rd party
        'Sluggable' => 'Cviebrock\EloquentSluggable\Facades\Sluggable',
        'Profiler' => 'Profiler\Facades\Profiler',

    ),

);
```

5. (OPTIONAL) Create config/local/mail.php if you want to use the Python SMTP
    Debugger. Then run this command in the console:
        - python -m smtpd -n -c DebuggingServer localhost:1025

```PHP
<?php

return array(

    'driver' => 'smtp',

    'host' => 'localhost',

    'port' => 1025,

);
```

6. Run composer install to install dependencies
        - php composer.phar update --dev
        OR
        - composer update --dev

7. Migrate and Seed database
        - php artisan migrate --seed


### Running the tests

1. Create a test database and configure config/testing/database.php

2. Migrate and Seed database for testing
        - php artisan migrate --seed --env=testing

3. Run php vendor/bin/phpunit in the console




