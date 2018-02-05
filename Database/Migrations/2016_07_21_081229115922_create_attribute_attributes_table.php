<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute__attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('namespace');
            $table->string('slug');
            $table->string('type');
            $table->boolean('has_translatable_values');
            $table->boolean('is_enabled');
            $table->boolean('is_system');
            $table->timestamps();

            $table->unique(['namespace', 'slug']);
        });

        Schema::create('attribute__attribute_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();

            $table->integer('attribute_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['attribute_id', 'locale']);
            $table->foreign('attribute_id')->references('id')->on('attribute__attributes')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute__attribute_translations');
        Schema::dropIfExists('attribute__attributes');
    }
}
