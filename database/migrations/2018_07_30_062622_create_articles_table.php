<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('source')->comment('来源');
            $table->tinyInteger('tags')->comment('标签');
            $table->tinyInteger('status')->default(0)->comment('状态 1禁用 2启用 详细WhetherConst');
            $table->tinyInteger('is_hide')->default(0)->comment('是否匿名 1是 2否 详细WhetherConst');
            $table->text('contents')->comment('内容');
            $table->integer('issuer')->comment('发布人');
            $table->index(['id', 'tags', 'issuer']);
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
        Schema::dropIfExists('articles');
    }
}