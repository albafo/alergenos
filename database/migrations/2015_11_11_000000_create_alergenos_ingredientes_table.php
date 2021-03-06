<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlergenosIngredientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alergeno_ingrediente', function(Blueprint $table)
		{
            $table->increments('id');
			$table->integer('ingrediente_id')->unsigned();
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('alergeno_id')->unsigned();
            $table->foreign('alergeno_id')->references('id')->on('alergenos')->onDelete('cascade')->onUpdate('cascade');
            
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('alergeno_ingrediente');
	}

}
