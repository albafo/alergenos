<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
            $table->string('apellidos');
            $table->enum('tipo', ['admin', 'user'])->default('user');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->boolean('status')->default(true);
            $table->boolean('confirmed')->default(false);
            $table->string('email_confirmation', 60);
            $table->string('nombre_establ');
            $table->string('icono_estb');
            $table->timestamp('expired_at');	
			$table->rememberToken();
			$table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios');
	}

}
