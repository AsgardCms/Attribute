<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute__attribute_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('attribute_id')->unsigned();
            $table->string('key');
            $table->timestamps();

            $table->index('attribute_id');
            $table->index('key');
            $table->unique(['attribute_id', 'key']);
        });

        Schema::create('attribute__attribute_option_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label');

            $table->integer('attribute_option_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['attribute_option_id', 'locale'], 'attribute__attribute_option_id_locale');
            $table->foreign('attribute_option_id', 'attribute__attribute_option_translations_id_foreign')->references('id')->on('attribute__attribute_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute__attribute_option_translations');
        Schema::dropIfExists('attribute__attribute_options');
    }
}
