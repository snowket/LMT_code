<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLMTMigrationsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LMT_migrations_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('LMT_migrations_id')->unsigned()->index();

            $table->foreign('LMT_migrations_id')
                ->references('id')
                ->on('LMT_migrations')
                ->onDelete('cascade');

            $table->string('type');
            $table->string('name');
            $table->string('relationship')->nullable();
            $table->string('relationship_table');
            $table->string('relationship_on');
            $table->timestamps();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('LMT_migrations_fields');
    }
}
