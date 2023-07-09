<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {

		$table->id();
		$table->bigInteger('user_id');
		$table->string('name');
		$table->text('status');
		$table->text('type');
		$table->text('priority')->nullable();
		$table->date('starting')->nullable();
		$table->date('ending')->nullable();
		$table->text('size')->nullable();
		$table->text('rate')->nullable();
		$table->text('detail')->nullable();
		$table->timestamps();
        $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('works');
    }
}