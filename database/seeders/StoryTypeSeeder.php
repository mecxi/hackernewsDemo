<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = [
          ['type' => 'top'],
          ['type' => 'new'],
          ['type' => 'best']
        ];

        foreach($entries as $entry){
            DB::table('story_type')->insert($entry);
        }
    }
}
