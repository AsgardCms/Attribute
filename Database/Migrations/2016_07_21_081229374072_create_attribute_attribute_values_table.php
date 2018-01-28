<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute__attribute_values', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('attribute_id')->unsigned();
            $table->string('entity_type');
            $table->integer('entity_id')->unsigned();
            $table->text('content');
            $table->timestamps();

            $table->index('attribute_id');
            $table->index('entity_type');
            $table->index('entity_id');
        });

        Schema::create('attribute__attribute_value_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('content');

            $table->integer('attribute_value_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['attribute_value_id', 'locale'], 'attribute__attribute_value_id_locale');
            $table->foreign('attribute_value_id', 'attribute__attribute_value_translations_id_foreign')->references('id')->on('attribute__attribute_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute__attribute_value_translations');
        Schema::dropIfExists('attribute__attribute_values');
    }
}
