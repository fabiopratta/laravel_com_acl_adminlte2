<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
	    'name' => 'required',
	    'email' => 'required|email|unique:users,email',
	    'password' => 'required|same:confirm-password',
	    'roles' => 'required'
    ];
}
