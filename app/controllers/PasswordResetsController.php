<?php

class PasswordResetsController extends \BaseController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('password_resets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        Password::remind(['email' => Input::get('email')], function ($message) {
            $message->subject('Your Password Reminder');
        });

        if (Session::has('error')) {
            $message = 'Could not find user with that email address.';
            $messageType = "danger";
        } else {
            $message = 'Password reset e-mail sent!';
            $messageType = "success";
        }

        return Redirect::route('password_resets.create')->withMessage($message)->with("messageType", $messageType);
    }

    /**
     * Resets a newly created password in storage.
     *
     * @return Response
     */
    public function reset($token)
    {
        return View::make('password_resets.reset')->withToken($token);
    }

    /**
     * Stores a new reset password in storage.
     *
     * @return Response
     */
    public function postReset()
    {
        $creds = [
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'password_confirmation' => Input::get('password_confirmation')
        ];

        return Password::reset($creds, function ($user, $password) {
                $user->password = $password;
                $user->save();

                return Redirect::route('auth.getLogin');
        });
    }

}
