<?php namespace LaraSnipp\Mailer;

abstract class Mailer
{
    /**
     * @param $user
     * @param $subject
     * @param $view
     * @param $data
     */
    public function sendTo($user, $subject, $view, $data = [])
    {
        \Mail::queue($view, $data, function ($message) use ($user, $subject) {
            $message->from(\Config::get('site.mail_from'), \Config::get('site.name'));
            $message->to($user->email, $user->full_name)->subject($subject);
        });
    }
}
