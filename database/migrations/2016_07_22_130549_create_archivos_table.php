<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('archivos', function(Blueprint $table) {
            $table->increments('id');

			$table->string('uuid')->nullable(false);
			$table->string('client_id')->nullable(false);
			$table->string('referencia', 50)->nullable(false);
			$table->string('tipo', 50)->nullable(false);
			$table->string('nombre_real')->nullable(false);
			$table->string('nombre_asignado');
			$table->string('extension', 50)->nullable(false);
			$table->string('archivo', 500)->nullable(false);
			$table->string('content_type', 250)->nullable(false);
			$table->string('usuario', 50)->nullable(false);
			$table->boolean('estado')->default(true);

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
		Schema::dropIfExists('archivos');
	}

}
