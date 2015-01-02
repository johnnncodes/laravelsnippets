<?php

use LaraSnipp\Repo\User\UserRepositoryInterface;
use LaraSnipp\Service\Form\User\UserForm;

class AuthController extends BaseController
{
    /**
     * User repository
     *
     * @var \LaraSnipp\Repo\User\UserRepositoryInterface
     */
    protected $user;

    /**
     * User form
     *
     * @var \LaraSnipp\Service\Form\User\UserForm
     */
    protected $userForm;

    public function __construct(UserRepositoryInterface $user, UserForm $userForm)
    {
        $this->user = $user;
        $this->userForm = $userForm;
    }

    /**
     * Show signup form
     * GET /signup
     */
    public function getSignup()
    {
        return View::make('auth.signup');
    }

    /**
     * Process signup form
     * POST /signup
     */
    public function postSignup()
    {
        if ($this->userForm->create(Input::all())) {
            return Redirect::route('auth.getLogin')
                ->with('message', 'Successfully registered. Please check your email and activate your account.')
                ->with('messageType', "success");
        }

        return Redirect::route('auth.getSignup')
            ->withInput()
            ->withErrors($this->userForm->errors());
    }

    /**
     * Activate account
     * GET /auth/activate/{slug}/key/{activation_key}
     */
    public function getActivateAccount($userSlug, $activationKey)
    {
        $user = $this->user->bySlug($userSlug);

        if ($user->isActive()) {
            return Redirect::route('home')
                ->with('message', 'This user account is already active.');
        }

        if ($user->activate($activationKey)) {
            Auth::login($user);

            return Redirect::route('home')
                ->with('message', 'Your account is now activated.')
                ->with('messageType', "success");
        } else {
            return Redirect::route('home')
                ->with('message', 'Invalid activation key.');
        }

    }

    /**
     * Show login form
     * GET /login
     */
    public function getLogin()
    {
        return View::make('auth.login');
    }

    /**
     * Process login
     * POST /login
     */
    public function postLogin()
    {
        $params = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'active' => 1
        );

        if (Auth::attempt($params)) {
            // if next is present, redirect to that url
            $next = Input::get('next');
            if ($next) return Redirect::to($next);
            return Redirect::route('home');
        }

        return Redirect::route('auth.getLogin')
            ->with('message', 'Wrong username or password')
            ->withInput();
    }

    /**
     * Process logout
     * GET /logout
     */
    public function getLogout()
    {
        Auth::logout();

        return Redirect::route('auth.getLogin');
    }
}
