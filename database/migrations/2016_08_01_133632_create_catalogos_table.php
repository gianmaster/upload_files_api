<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalogos', function(Blueprint $table) {
            $table->increments('id');

			$table->string('descripcion')->nullable(false);
			$table->boolean('estado')->default(true)->nullable(false);

			$table->string('usuario_creacion')->nullable(false);
			$table->string('usuario_modificacion')->nullable(false);

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
		Schema::dropIfExists('catalogos');
	}

}
