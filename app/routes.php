<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('uses' => 'HomeController@getIndex',
    'as' => 'home'));

Route::get('signup', array('uses' => 'AuthController@getSignup',
    'as' => 'auth.getSignup'));
Route::post('signup', array('uses' => 'AuthController@postSignup',
    'as' => 'auth.postSignup'));

Route::get('login', array('uses' => 'AuthController@getLogin',
    'as' => 'auth.getLogin'));
Route::post('login', array('uses' => 'AuthController@postLogin',
    'as' => 'auth.postLogin'));

Route::get('logout', array('uses' => 'AuthController@getLogout',
    'as' => 'auth.getLogout'));

Route::get('auth/activate/{userSlug}/key/{activationKey}', array('uses' => 'AuthController@getActivateAccount',
    'as' => 'auth.getActivateAccount'));

Route::get('snippets', array('uses' => 'SnippetController@getIndex',
    'as' => 'snippet.getIndex'));
Route::get('snippets/{slug}', array('uses' => 'SnippetController@getShow',
    'as' => 'snippet.getShow'));
Route::get('snippets/{slug}/star', array('uses' => 'SnippetController@starSnippet',
    'as' => 'snippet.star'));
Route::get('snippets/{slug}/unstar', array('uses' => 'SnippetController@unstarSnippet',
    'as' => 'snippet.unStar'));

Route::get('tags/{slug}', array('uses' => 'TagController@getShow',
    'as' => 'tag.getShow'));

// Password Resets
Route::get('password/remind', array('as' => 'password.remind', 'uses' => 'RemindersController@getRemind'));
Route::post('password/remind', array('as' => 'password.remind', 'uses' => 'RemindersController@postRemind'));
Route::get('password/reset', array('as' => 'password.reset', 'uses' => 'RemindersController@getReset'));
Route::post('password/reset/{token}', array('as' => 'password.reset', 'uses' => 'RemindersController@postReset'));

// profile
Route::get('profiles', array('uses' => 'UserController@getIndex',
    'as' => 'user.getIndex'));
Route::get('profiles/{slug}', array('uses' => 'UserController@getProfile',
    'as' => 'user.getProfile'));
Route::get('profiles/{slug}/snippets', array('uses' => 'UserController@getSnippets',
    'as' => 'user.getSnippets'));

// members
Route::group(array('prefix' => 'members', 'before' => array('auth')), function () {
    Route::get('snippets/{slug}', array('uses' => 'Member\SnippetController@getShow',
        'as' => 'member.snippet.getShow'));
    Route::get('snippets/{slug}/edit', array('uses' => 'Member\SnippetController@getEdit',
        'as' => 'member.snippet.getEdit'));
    Route::post('snippets/{slug}/update', array('uses' => 'Member\SnippetController@postUpdate',
        'as' => 'member.snippet.postUpdate'));

    Route::get('submit/snippet', array('uses' => 'Member\SnippetController@getCreate',
        'as' => 'member.snippet.getCreate'));
    Route::post('submit/snippet', array('uses' => 'Member\SnippetController@postStore',
        'as' => 'member.snippet.postStore'));

    Route::get('dashboard', array('uses' => 'Member\UserController@dashboard',
        'as' => 'member.user.dashboard'));
});
