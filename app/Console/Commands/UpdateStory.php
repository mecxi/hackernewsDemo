<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateStory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:story';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update story news items in the database from HackerNews API';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Our HackerNews Endpoints and base URI
     * @var array
     */
    private $endpoints = [
        'top' => '/v0/topstories.json',
        'new' => '/v0/newstories.json',
        'best' => '/v0/newstories.json'
    ];

    /**
     * Hackernews base uri
     * @var string
     */
    private $base_uri = 'https://hacker-news.firebaseio.com';

    /**
     * Our current http connection
     */
    private $connection;


    /**
     * @param  \GuzzleHttp\Client  $http
     */
    public function __construct(Client $http)
    {
        /* set the connection */
        $this->connection = new $http(['base_uri' => $this->base_uri]);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        foreach($this->endpoints as $type => $endpoint){
            /* fetch current stories ids */
            $response = $this->connection->get($endpoint);
            $result = $response->getBody();
            $data = collect(json_decode($result, true));

            /* limit data to the top 500 */
            $collection = collect($data);
            $slice = $collection->slice(0, 500);
            $items = $slice->all();

            /* fetch data for current story */
            if(!empty($items)){
                foreach($items as $story_id){
                    $story_data = $this->fetch_data($story_id);
                    if (!empty($story_data)){
                        $this->write_story_data_toDB($story_data, $type);
                        /* proceed to processing comments */
                        /* check if we have comments for the current story */
                        if (isset($story_data['kids'])){
                            foreach($story_data['kids'] as $comment_id){
                                /* fetch data for current comment id */
                                $comment_data = $this->fetch_data($comment_id);
                                if (!empty($comment_data)){
                                    $this->write_comment_data_toDB($comment_data, $story_data['id']);
                                }

                            }
                        }

                    }

                }
            }

        }

        return 0;
    }

    /**
     * fetch current story or comment
     * @param $id
     * @return array
     */
    private function fetch_data($id)
    {
        $item_res = $this->connection->get('/v0/item/'. $id.'.json');
        return json_decode($item_res->getBody(), true);
    }

    /**
     * process story data to DB
     * @param $data | current story data
     * @param $story_type | this can be news, top, best
     * @return int | null
     */
    private function write_story_data_toDB($data, $story_type)
    {
        /* prepare data */
        $item_data = [
            'id' => $data['id'],
            'title' => $data['title'],
            'by' => $data['by'],
            'score' => $data['score'],
            'comments_count' => isset($data['descendants']) ? $data['descendants'] : null,
            'date_created' => $data['time'],
        ];
        /* set story_type_id */
        $story_type_id = DB::table('story_type')->where('type', $story_type)->get(['id']);
        $item_data['story_type_id'] = $story_type_id[0]->id;
        /* set url if not empty */
        if (!empty($data['url'])){
            $item_data['url'] = $data['url'];
        }
        /* insert data */
        $current_data = DB::table('story')->where('id', $data['id'])->first();
        if (empty($current_data)){
            DB::table('story')->insert($item_data);
        }
    }

    /**
     * process comment data to DB
     * @param $data | current comment data
     * @param $depth | current comment traversing position
     * @param $story_id | current story
     * @return void
     */
    private function write_comment_data_toDB($data, $story_id, $depth=0)
    {
       /* process parent comment */
        $this->insert_comment_data_toDB($data, $story_id, $depth);

        /* process sub comments if available */
        if (isset($data['kids'])){
            foreach($data['kids'] as $sub_comment_id){
                $sub_comment_data = $this->fetch_data($sub_comment_id);
                if (!empty($sub_comment_data)){
                    $this->write_comment_data_toDB($sub_comment_data, $story_id, $depth + 1);
                }
            }
        }

    }

    /**
     * insert comment data to DB
     * @param $data | current comment data
     * @param $depth | current comment traversing position
     * @param $story_id | current story
     * @return void
     */
    private function insert_comment_data_toDB($data, $story_id, $depth=0)
    {
        /* prepare comment data */
        $item_data = [
            'id' => $data['id'],
            'story_id' => $story_id,
            'by' => isset($data['by']) ? $data['by'] : null,
            'messages' => isset($data['text']) ? $data['text']: null,
            'date_created' => $data['time'],
            'parent_id' => $depth ? $data['parent'] : 0,
            'lft' => 0,
            'rgt' => 0,
            'depth' => $depth
        ];

        /* insert data */
        $current_data = DB::table('story_comment')->where('id', $data['id'])->first();
        if (empty($current_data)){
            DB::table('story_comment')->insert($item_data);
        }
    }


}
