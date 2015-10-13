<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkdayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workdays', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('arrival1');
            $table->time('leaving1');
            $table->time('arrival2')->nullable();
            $table->time('leaving2')->nullable();
            $table->time('arrival3')->nullable();
            $table->time('leaving3')->nullable();
            $table->time('workload')->default('08:00');
            $table->time('allowance')->default(0);

            $table->integer('user_id')
                ->unsigned()
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workdays', function(Blueprint $table) {
            $table->dropForeign('workdays_user_id_foreign');
        });

        Schema::drop('workdays');
    }
}
