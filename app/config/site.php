<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | URL Config
    |--------------------------------------------------------------------------
    */

    'url' => 'http://www.laravelsnippets.com',
    'url_short' => 'laravelsnippets.com',

    /*
    |--------------------------------------------------------------------------
    | Google Analytics Config
    |--------------------------------------------------------------------------
    */

    'ga_code' => 'UA-45609720-1',

    /*
    |--------------------------------------------------------------------------
    | Facebook Config
    |--------------------------------------------------------------------------
    */

    'facebook_url' => 'https://www.facebook.com/LaravelSnippets',
    'facebook_username' => 'laravelsnippets',

    /*
    |--------------------------------------------------------------------------
    | Twitter Config
    |--------------------------------------------------------------------------
    */

    'twitter_url' => 'https://twitter.com/laravelsnippets',
    'twitter_username' => 'laravelsnippets',
    'twitter_via' => 'LaravelSnippets #Laravel #snippet',

    /*
    |--------------------------------------------------------------------------
    | Header Config
    |--------------------------------------------------------------------------
    */
    'title' => 'LaravelSnippets.com',
    'meta_description' => 'A repository of useful code snippets for Laravel framework',
    'meta_author' => 'John Kevin M. Basco',

    /*
    |--------------------------------------------------------------------------
    | Footer Config
    |--------------------------------------------------------------------------
    */

    'footer_copyright' => '&copy; <a href="' . route('home') . '">laravelsnippets.com</a> by <a href="https://twitter.com/johnkevinmbasco" target="_blank">John Kevin M. Basco</a> | <a href="http://mayonvolcanosoftware.com/" target="_blank">Mayon Volcano Software Ltd.</a>',

    /*
    |--------------------------------------------------------------------------
    | Misc Config
    |--------------------------------------------------------------------------
    */

    'name' => 'Laravel Snippets',
    'welcome_message' => '<h1>Welcome to laravelsnippets.com</h1><p>A repository of useful code snippets for Laravel PHP framework. <a href="' . route('member.snippet.getCreate') . '">Submit</a>, grab and share!</p><p>Source code of the site - <a href="https://github.com/basco-johnkevin/laravelsnippets" target="_blank">Github link</a> . We accept pull requests! =)</p>',
    'repo_url' => '//github.com/basco-johnkevin/laravelsnippets',
    'mail_from' => 'basco.johnkevin@gmail.com',

    'snippetsPerPage' => 30

);
