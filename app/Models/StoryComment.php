<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class StoryComment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'story_comment';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    protected $guarded = array('parent_id', 'lft', 'rgt', 'depth', 'created_at', 'updated_at');


    /**
     * get related comments for the given story_id
     * @param $story_id
     * @return null | array
     */

    public static function fetch_comments_related_story($story_id)
    {
        /* get comment_ids for the given story at parent level */
        $comment_ids = DB::table('story_comment')
            ->where('story_id', $story_id)
            ->where('parent_id', 0)->get(['id'])->toArray();

        $results = [];

        if (!empty($comment_ids)){
            foreach($comment_ids as $key => $comment){
                $compiled_messages = static::compile_comments_replies(static::fetch_comment_messages_and_replies($comment->id));

                /* add current comment to the result */
                $results[$key] = $compiled_messages;

                /* check current compiled messages for replies */
                if ($compiled_messages){
                    /* check for replies or nested data in replies */
                    if (count($compiled_messages['replies']) > 0){
                        static::update_compiled_replies($compiled_messages['replies'], $results[$key]['replies']);
                    }
                }
            }
        }

        return $results;
    }

    /**
     * Update related nested comments
     * @param $comments_replies | replied comments to the parent message
     * @param $results | to populate our result data
     */

    private static function update_compiled_replies($comments_replies, &$results)
    {
        /* check for replies or nested data in replies */
        foreach($comments_replies as $key => $reply){
            if (!is_null($reply)){
                $nested_data_comments = static::fetch_comment_messages_and_replies($reply['id']);
                $compiled_messages = null;
                if (!empty($nested_data_comments)){
                    $compiled_messages = static::compile_comments_replies($nested_data_comments);
                }

                /* add current comment to the result */
                $results[$key] = $compiled_messages;

                if ($compiled_messages){
                    if (count($compiled_messages['replies']) > 0){
                        static::update_compiled_replies($compiled_messages['replies'], $results[$key]['replies']);
                    }
                }
            }
        }
    }


    /**
     * For each comment_id, fetch a msg and its replies
     * @param $comment_id
     * @return array
     */
    private static function fetch_comment_messages_and_replies($comment_id)
    {
        return DB::select("SELECT
                    CONCAT(t1.id, '|', t1.messages, '|', t1.`by`, '|', t1.date_created) AS msg,
                    CONCAT(t2.id, '|', t2.messages, '|', t2.`by`, '|', t2.date_created) AS replies
                FROM
                    `story_comment` AS t1
                LEFT JOIN story_comment AS t2 ON t2.parent_id = t1.id
                WHERE
                t1.id = $comment_id");
    }

    /**
     * compile comments replies
     * @param $data_comments
     * @return array
     */
    private static function compile_comments_replies($data_comments)
    {
        $current_message = null;
        $current_replies = null;
        foreach($data_comments as $comment){
            $current_message = static::format_concatenatedResult($comment->msg);
            $current_replies[] = static::format_concatenatedResult($comment->replies);
        }
        /* add replies to the current message */
        $current_message['replies'] = $current_replies;

        return $current_message;
    }

    /**
     * format related comments result from DB which are concatenated using a pipe char `|`
     * to store related column values in a pivot result
     * format values as array
     * @param $message
     * @return null | array
     */
    private static function format_concatenatedResult($message)
    {
        $result = null;
        if (!is_null($message)){
            $message = explode('|', $message);
            if (!empty($message)){
                if (count($message) == 4){
                    $result = array(
                        'id' => $message[0],
                        'msg' => $message[1],
                        'by' => $message[2],
                        'date' => Carbon::createFromTimestamp($message[3])->diffForHumans()
                    );
                }
            }
        } return $result;
    }

}
