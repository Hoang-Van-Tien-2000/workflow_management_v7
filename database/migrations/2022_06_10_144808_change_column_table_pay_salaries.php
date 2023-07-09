<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTablePaySalaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pay_salaries', function (Blueprint $table) {
            $table->string('salary')->nullable()->change();
        });
        Schema::table('pay_salaries', function (Blueprint $table) {
            $table->string('allowance')->nullable()->change();
        });
        Schema::table('pay_salaries', function (Blueprint $table) {
            $table->string('total')->nullable()->change();
        });
        Schema::table('pay_salaries', function (Blueprint $table) {
            $table->string('advance')->nullable()->change();
        });
        Schema::table('pay_salaries', function (Blueprint $table) {
            $table->string('actual_salary')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
