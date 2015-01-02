<?php namespace LaraSnipp\Service\Form\User;

use LaraSnipp\Service\Validation\ValidableInterface;
use LaraSnipp\Repo\User\UserRepositoryInterface;
use User;

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
     * @param array $input
     * @return boolean
     */
    public function create(array $input)
    {
        if (!$this->valid($input, 'creating')) {
            return false;
        }

        return $this->user->create($input);
    }

    /**
     * Updates an existent user
     *
     * @param $user
     * @param array $input
     * @return bool
     */
    public function update($user, array $input)
    {
        if (!$this->valid($input, 'updating')) {
            return false;
        }
        return $this->user->update($user, $input);
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
     * @param array $input
     * @param $mode : creating || updating
     * @return bool
     */
    protected function valid(array $input, $mode)
    {
        return $this->validator->with($input)->passes($mode);
    }
}
