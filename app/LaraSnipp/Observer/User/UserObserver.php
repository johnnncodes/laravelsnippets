<?php namespace LaraSnipp\Observer\User;

use Config;

class UserObserver
{
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
        $this->_sendActivationEmail($user);
    }

    /**
     * Sends the activation email to the newly created user
     *
     * @param $user
     * @return mixed
     */
    private function _sendActivationEmail($user)
    {
        // @NOTE: not sure, but maybe transfer this mail sending logic to a service?
        // @TODO: Dedicated mailer class maybe? (ionut)
        $data = array(
            'user' => $user,
            'activationUrl' => route('auth.getActivateAccount', array($user->slug, $user->activation_key))
        );

        return \Mail::send('emails.auth.activate', $data, function ($message) use ($user) {
            $message->from(Config::get('site.mail_from'), Config::get('site.name'));
            $message->to($user->email, $user->full_name)->subject('Activate your account!');
        });
    }
}
