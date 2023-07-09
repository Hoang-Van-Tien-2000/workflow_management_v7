<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaySalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('salary_id')->nullable();
            $table->float('working_day')->nullable();
            $table->bigInteger('salary')->nullable();
            $table->bigInteger('allowance')->nullable();
            $table->bigInteger('total')->nullable();
            $table->bigInteger('advance')->nullable();
            $table->bigInteger('actual_salary')->nullable();
            $table->string("month")->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_salaries');
    }
}
