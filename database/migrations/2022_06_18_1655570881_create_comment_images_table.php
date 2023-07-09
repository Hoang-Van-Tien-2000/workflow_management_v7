<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentImagesTable extends Migration
{
    public function up()
    {
        Schema::create('comment_images', function (Blueprint $table) {

		$table->id();
		$table->bigInteger('comment_id');
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
        Schema::dropIfExists('comment_images');
    }
}