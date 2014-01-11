<?php namespace LaraSnipp\Service\Form\User;

use LaraSnipp\Service\Validation\ValidableInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;

class UserForm
{
    /**
     * Form Data
     *
     * @var array
     */
    protected $data;

    /**
     * Validator
     *
     * @var \LaraSnipp\Form\Service\ValidableInterface
     */
    protected $validator;

    /**
     * User repository
     *
     * @var \LaraSnipp\Repo\User\UserRepositoryInterface
     */
    protected $user;

    public function __construct(ValidableInterface $validator, UserRepositoryInterface $user)
    {
        $this->validator = $validator;
        $this->user = $user;
    }

    /**
     * Create a new user
     *
     * @return boolean
     */
    public function create(array $input)
    {
        if ( ! $this->valid($input)) {
            return false;
        }

        return $this->user->create($input);
    }

    /**
     * Return any validation errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

    /**
     * Test if form validator passes
     *
     * @return boolean
     */
    protected function valid(array $input)
    {
        return $this->validator->with($input)->passes();
    }

}
