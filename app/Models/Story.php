<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Story extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'story';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
    public function storyType()
    {
        return $this->belongsTo(StoryType::class, 'story_type_id');
    }

    /*
	|--------------------------------------------------------------------------
	| ACCESSORS
	|--------------------------------------------------------------------------
	*/

    /**
     * format the story date_created.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateCreatedAttribute($value)
    {
        return Carbon::createFromTimestamp($value)->diffForHumans();
    }

    /**
     * format the story url.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlAttribute($value)
    {
        return is_null($value) ? '/' : $value;
    }

    /**
     * format the story comment count
     */
    public function getCommentsCountAttribute($value)
    {
        return $value ? ($value > 1 ? ' | '. $value.' comments' : ' | '. $value.' comment' ) : '';
    }

}
