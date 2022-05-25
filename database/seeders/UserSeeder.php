<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DB;
Use \Carbon\Carbon;

use Illuminate\Support\Facades\Hash;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $users = [
            [
                'name'=>'Haris',
                'email'=>'haris@larasoft.io',
                'password' => Hash::make(123456),
                'image' => null,
                'created_at' => Carbon::now()
            
            ],
            [
                'name'=>'Asad',
                'email'=>'asd@larasoft.io',
                'password' => Hash::make(123456),
                'image' => null,
                'created_at' => Carbon::now()

            ],                        
        ];
        
        User::insert($users); 
    }
}
