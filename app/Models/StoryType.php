<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Story;

class StoryType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'story_type';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * get story name based on given story_id
     * @param $story_id
     */
    public static function get_story_name_by_story_id($story_id)
    {
        $story = Story::find($story_id);
        $story_type = self::find($story->story_type_id);
        return $story_type->type;
    }

}
