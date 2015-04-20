<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('peticion');
			$table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('set null')->onUpdate('cascade');
            $table->boolean('leido')->default(false);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickets');
	}

}
