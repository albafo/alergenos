<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasPlatosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categoria_plato', function(Blueprint $table)
		{
            $table->increments('id');
			$table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('plato_id')->unsigned();
            $table->foreign('plato_id')->references('id')->on('platos')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('precio', 5, 2)->nullable();

			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('categoria_plato');
	}

}
