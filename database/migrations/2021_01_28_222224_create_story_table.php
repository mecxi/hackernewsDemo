<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story', function (Blueprint $table) {
            $table->integer('id')->primary(); // the unique item ID that comes from the API.
            $table->string('title'); //  the title of the item. This is the field that we’ll be displaying later on in the news page.
            $table->string('by')->nullable(); //The username of the item's author.
            $table->integer('score')->unsigned()->nullable(); //the current ranking of the news.
            $table->tinyInteger('story_type_id')->nullable(); // Referencing story_type table |  The type of item. One of "job", "story", "comment", "poll", or "pollopt". referencing a foreign key
            $table->integer('comments_count')->nullable(); // In the case of stories or polls, the total comment count.
            $table->string('url')->nullable(); //the URL pointing to the full details of the news.
            $table->integer('date_created')->unsigned()->nullable(); //Creation date of the item, in Unix Time.
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
        Schema::dropIfExists('story');
    }
}
