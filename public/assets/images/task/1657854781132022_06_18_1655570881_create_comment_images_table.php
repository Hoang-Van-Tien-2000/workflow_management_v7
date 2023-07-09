<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentImagesTable extends Migration
{
    public function up()
    {
        Schema::create('comment_images', function (Blueprint $table) {

		$table->bigInteger('id',20)->unsigned();
		$table->bigInteger('comment_id',20);
		$table->string('url');
		$table->string('type');
		$table->string('name');
		$table->integer('status',11);
		$table->timestamp('created_at')->nullable()->default('NULL');
		$table->timestamp('updated_at')->nullable()->default('NULL');
		$table->timestamp('deleted_at')->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('comment_images');
    }
}