<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request) {
    if (App::environment() === 'production') {

        $client = new Raven_Client(Config::get('app.sentryDsn'));

        $error_handler = new Raven_ErrorHandler($client);

        // Register error handler callbacks
        set_error_handler(array($error_handler, 'handleError'));
        set_exception_handler(array($error_handler, 'handleException'));
    }
});

App::after(function ($request, $response) {
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function ($route, $request, $message = '', $nextUrl = '') {
    if (Auth::guest()) {
        if ($message) {
            return Redirect::route('auth.getLogin', array('next' => $nextUrl))->with('message', $message);
        }

        return Redirect::route('auth.getLogin');
    }
});

Route::filter('admin', function ($route, $request) {
    if (!Auth::user()->isAdmin()) {
        return App::abort(401, 'You are not authorized.');
    }
});

Route::filter('auth.basic', function () {
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
