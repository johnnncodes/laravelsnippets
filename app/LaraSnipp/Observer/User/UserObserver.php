<?php namespace LaraSnipp\Observer\User;

use LaraSnipp\Mailer\UserMailer;

class UserObserver
{
    /**
     * @var UserMailer
     */
    private $userMailer;

    /**
     * @param UserMailer $userMailer
     */
    public function __construct(UserMailer $userMailer)
    {
        $this->userMailer = $userMailer;
    }

    /**
     * Assign a role to the user that's being created (member by default)
     *
     * @param $user
     */
    public function creating($user)
    {
        // generate activation key for the user being created
        $user->activation_key = md5(uniqid(rand(), true));

        // @TODO: use a Role repository
        $role = \Role::where('name', 'member')->first();
        $user->role()->associate($role);
    }

    /**
     * When the user was created, send the activation email
     *
     * @param $user
     */
    public function created($user)
    {
        $this->userMailer->sendActivationEmail($user);
    }
}
