<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClientesTable.
 */
class CreateClientesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes', function(Blueprint $table) {
            $table->increments('id');
			$table->string('nome');
			$table->string('cnpj')->unique();
			$table->string('email')->unique();
			$table->string('telefone');
			$table->string('cep');
			$table->string('endereco');
			$table->string('bairro');
			$table->string('numero');
			$table->string('cidade');
			$table->string('estado');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes');
	}
}
