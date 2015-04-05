{"filter":false,"title":"2015_11_11_000000_create_alergenos_ingredientes_table.php","tooltip":"/database/migrations/2015_11_11_000000_create_alergenos_ingredientes_table.php","undoManager":{"mark":0,"position":0,"stack":[[{"group":"doc","deltas":[{"start":{"row":0,"column":0},"end":{"row":37,"column":0},"action":"insert","lines":["<?php","","use Illuminate\\Database\\Schema\\Blueprint;","use Illuminate\\Database\\Migrations\\Migration;","","class CreateAlergenosIngredientesTable extends Migration {","","\t/**","\t * Run the migrations.","\t *","\t * @return void","\t */","\tpublic function up()","\t{","\t\tSchema::create('alergenos_ingredientes', function(Blueprint $table)","\t\t{","            $table->increments('id');","\t\t\t$table->integer('ingrediente_id')->unsigned();","            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade')->onUpdate('cascade');","            $table->integer('alergeno_id')->unsigned();","            $table->foreign('alergeno_id')->references('id')->on('alergenos')->onDelete('cascade')->onUpdate('cascade');","            ","\t\t\t","\t\t});","\t}","","\t/**","\t * Reverse the migrations.","\t *","\t * @return void","\t */","\tpublic function down()","\t{","\t    Schema::drop('alergenos_ingredientes');","\t}","","}",""]}]}]]},"ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":37,"column":0},"end":{"row":37,"column":0},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1428142291994,"hash":"4fad7a285484cc3b97561cf6228eb9c6c75edc8c"}