<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentIdiomasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('content_idiomas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('content');
			$table->integer('idioma_id')->unsigned();
            $table->foreign('idioma_id')->references('id')->on('idiomas')->onDelete('cascade')->onUpdate('cascade');
           	$table->string('table_name');
			$table->integer('content_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('content_idiomas');
	}

}