<?php

namespace Database\Seeders;

use App\Models\Tag;
use DB;
use Str;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Tag::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $tags = [
            ['name'=>'IT'],
            ['name'=>'Politics'],
            ['name'=>'News'],
            ['name'=>'Games'],
            ['name'=>'Cooking'],
            ['name'=>'Crypto'],
           
            
        ];
        
        Tag::insert($tags); 
       
    }
}
