<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('task_attachments', function (Blueprint $table) {

		$table->id();
		$table->bigInteger('task_id');
		$table->string('url');
		$table->string('type');
		$table->string('name');
		$table->integer('status');
		$table->timestamps();
        $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('task_attachments');
    }
}