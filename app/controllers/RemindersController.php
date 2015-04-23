<?php


class RemindersController extends Controller
{

    /**
     * Display the password reminder view.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRemind()
    {
        return View::make('password.remind');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return \Illuminate\Http\Response
     */
    public function postRemind()
    {
        switch ($response = Password::remind(Input::only('email'))) {
            case Password::INVALID_USER:
                return Redirect::route('password.remind')->with('message', 'Your email is invalid');

            case Password::REMINDER_SENT:
                return Redirect::route('password.remind')->with('message', 'The password reminder has been sent. Check your email')->with('messageType', "success");
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            App::abort(404);
        }

        return View::make('password.reset')->with('token', $token);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return \Illuminate\Http\Response
     */
    public function postReset()
    {
        $credentials = Input::only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;

            $user->save();
        });

        switch ($response) {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
                return Redirect::route('password.remind')->with('message', "Your password remind request has expired or is invalid. Please request another one.")
                    ->with('messageType', "warning");
            case Password::INVALID_USER:
                return Redirect::route('password.reset')->with('message', "Whoops something went terribily wrong! Please retry")
                    ->with('messageType', "danger");

            case Password::PASSWORD_RESET:
                return Redirect::route('auth.getLogin')->with('message', 'Password successfully updated. Now log in')->with('messageType', 'success');
        }
    }
}
