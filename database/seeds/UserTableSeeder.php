<?php

use Illuminate\Database\Seeder;

use App\Entities\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = [
        	'name' => 'Fabio Pratta (DEV)',
	        'email' => 'dev@dev.com.br',
	        'password' => '$2y$10$ZAjEGcIlGCpy/EOh1myJuOZGjJj/Cq8sMaAYtM71A7AK5chOC7vQy',
	        'remember_token' => str_random(10),
        ];

        User::create($usuario);
    }
}
