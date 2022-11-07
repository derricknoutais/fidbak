<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fiche_renseignement_id');
            $table->string('nom');
            $table->unsignedInteger('handle_id')->nullable();
            $table->text('autreInfo')->nullable();
            $table->tinyInteger('stars')->default(0);
            $table->boolean('commandé')->default(0);
            $table->enum('état', ['enregistré', 'demandé', 'commandé', 'archivé'])->default('enregistré')->nullable();
            $table->foreign('fiche_renseignement_id')->references('id')->on('fiche_renseignements')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('articles');
    }
}
