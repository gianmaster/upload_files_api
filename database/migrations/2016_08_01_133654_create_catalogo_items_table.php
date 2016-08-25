<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogoItemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalogo_items', function(Blueprint $table) {
            $table->increments('id');

			$table->boolean('estado')->default(true)->nullable(false);
			$table->string('descripcion')->nullable(false);
			$table->string('abreviatura')->nullable(false);
			$table->integer('orden')->default(0);

			$table->string('usuario_creacion')->nullable(false);
			$table->string('usuario_modificacion')->nullable(false);

			$table->integer('id_catalogo')->unsigned();
			$table->foreign('id_catalogo')->references('id')->on('catalogos')->onDelete('cascade')->onUpdate('cascade');

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
		Schema::dropIfExists('catalogo_items');
	}

}
