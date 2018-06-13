<?php
/**
 * @file           UserService.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @copyright      Copyright - sagp | 06/06/2018
 * @since 06/06/2018
 */

namespace App\Services;


use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService {

	/**
	 * @var UserRepository
	 */
	protected $repository;


	/**
	 * @var UserValidator
	 */
	protected $validator;


	/**
	 * UserService constructor.
	 *
	 * @param UserRepository $user_repository
	 */
	public function __construct(UserRepository $user_repository, UserValidator $validator) {
		$this->validator = $validator;
		$this->repository = $user_repository;
	}



	public function store(array $data)
	{
		try{
			$this->validator->with($data)->passesOrFail();
			$data['password'] = Hash::make($data['password']);

			$user = $this->repository->create($data);
			$user->assignRole($data['roles']);

			return $user;

		}catch (ValidatorException $e) {
		  return [
		  	'error' => true,
		    'message' => $e->getMessageBag()
		  ];
		}

	}



	public function update(array $data)
	{
		try{
			$this->validator->passesOrFail();
			return $this->repository->update($data);

		}catch (ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}

	}

}