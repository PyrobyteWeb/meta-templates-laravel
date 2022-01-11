<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaTemplatesTables extends \Illuminate\Database\Migrations\Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('meta_templates');
        Schema::create('meta_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route_name');
            $table->tinyInteger('active')->default(1);
            $table->string('meta_title')->default('');
            $table->string('meta_keywords')->default('');
            $table->string('meta_description')->default('');
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
        Schema::dropIfExists('meta_templates');
    }
}
