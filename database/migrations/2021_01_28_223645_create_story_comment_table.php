<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_comment', function (Blueprint $table) {
            $table->integer('id')->primary(); // The item's unique id.
            $table->integer('story_id')->nullable(); // The comment's parent
            $table->integer('parent_id')->unsigned()->nullable()->default(0); // parent reference when traversing data
            $table->string('by', 100)->nullable(); // The comment author
            $table->text('messages')->nullable(); // The comment message
            $table->integer('date_created')->unsigned()->nullable(); // The time the comment was created
            $table->integer('lft')->unsigned()->nullable()->default(0); // current data position when traversing data
            $table->integer('rgt')->unsigned()->nullable()->default(0); // current data position when traversing data
            $table->integer('depth')->unsigned()->nullable()->default(0); // current data position when traversing data
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
        Schema::dropIfExists('story_comment');
    }
}
