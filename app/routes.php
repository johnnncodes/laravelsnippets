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

/**
 * Website Routes
 */

# Homepage
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@getIndex']);

# Signup
Route::get('signup', ['as' => 'auth.getSignup', 'uses' => 'AuthController@getSignup']);
Route::post('signup', ['as' => 'auth.postSignup', 'uses' => 'AuthController@postSignup']);

# Login
Route::get('login', ['as' => 'auth.getLogin', 'uses' => 'AuthController@getLogin']);
Route::post('login', ['as' => 'auth.postLogin', 'uses' => 'AuthController@postLogin']);

# Logout
Route::get('logout', ['as' => 'auth.getLogout', 'uses' => 'AuthController@getLogout']);
Route::get('auth/activate/{userSlug}/key/{activationKey}', ['as' => 'auth.getActivateAccount', 'uses' => 'AuthController@getActivateAccount']);

/**
 * Snippet Routes
 */
Route::get('snippets', ['as' => 'snippet.getIndex', 'uses' => 'SnippetController@getIndex']);
Route::get('snippets/{slug}', ['as' => 'snippet.getShow', 'uses' => 'SnippetController@getShow']);
Route::get('snippets/{slug}/star', ['as' => 'snippet.star', 'uses' => 'SnippetController@starSnippet']);
Route::get('snippets/{slug}/unstar', ['as' => 'snippet.unStar', 'uses' => 'SnippetController@unstarSnippet']);

/**
 * Tag Routes
 */
Route::get('tags/{slug}', ['as' => 'tag.getShow', 'uses' => 'TagController@getShow']);

/**
 * Password Reset Routes
 */
Route::get('password/remind', ['as' => 'password.remind', 'uses' => 'RemindersController@getRemind']);
Route::post('password/remind', ['as' => 'password.remind', 'uses' => 'RemindersController@postRemind']);
Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'RemindersController@getReset']);
Route::post('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'RemindersController@postReset']);

/**
 * Profile Routes
 */
Route::get('profiles', ['as' => 'user.getIndex', 'uses' => 'UserController@getIndex']);
Route::get('profiles/{slug}', ['as' => 'user.getProfile', 'uses' => 'UserController@getProfile']);
Route::get('profiles/{slug}/snippets', ['as' => 'user.getSnippets', 'uses' => 'UserController@getSnippets']);

/**
 * Member Routes
 */
Route::group(
	['prefix' => 'members', 'before' => ['auth']],
	function () {

		# Dashboard
		Route::get('dashboard', ['as' => 'member.user.dashboard', 'uses' => 'Member\UserController@dashboard']);

		# Snippets
	    Route::get('snippets/{slug}', ['as' => 'member.snippet.getShow', 'uses' => 'Member\SnippetController@getShow']);
	    Route::get('snippets/{slug}/edit', ['as' => 'member.snippet.getEdit', 'uses' => 'Member\SnippetController@getEdit']);
	    Route::post('snippets/{slug}/update', ['as' => 'member.snippet.postUpdate', 'uses' => 'Member\SnippetController@postUpdate']);
	    Route::get('submit/snippet', ['as' => 'member.snippet.getCreate', 'uses' => 'Member\SnippetController@getCreate']);
	    Route::post('submit/snippet', ['as' => 'member.snippet.postStore', 'uses' => 'Member\SnippetController@postStore']);

});
