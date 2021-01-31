<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Story;
use App\Models\StoryComment;
use App\Models\StoryType;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * return story view
     * @param $type |  story type
     * @return View
     */
    public function index($type='top')
    {
        /* fetch related stories */
        $stories = Story::whereHas('storytype', function(Builder $query) use ($type){
            $query->where('type', $type);
        })->get();

        $data = [
            'title' => $type. ' stories',
            'types' => ['Top', 'New', 'Best'],
            'stories' => $stories
        ];

        return view('home', $data);
    }

    /**
     * display comment view
     * @param $story_id
     * @return View
     */
    public function viewComments($story_id)
    {
        /* get current stories */
        $story = Story::find($story_id);
        /* get story type name based on the given story_id */
        $story_comments = StoryComment::fetch_comments_related_story($story_id);
        $story_type_name = StoryType::get_story_name_by_story_id($story_id);

        $data = [
            'title' => ucwords($story_type_name) . ' Stories Comments',
            'story' => $story,
            'types' => ['Top', 'New', 'Best'],
            'comments' => $story_comments
        ];

        return view('comments', $data);
    }



}
