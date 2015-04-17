<?php namespace LaraSnipp\Service\Form\User;

use LaraSnipp\Service\Validation\AbstractLaravelValidator;

class UserFormLaravelValidator extends AbstractLaravelValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = [
        'creating' => [
            'username' => 'required|between:3,16|unique:users',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required'
        ],
        'updating' => [
            'password' => 'min:8|confirmed',
            'password_confirmation' => 'min:8',
            'first_name' => 'required',
            'last_name' => 'required',
            'twitter_url' => 'url',
            'facebook_url' => 'url',
            'github_url' => 'url',
            'website_url' => 'url'
        ]
    ];
}
