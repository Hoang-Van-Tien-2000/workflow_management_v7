<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('task_details', function (Blueprint $table) {

		$table->id();
		$table->bigInteger('task_id');
		$table->text('description');
		$table->bigInteger('assignee')->nullable();
		$table->bigInteger('reporter')->nullable();
		$table->text('lable')->nullable();
		$table->bigInteger('priority_id')->nullable();
		$table->integer('status');
		$table->timestamps();
        $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('task_details');
    }
}