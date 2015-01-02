<?php namespace LaraSnipp\Mailer;

class UserMailer extends Mailer
{
    /**
     * @param User $user
     */
    public function sendActivationEmail($user)
    {
        $data = array(
            'user' => $user,
            'activationUrl' => route('auth.getActivateAccount', array($user->slug, $user->activation_key))
        );
        $subject = 'Please activate your account';
        $view = 'emails.auth.activate';

        return $this->sendTo($user, $subject, $view, $data);
    }
}
